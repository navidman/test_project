@extends('dashboard::layouts.dashboard.master')

@section('title','لیست سوالات')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/questioncenter/images/icons/question-center.gif') }}"></span>
    <span class="text">لیست سوالات</span>
@endsection

@section('content')
    <section class="report-table">
        @if(count($QuestionCenter))
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="form-style small-filter">
                                <form action="{{ url('dashboard/question-center') }}" method="get" name="search">
                                    <div class="row align-items-end">
                                        <div class="col-3 field-block">
                                            <input class="text-input" value="@isset($_GET['search']){{ $_GET['search'] }}@endisset" id="search" type="text" name="search" placeholder="کلمه کلیدی را وارد نمایید">
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
                            <a href="{{ url('dashboard/question-center/create') }}" class="submit-form-btn">افزودن سوال جدید</a>
                        </div>
                    </div>
                </div>

                <div class="widget-content">
                    <form action="{{ url('dashboard/question-center/destroy') }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                        @csrf
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                @can('isAuthor')
                                    <th class="delete-col">
                                        <input class="select-all" type="checkbox">

                                    </th>
                                @endcan
{{--                                <th width="70">شناسه</th>--}}
                                <th>عنوان</th>
                                <th>دسته بندی</th>
                                <th>نویسنده</th>
                                <th>وضعیت</th>
                                <th>تاریخ انتشار</th>
                                @can('isAuthor')
                                    <th width="100px" class="center">عملیات</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($QuestionCenter as $item)

                                <tr>
                                    @can('isAuthor')
                                        <td class="delete-col">
                                            <input class="delete-checkbox" type="checkbox" name="delete_item[{{ $item->id }}]" value="1">
                                        </td>
                                    @endcan
{{--                                    <td class="num-fa">{{ $item->id }}</td>--}}
                                    <td class="cursor-pointer" onclick="window.location.href = '{{ url('dashboard/question-center/' . $item->id) }}/edit'">{{ $item->title }}</td>
                                    <td>@if(isset($item->question_category_tbl)){{ $item->question_category_tbl->title }}@else{{ 'دسته بندی نشده' }}@endif</td>
                                    <td>{{ $item->user_tbl->full_name }}</td>
                                    <td>@if($item->status == 'published'){{ 'منتشر شده' }}@else{{ 'پیش نویس' }}@endif</td>
                                    <td class="num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->publish_at ? $item->publish_at : $item->created_at)->format('H:i - Y/m/d') }}</td>
                                    @can('isAuthor')
                                        <td class="center">
                                            <a target="_blank" href="{{ url('question-center' . '/' . $item->slug) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a> <a href="{{ route('question-center.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-edit"></i></a>
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
{{--                                <th>شناسه</th>--}}
                                <th>عنوان</th>
                                <th>دسته بندی</th>
                                <th>نویسنده</th>
                                <th>وضعیت</th>
                                <th>تاریخ انتشار</th>
                                @can('isAuthor')
                                    <th width="100px" class="center">عملیات</th>
                                @endcan
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;" colspan="20">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            نمایش موارد {{ $QuestionCenter->firstItem() }} تا {{ $QuestionCenter->lastItem() }}
                                            از {{ $QuestionCenter->total() }} مورد (صفحه {{ $QuestionCenter->currentPage() }}
                                            از {{ $QuestionCenter->lastPage() }})
                                        </div>
                                        <div class="col-8 left">
                                            <div class="pagination-table">
                                                {{$QuestionCenter->links('vendor.pagination.default')}}
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
                <h2 class="my-5">هیچ موردی یافت نشد!</h2>
                <div class="create-item"><a href="{{ url()->current() }}/create">افزودن سوال جدید</a></div>
            </div>
        @endif
    </section>
@endsection
