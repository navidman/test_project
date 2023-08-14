@extends('dashboard::layouts.dashboard.master')

@section('title','رزومه پلاس ها')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/resumemanager/images/icons/resume.gif') }}"></span>
    <span class="text">رزومه پلاس ها</span>
@endsection

@section('content')
    <section class="report-table">
        @if(count($Resumes))
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="form-style small-filter">
                        <form action="{{ url('dashboard/resume-manager') }}" method="get" name="search">
                            <div class="row align-items-end">
                                <div class="col-3 field-block">
                                    <input class="text-input" value="@isset($_GET['search']){{ $_GET['search'] }}@endisset" id="search" type="text" name="search" placeholder="نام و نام خانوادگی را وارد نمایید">
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

                <div class="widget-content">
                    <form action="{{ url('dashboard/users/destroy') }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                        @csrf
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                @can('isAuthor')
                                    <th class="delete-col">
                                        <input class="select-all" type="checkbox">

                                    </th>
                                @endcan
                                <th>نام و نام خانوادگی</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت</th>
                                @can('isAuthor')
                                    <th width="100px" class="center">عملیات</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($Resumes as $item)

                                <tr>
                                    @can('isAuthor')
                                        <td class="delete-col">
                                            <input class="delete-checkbox" type="checkbox" name="delete_item[{{ $item->uid }}]" value="1">
                                        </td>
                                    @endcan
                                    <td class="cursor-pointer" onclick="window.location.href = '{{ url('dashboard/resume-manager/' . $item->id) }}/edit'">{{ $item->user_tbl->full_name }}</td>
                                    <td>@if($item->status == 'new'){{ 'جدید' }}@elseif($item->status == 'pending_operator'){{ 'در انتظار بررسی اپراتور' }}@elseif($item->status == 'pending_job_seeker'){{ 'در انتظار تایید کارجو' }}@elseif($item->status == 'job_seeker_reject'){{ 'رد توسط کارجو' }}@elseif($item->status == 'accept_job_seeker'){{ 'تایید توسط کارجو' }}@endif</td>
                                    <td class="num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->publish_at ? $item->publish_at : $item->created_at)->format('H:i - Y/m/d') }}</td>
                                    @can('isAuthor')
                                        <td class="center">
                                            <a href="{{ route('resume-manager.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-edit"></i></a>
                                        </td>
                                    @endcan
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
                                <th>نام و نام خانوادگی</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت</th>
                                @can('isAuthor')
                                    <th width="100px" class="center">عملیات</th>
                                @endcan
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;" colspan="20">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            نمایش موارد {{ $Resumes->firstItem() }} تا {{ $Resumes->lastItem() }}
                                            از {{ $Resumes->total() }} مورد (صفحه {{ $Resumes->currentPage() }}
                                            از {{ $Resumes->lastPage() }})
                                        </div>
                                        <div class="col-8 left">
                                            <div class="pagination-table">
                                                {{$Resumes->links('vendor.pagination.default')}}
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
            </div>
        @endif
    </section>
@endsection
