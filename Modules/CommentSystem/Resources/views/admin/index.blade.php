@extends('dashboard::layouts.dashboard.master')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/commentsystem/images/icons/comment.gif') }}"></span>
    <span class="text">لیست دیدگاه ها</span>
@endsection

@section('content')
    <section class="report-table">
        @if(count($CommentSystem))
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="form-style small-filter">
                                <form action="{{ url('dashboard/comment') }}" method="get" name="search">
                                    <div class="row align-items-end">
                                        <div class="col-3 field-block">
                                            <input class="text-input" value="@isset($_GET['search']){{ $_GET['search'] }}@endisset" id="search" type="text" name="search" placeholder="نام و یا ایمیل کاربر را وارد نمایید">
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
                    <form action="{{ url('dashboard/comment/destroy') }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
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
                                <th>نام</th>
                                <th>در بخش</th>
                                <th>وضعیت</th>
                                <th width="500">متن پیام</th>
                                <th>تاریخ انتشار</th>
                                @can('isAdmin')
                                    <th width="80px" class="center">عملیات</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($CommentSystem as $item)
                                <tr class="@if($item->status == 'new'){{ 'new-record' }}@endif">
                                    @can('isAdmin')
                                        <td class="delete-col">
                                            <input class="delete-checkbox" type="checkbox" name="delete_item[{{ $item->id }}]" value="1">
                                        </td>
                                    @endcan
                                    <td class="num-fa">{{ $item->id }}</td>
                                    <td class="text-capitalize">@isset($item->uid)@if(\Modules\Users\Entities\Users::find($item->uid)->first()->role != 'user') <span class="zmdi zmdi-account"></span> @endif @endif @if(isset($item->parent_id)) <span class="zmdi zmdi-mail-reply"></span> @endif {{ $item->name }}</td>
                                    <td class="text-capitalize">{{ $item->post_type == 'blog' ? 'وبلاگ' : $item->post_type }}</td>
                                    <td @class([ 'text-capitalize', 'text-danger' => $item->status == 'new', 'text-success' => $item->status == 'accepted'])>@if($item->status == 'new'){{'جدید'}}@elseif($item->status == 'reject'){{'رد دیدگاه'}}@elseif($item->status == 'viewed'){{'در انتظار تایید'}}@elseif($item->status == 'accepted'){{'تایید شده'}}@endif</td>
                                    <td dir="auto">{{ \App\Http\Controllers\HomeController::TruncateString($item->message, 200, 1) }}</td>
                                    <td class="num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->created_at)->format('H:i - Y/m/d') }}</td>
                                    @can('isAdmin')
                                        <td class="center">
                                            <a href="{{ route('comment.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-edit"></i></a>
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
                                <th>نام</th>
                                <th>در بخش</th>
                                <th>وضعیت</th>
                                <th>متن پیام</th>
                                <th>تاریخ انتشار</th>
                                @can('isAdmin')
                                    <th width="80px" class="center">عملیات</th>
                                @endcan
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;" colspan="20">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            نمایش موارد {{ $CommentSystem->firstItem() }}
                                            تا {{ $CommentSystem->lastItem() }}
                                            از {{ $CommentSystem->total() }} مورد
                                            (صفحه {{ $CommentSystem->currentPage() }}
                                            از {{ $CommentSystem->lastPage() }})
                                        </div>
                                        <div class="col-8 left">
                                            <div class="pagination-table">
                                                {{$CommentSystem->links('vendor.pagination.default')}}
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
