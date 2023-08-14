@extends('dashboard::layouts.dashboard.master')

@section('title','مدیریت دپارتمان ها')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/supportsystem/images/icons/category.gif') }}"></span>
    <span class="text">مدیریت دپارتمان ها</span>
    <span class="desc">پشتیبانی</span>
@endsection

@section('content')
    <section class="report-table product-cat-pages">
        <div class="row">
            <div class="col-4 create-col form-section">
                <div class="widget-block widget-item widget-style">
                    <div class="heading-widget">
                        <span class="widget-title">افزودن دپارتمان جدید</span>
                    </div>
                    <div class="widget-content widget-content-padding">
                        <form action="{{ route('support-departments.store') }}" method="POST">
                            @csrf
                            <div class="form-group row no-gutters">
                                @if($errors->has('title'))
                                    <span class="col-12 message-show">{{ $errors->first('title') }}</span>
                                @endif
                                {!! Form::text('title',null,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان دپارتمان را وارد نمایید']) !!}
                                {!! Form::label('title','عنوان دپارتمان:',['class'=>'col-12']) !!}
                            </div>
                            <div class="form-group row no-gutters">
                                @if($errors->has('slug'))
                                    <span class="col-12 message-show">{{ $errors->first('slug') }}</span>
                                @endif
                                {!! Form::text('slug',null,[ 'id'=>'slug' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'شناسه دپارتمان را وارد نمایید']) !!}
                                {!! Form::label('slug','شناسه دپارتمان:',['class'=>'col-12']) !!}
                            </div>
                            <button type="submit" class="submit-form-btn ">افزودن دپارتمان جدید</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                @if(count($Departments))
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <span class="widget-title">دپارتمان ها</span>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content">
                            <form action="{{ route('support.departments.destroy') }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                                @csrf
                                <table class="table align-items-center">
                                    <thead>
                                    <tr>
                                        <th class="delete-col">
                                            <input class="select-all" type="checkbox">
                                        </th>
                                        <th>عنوان</th>
                                        <th>نامک</th>
                                        <th class="center">تعداد تیکت ها</th>
                                        <th width="80" class="center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($Departments as $item)
                                        <tr>
                                            <td class="delete-col">
                                                <input class="delete-checkbox" type="checkbox" name="delete_item[{{ $item->id }}]" value="1">
                                            </td>
                                            <td>{{ $item->title }}</td>
                                            <td dir="ltr">{{ $item->slug }}</td>
                                            <td class="center num-fa">{{ $item->support_tbl() }}</td>
                                            @can(['isAuthor'])
                                                <td class="center">
                                                    <a href="{{ route('support-departments.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-edit"></i></a>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot class="num-fa">
                                    <tr class="titles">
                                        @can(['isAuthor'])
                                            <th class="delete-col">
                                                <button class="table-btn table-btn-icon table-btn-icon-delete">
                                                    <span><img src="{{ asset('public/modules/dashboard/admin/img/base/icons') }}/trash.svg" alt="شناسه" title="حذف"></span>
                                                </button>
                                            </th>
                                        @endcan
                                        <th>عنوان</th>
                                        <th>نامک</th>
                                        <th class="center">تعداد تیکت ها</th>
                                        <th width="80" class="center">عملیات</th>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;" colspan="8">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col-2">
                                                    {{ $Departments->total() }} مورد
                                                </div>
                                                <div class="col-10 left">
                                                    <div class="pagination-table">
                                                        {{$Departments->appends(request()->input())->links('vendor.pagination.default')}}
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
                        <div class="icon">
                            <img src="{{ asset('public/modules/dashboard/admin/img/base/icons') }}/no-item.svg">
                        </div>
                        <h2>هیچ موردی یافت نشد!</h2>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
