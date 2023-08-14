@extends('dashboard::layouts.dashboard.master')

@section('title','پیشنهاد کارشناس تاپلیکنت')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/employmentadvertisement/images/icons/advertisement.gif') }}"></span>
    <span class="text">پیشنهاد کارشناس تاپلیکنت
        <span class="desc">{{ $Ads->title }} / {{ $Ads->user_tbl->company_name_fa }}</span>
    </span>
@endsection

@section('content')
    @if(count($Resumes))
        <section class="form-section">
            <form action="{{ route('expert_ads.store', $Ads->id) }}" method="post">
                @csrf
                {{ method_field('PUT') }}

                <div class="widget-block widget-item widget-style">
                    <div class="heading-widget">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <span class="widget-title">لیست کارجویان با مهارت <span class="badge-secondary px-2 border-radius-px-4 ml-1 d-inline-block">{{ $AdsProficiency->title }}</span> <span class="badge-secondary px-2 border-radius-px-4 ml-1 d-inline-block">@switch($Ads->gender) @case('male'){{'آقا'}}@break @case('female'){{'خانم'}}@break @default{{'خانم و اقا'}}@endswitch</span></span>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="submit-form-btn create-btn px-4">پیشنهاد به کارفرما</button>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content">
                        <div class="multi-check-items">
                            @csrf
                            <table class="table align-items-center">
                                <thead>
                                <tr>
                                    @can('isAuthor')
                                        <th class="border-top-0 delete-col">
                                            <input class="select-all" type="checkbox">
                                        </th>
                                    @endcan
                                    <th class="border-top-0">نام و نام خانوادگی</th>
                                    <th class="border-top-0">کارفرما</th>
                                    <th class="border-top-0">وضعیت</th>
                                    <th class="border-top-0">تاریخ ثبت</th>
                                    @can('isAuthor')
                                        <th width="100px" class="border-top-0 center">عملیات</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($Resumes as $item)
                                    <tr>
                                        @can('isAuthor')
                                            <td class="delete-col">
                                                <input class="delete-checkbox" type="checkbox" name="resume[{{ $item->id }}]" value="1">
                                            </td>
                                        @endcan
                                        <td class="cursor-pointer" onclick="window.location.href = '{{ url('dashboard/resume-manager/' . $item->id) }}/edit'">{{ $item->user_tbl->full_name }}</td>
                                        <td class="cursor-pointer" onclick="window.location.href = '{{ url('dashboard/company/' . $item->id) }}/edit'">{{ $item->employment_tbl->company_name_fa }}</td>
                                        <td>@if($item->status == 'new'){{ 'جدید' }}@elseif($item->status == 'pending_operator'){{ 'در انتظار بررسی اپراتور' }}@elseif($item->status == 'pending_job_seeker'){{ 'رد شد' }}@elseif($item->status == 'accept'){{ 'تایید شده' }}@elseif($item->status == 'rejected'){{ 'رد شد' }}@endif</td>
                                        <td class="num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->publish_at ? $item->publish_at : $item->created_at)->format('H:i - Y/m/d') }}</td>
                                        @can('isAuthor')
                                            <td class="center">
                                                <a target="_blank" href="{{ route('resume-manager.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot class="num-fa">
                                <tr class="titles">
                                    @can('isAuthor')
                                        <th class="delete-col">
                                        </th>
                                    @endcan
                                    <th>نام و نام خانوادگی</th>
                                    <th>کارفرما</th>
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
                        </div>
                    </div>
                </div>
            </form>
        </section>
    @endif

@endsection
