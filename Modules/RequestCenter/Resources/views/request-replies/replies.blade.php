@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','مشاهد تیکت')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/supportsystem/images/icons/support.gif') }}"></span>
    <span class="text">مشاهد تیکت</span>
@endsection

@section('content')
    <section class="form-section">
        <div class="widget-block widget-item widget-style support-block">
            <div class="heading-widget">
                <div class="row align-items-center num-fa">
                    <div class="col-8 widget-title">{{ $RequestReceived->full_name }} - {{ $RequestReceived->role }}</div>
                    <div class="col-4 left">{{ \Morilog\Jalali\Jalalian::forge($RequestReceived->created_at)->format('Y/m/d - H:i') }}</div>
                </div>
            </div>

            <div class="widget-content widget-content-padding">
                <div class="ticket-content">
                    {{ $RequestReceived->title }}
                </div>
            </div>
        </div>

        <form action="{{ route('request-replies.store', $RequestReceived->id) }}" method="POST" enctype="multipart/form-data">
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="row">
                        <div class="col-9">
                            <span class="widget-title">ارسال پاسخ</span>
                        </div>
                        <div class="col-3 left"></div>
                    </div>
                </div>

                <div class="widget-content widget-content-padding">
                    @csrf

                    <div class="form-group">
                        <textarea class="field-style input-text" id="content_text" name="content_text" placeholder="متن پاسخ را وارد نمایید">{{ old('content_text') }}</textarea>
                        @if($errors->has('content_text'))
                            <span class="message-show">{{ $errors->first('content_text') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="answer-question text-field-repeater">
                            <div class="field-list" id="repeat_list"></div>
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <label for="attachments" class="add-field center text-light" id="addRepeatItem">
                                        <span class="icon-plus"></span>افزودن فایل
                                        <input type="file" class="d-none" name="attachments" id="attachments">
                                    </label>
                                </div>

                                <div class="col-4">
                                    <button type="submit" class="submit-form-btn create-btn">ارسال پاسخ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @forelse($RequestReplies as $item)
            <div class="widget-block widget-item widget-style support-block">
                <div class="heading-widget">
                    <div class="row align-items-center">
                        <div class="col"><span class="widget-title">{{ $item->full_name }}</span></div>
                        <div class="col-4 text-right num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->created_at)->format('H:i - Y/m/d') }}</div>
                        <div class="col-auto">
                            <form action="{{ route('request-replies.destroy', $item->id) }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                                @csrf
                                <button @class('delete-item')><i class="zmdi zmdi-delete"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-padding">
                    <div class="ticket-content">
                        {!! $item->content_text !!}
                    </div>

                    @if($item->attachments || $item->voice)
                        <br/>
                        <div class="attachments pt-3 mt-3">
                            <strong class="d-inline-block">فایل های پیوست شده:</strong>

                            @if($item->attachments)
                                <div class="attachments-item">
                                    <a href="{{ $item->attachments_path }}" download="{{ $item->attachments_path }}" class="">فایل پیوست</a>
                                </div>
                            @endif
                            @if($item->voice)
                                <div class="attachments-item">
                                    <a href="{{ $item->voice_path }}" download="{{ $item->voice_path }}" class="">فایل ویس</a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @empty
        @endforelse
    </section>

@endsection

@section('footer')
@endsection
