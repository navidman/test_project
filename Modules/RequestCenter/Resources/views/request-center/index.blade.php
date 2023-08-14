@extends('dashboard::layouts.dashboard.master')

@section('title','لیست درخواست ها')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/requestcenter/images/icons/request.gif') }}"></span>
    <span class="text">لیست درخواست ها</span>
@endsection

@section('content')
    <section class="report-table">
        @if(count($RequestCenter))
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="form-style small-filter">
                                <form action="{{ url('dashboard/request-center') }}" method="get" name="search">
                                    <div class="row align-items-end">
                                        <div class="col-3 field-block">
                                            <input class="text-input" value="@isset($_GET['search']){{ $_GET['search'] }}@endisset" id="search" type="text" name="search" placeholder="شناسه درخواست را وارد نمایید">
                                        </div>

                                        <div class="col-auto submit-field">
                                            <button type="submit">
                                                <span class="zmdi zmdi-search"></span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-2 left">
                            <a href="{{ url('dashboard/request-center/create') }}" class="submit-form-btn">ایجاد درخواست</a>
                        </div>
                    </div>
                </div>

                <div class="widget-content">
                    <form action="{{ url('dashboard/request-center/destroy') }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                        @csrf
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                @can('isAuthor')
                                    <th class="delete-col">
                                        <input class="select-all" type="checkbox">

                                    </th>
                                @endcan
                                <th>شناسه</th>
                                <th>موضوع</th>
                                <th>هزینه</th>
                                <th>درخواست ها</th>
                                <th>تاریخ</th>
                                <th class="center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($RequestCenter as $item)
                                <tr @class(['new-record' => $item->status == 'new'])>
                                    @can('isAuthor')
                                        <td class="delete-col">
                                            <input class="delete-checkbox" type="checkbox" name="delete_item[{{ $item->id }}]" value="1">
                                        </td>
                                    @endcan
                                    <td>{{ $item->id }}</td>
                                    <td>{{ \App\Http\Controllers\HomeController::TruncateString($item->title, 50, 1) }}</td>
                                    <td class="num-fa">@if($item->amount){{ $item->amount }} تاپلی @else بدون هزینه @endif</td>
                                    <td class="num-fa">{{ $item->received_tbl()->where(function($query) {return $query->where('status', '=', 'new')->orWhere('status', '=', 'replied');})->get()->count() }}</td>
                                    <td class="num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->created_at)->format('H:i - Y/m/d') }}</td>
                                    <td class="center">
                                        <a href="{{ route('request-center.received', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a>
                                        <a href="{{ route('request-center.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot class="num-fa">
                            <tr class="titles">
                                @can('isAuthor')
                                    <th class="delete-col">
                                        <button class="table-btn table-btn-icon table-btn-icon-delete">
                                            <span><img src="{{ asset('public/modules/dashboard/admin/img/base/icons/trash.svg') }}" alt="شناسه" title="حذف"></span>
                                        </button>
                                    </th>
                                @endcan
                                <th>شناسه</th>
                                <th>موضوع</th>
                                <th>هزینه</th>
                                <th>درخواست ها</th>
                                <th>تاریخ</th>
                                <th class="center">عملیات</th>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;" colspan="20">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            نمایش موارد {{ $RequestCenter->firstItem() }} تا {{ $RequestCenter->lastItem() }}
                                            از {{ $RequestCenter->total() }} مورد (صفحه {{ $RequestCenter->currentPage() }}
                                            از {{ $RequestCenter->lastPage() }})
                                        </div>
                                        <div class="col-8 left">
                                            <div class="pagination-table">
                                                {{$RequestCenter->links('vendor.pagination.default')}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </form>

                </div>
            </div>
        @else
            <div class="widget-block widget-item widget-style center no-item">
                <div class="icon"><img src="{{ asset('public/modules/dashboard/admin/img/base/icons/no-item.svg') }}"></div>
                <h2>هیچ موردی یافت نشد!</h2>
                <div class="create-item"><a href="{{ url()->current() }}/create">افزودن درخواست جدید</a></div>
            </div>
        @endif
    </section>
@endsection
