@extends('dashboard::layouts.dashboard.master')

@section('title','لیست تیکت ها')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/supportsystem/images/icons/support.gif') }}"></span>
    <span class="text">لیست تیکت ها</span>
@endsection

@section('content')
    <section class="report-table">
        @if(count($Support))
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="form-style small-filter">
                                <form action="{{ url('dashboard/support') }}" method="get" name="search">
                                    <div class="row align-items-end">
                                        <div class="col-3 field-block">
                                            <input class="text-input" value="@isset($_GET['search']){{ $_GET['search'] }}@endisset" id="search" type="text" name="search" placeholder="شناسه تیکت را وارد نمایید">
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
                            <a href="{{ url('dashboard/support/create') }}" class="submit-form-btn">ایجاد تیکت</a>
                        </div>
                    </div>
                </div>

                <div class="widget-content">
                    <form action="{{ url('dashboard/support/destroy') }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
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
                                <th>دپارتمان</th>
                                <th>وضعیت</th>
                                <th>اولویت</th>
                                <th>تاریخ</th>
                                <th class="center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($Support as $item)
                                <tr @class(['new-record' => $item->status == 'new'])>
                                    @can('isAuthor')
                                        <td class="delete-col">
                                            <input class="delete-checkbox" type="checkbox" name="delete_item[{{ $item->id }}]" value="1">
                                        </td>
                                    @endcan
                                    <td>{{ $item->id }}</td>
                                    <td>{{ \App\Http\Controllers\HomeController::TruncateString($item->title, 50, 1) }}</td>
                                    <td>@if(isset($item->department_tbl)){{ $item->department_tbl->title }}@else{{ 'دسته بندی نشده' }}@endif</td>
                                    <td style="@if($item->status == 'new'){{'color: #f00'}}@elseif($item->status == 'closed'){{'color: #888'}}@endif">{{ \App\Http\Controllers\HomeController::ConvertSupportStatus($item->status) }}</td>
                                    <td style="@if($item->priority == 'high'){{'color: #f00'}}@elseif($item->priority == 'medium'){{'color: #f7b011'}}@endif">{{ \App\Http\Controllers\HomeController::ConvertSupportPriority($item->priority) }}</td>
                                    <td class="num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->created_at)->format('H:i - Y/m/d') }}</td>
                                    <td class="center">
                                        <a href="{{ route('support.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-edit"></i></a>
                                        <a title="پاسخ به تیکت" href="{{ url('dashboard/support-ticket' . '/' . $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-comment-text"></i></a>
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
                                <th>دپارتمان</th>
                                <th>وضعیت</th>
                                <th>اولویت</th>
                                <th>تاریخ</th>
                                <th class="center">عملیات</th>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;" colspan="20">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            نمایش موارد {{ $Support->firstItem() }} تا {{ $Support->lastItem() }}
                                            از {{ $Support->total() }} مورد (صفحه {{ $Support->currentPage() }}
                                            از {{ $Support->lastPage() }})
                                        </div>
                                        <div class="col-8 left">
                                            <div class="pagination-table">
                                                {{$Support->links('vendor.pagination.default')}}
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
                <div class="create-item"><a href="{{ url()->current() }}/create">افزودن تیکت جدید</a></div>
            </div>
        @endif
    </section>
@endsection
