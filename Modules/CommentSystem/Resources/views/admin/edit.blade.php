@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/commentsystem/images/icons/comment.gif') }}"></span>
    <span class="text">مشاهده دیدگاه</span>
@endsection

@section('content')
    <section class="form-section contact-show">
        <form action="{{ route('comment.update', $CommentSystem->id) }}" method="post" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @csrf
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row align-items-end">
                                <div class="col-9">
                                    <span class="widget-title">مشاهده دیدگاه</span>
                                </div>
                                <div class="col-3 left num-fa">{{ \Morilog\Jalali\Jalalian::forge($CommentSystem->created_at)->format('Y/m/d - H:i:s') }}</div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding">
                            <div class="row">
                                <div class="col-6">
                                    <div class="item-info">
                                        <div class="item-label">نام و نام خانوادگی</div>
                                        <div class="item-value">{{ $CommentSystem->name }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-info">
                                        <div class="item-label">ایمیل</div>
                                        <div class="item-value">{{ $CommentSystem->email }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                    <div class="item-info">
                                        <div class="item-label">متن پیام</div>
                                        <div class="item-value">{{ $CommentSystem->message }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    {{-- Publish Options --}}
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <span class="widget-title">ثبت اطلاعات</span>
                        </div>

                        <div class="widget-content widget-content-padding widget-content-padding-side">
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style custom-select-field">
                                    <select class="form-control" name="status" id="status">
                                        <option value="">یک مورد را انتخاب کنید</option>
                                        <option selected value="accepted" @selected(old("status", $CommentSystem->status) == "accepted")> پذیرفتن</option>

                                        <option value="reject" @selected(old("status", $CommentSystem->status) == "reject")> رد دیدگاه</option>

                                        <option value="viewed" @selected(old("status", $CommentSystem->status) == "viewed")> در انتظار تایید</option>
                                    </select>
                                </div>

                                {{-- انتشار --}}
                                {!! Form::label('status','وضعیت دیدگاه',['class'=>'col-12']) !!}
                            </div>

                            <button type="submit" class="submit-form-btn">بروزرسانی اطلاعات</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection
