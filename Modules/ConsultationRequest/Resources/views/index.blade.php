@extends('dashboard::layouts.dashboard.master')

@section('title','لیست تماس ها')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/consultationrequest/images/icons/mobile.gif') }}"></span>
    <span class="text">لیست تماس ها</span>
@endsection

@section('content')
    <section class="report-table">
        @if(count($ConsultationRequest))
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="form-style small-filter">
                                <form action="{{ url('dashboard/consultation-request') }}" method="get" name="search">
                                    <div class="row align-items-end">
                                        <div class="col-3 field-block">
                                            <input class="text-input" value="@isset($_GET['search']){{ $_GET['search'] }}@endisset" id="search" type="text" name="search" placeholder="نام یا ایمیل را وارد نمایید">
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
                        </div>
                    </div>
                </div>

                <div class="widget-content">
                    <form action="{{ url('dashboard/customer-branding/destroy') }}" method="post">
                        @csrf
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                @can('isAdmin')
                                    <th class="delete-col">
                                        <input class="select-all" type="checkbox">
                                    </th>
                                @endcan
                                <th width="70">شناسه</th>
                                <th>نام و نام خانوادگی</th>
                                <th>موضوع</th>
                                <th>ایمیل</th>
                                <th>وضعیت</th>
                                <th>تاریخ انتشار</th>
                                @can('isAdmin')
                                    <th width="80px" class="center">عملیات</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ConsultationRequest as $item)
                                <tr @class(['new-record' => $item->status == 'new'])>
                                    @can('isAdmin')
                                        <td class="delete-col">
                                            <input class="delete-checkbox" type="checkbox" name="delete_item[{{ $item->id }}]" value="1">
                                        </td>
                                    @endcan
                                    <td class="num-fa">{{ $item->id }}</td>
                                    <td class="text-capitalize">{{ $item->name }}</td>
                                    <td class="text-capitalize">{{ $item->title }}</td>
                                    <td>{{ $item->email}}</td>
                                    <td @class([ 'text-capitalize', 'text-danger' => $item->status == 'new', 'text-success' => $item->status == 'viewed'])>{{ $item->status == 'new' ? 'جدید' : ( $item->status == 'viewed' ? 'مشاهده شده' : $item->status ) }}</td>
                                    <td class="num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->created_at)->format('H:i - Y/m/d') }}</td>
                                    @can('isAdmin')
                                        <td class="center">
                                            <a href="{{ route('consultation-request.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot class="num-fa">
                            <tr class="titles">
                                @can('isAdmin')
                                    <th class="delete-col">
                                        <button class="table-btn table-btn-icon table-btn-icon-delete">
                                            <span><img src="{{ asset('public/modules/dashboard/admin/img/base/icons/trash.svg') }}" alt="شناسه" title="حذف"></span>
                                        </button>
                                    </th>
                                @endcan
                                <th>شناسه</th>
                                <th>نام و نام خانوادگی</th>
                                <th>موضوع</th>
                                <th>ایمیل</th>
                                <th>وضعیت</th>
                                <th>تاریخ انتشار</th>
                                @can('isAdmin')
                                    <th width="80px" class="center">عملیات</th>
                                @endcan
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;" colspan="20">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            نمایش موارد {{ $ConsultationRequest->firstItem() }}
                                            تا {{ $ConsultationRequest->lastItem() }}
                                            از {{ $ConsultationRequest->total() }} مورد
                                            (صفحه {{ $ConsultationRequest->currentPage() }}
                                            از {{ $ConsultationRequest->lastPage() }})
                                        </div>
                                        <div class="col-8 left">
                                            <div class="pagination-table">
                                                {{$ConsultationRequest->links('vendor.pagination.default')}}
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
                <div class="icon"><img src="{{ asset('public/modules/dashboard/admin/img/base/icons/no-item.svg') }}">
                </div>
                <h2>هیچ موردی یافت نشد!</h2>
            </div>
        @endif
    </section>
@endsection
