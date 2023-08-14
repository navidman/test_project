@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','بررسی تیکت')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/supportsystem/images/icons/support.gif') }}"></span>
    <span class="text">بررسی تیکت</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('support.update', $Support->id) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">محتوای تیکت</span>
                                </div>
                                <div class="col-3 left">
                                    <a class="show-all" href="{{ route('support.create') }}">ایجاد تیکت جدید</a>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group row no-gutters">
                                @if($errors->has('title'))
                                    <span class="col-12 message-show">{{ $errors->first('title') }}</span>
                                @endif
                                {!! Form::text('title',$Support->title,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'موضوع تیکت را وارد نمایید']) !!}
                                {!! Form::label('title','موضوع تیکت:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('ticket_content','متن تیکت') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea class="field-style input-text" id="ticket_content" name="ticket_content" placeholder="متن تیکت را وارد نمایید">{!! old('ticket_content', $Support->ticket_content) !!}</textarea>
                                @if($errors->has('ticket_content'))
                                    <span class="col-12 message-show">{{ $errors->first('ticket_content') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="answer-question text-field-repeater">
                                    <div class="mb-3">فایل های پیوست شده:</div>
                                    <div class="field-list" id="repeat_list">
                                        @php $attachmentKey = 1 @endphp
                                        @forelse($Attachments as $item)
                                            <div id="field-repeat-item-{{ $attachmentKey }}">
                                                <div class="text-field px-3">
                                                    <a href="{{ url($item['path']) }}" download="{{ $item['name'] }}" class="">{{ $item['name'] }}</a>
                                                    <input type="hidden" name="current_attachment[]" value="{{ $item['id'] }}"/>
                                                    <span class="delete-row icon-close" onclick="delete_item({{ $attachmentKey }})">
                                                        <span class="zmdi zmdi-close-circle"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            @php $attachmentKey += 1 @endphp
                                        @empty
                                        @endforelse
                                    </div>
                                    <div class="add-field center" id="addRepeatItem">
                                        <span class="icon-plus"></span>افزودن فایل
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
                            <div class="row align-items-center">
                                <div @class('col')><span class="widget-title">بروزرسانی اطلاعات</span></div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding widget-content-padding-side">
                            {{-- Department --}}
                            <div class="form-group row no-gutters">
                                {!! Form::label('department','دپارتمان:',['class'=>'col-12']) !!}
                                <select data-placeholder="یک مورد را انتخاب کنید..." class="select chosen-rtl" name="department" id="department">
                                    <option></option>
                                    @forelse($SupportDepartments as $item)
                                        <option value="{{ $item->id }}" @selected(old('department' , $Support->department)== $item->id)>{{ $item->title }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @if($errors->has('department'))
                                    <span class="col-12 message-show">{{ $errors->first('department') }}</span>
                                @endif
                            </div>

                            {{-- Periority --}}
                            <div class="form-group row no-gutters">
                                {!! Form::label('priority','اولویت',['class'=>'col-12']) !!}

                                <select data-placeholder="یک مورد را انتخاب کنید..." class="select chosen-rtl" name="priority" id="priority">
                                    <option></option>
                                    <option value="high" @selected(old(
                                    'priority', $Support->priority)== 'high')>زیاد</option>
                                    <option value="medium" @selected(old(
                                    'priority', $Support->priority)== 'medium')>متوسط</option>
                                    <option value="low" @selected(old(
                                    'priority', $Support->priority)== 'low')>کم</option>
                                </select>
                                @if($errors->has('priority'))
                                    <span class="col-12 message-show">{{ $errors->first('priority') }}</span>
                                @endif
                            </div>

                            {{-- Users --}}
                            <div class="form-group row no-gutters">
                                {!! Form::label('uid','کاربر هدف',['class'=>'col-12']) !!}

                                <select data-placeholder="یک مورد را انتخاب کنید..." class="select chosen-rtl" name="uid" id="uid">
                                    <option></option>
                                    @forelse($Users as $item)
                                        <option value="{{ $item->id }}" @selected(old('uid', $Support->uid)== $item->id)>{{ $item->full_name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @if($errors->has('uid'))
                                    <span class="col-12 message-show">{{ $errors->first('uid') }}</span>
                                @endif
                            </div>

                            {{-- Status --}}
                            <div class="form-group row no-gutters">
                                {!! Form::label('status','وضعیت تیکت',['class'=>'col-12']) !!}

                                <select data-placeholder="یک مورد را انتخاب کنید..." class="select chosen-rtl" name="status" id="status">
                                    <option></option>
                                    <option value="replied" @selected(old(
                                    'status', $Support->status) == 'replied')>پاسخ داد</option>
                                    <option value="closed" @selected(old(
                                    'status', $Support->status) == 'closed')>بسته شد</option>
                                    <option value="pending" @selected(old(
                                    'status', $Support->status) == 'pending')>در انتظار پاسخ</option>
                                </select>
                                @if($errors->has('status'))
                                    <span class="col-12 message-show">{{ $errors->first('status') }}</span>
                                @endif
                            </div>

                            <button type="submit" class="submit-form-btn">بروزرسانی اطلاعات</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection

@section('footer')
    {{-- CKEditor Config --}}
    <script type="text/javascript">
        CKEDITOR.replace('ticket_content', {
            language: 'fa',
            filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['path' => 'support','_token' => csrf_token()])}}",
            filebrowserUploadMethod: 'form',
            width: '100%',
            height: '200',
            uiColor: '#fdfdfd',
        });
    </script>

    {{-- Item Repeater --}}
    <script>
        var currentcheckcontent, lastcheckcontent;
        jQuery(document).ready(function () {
            var i = {{ $attachmentKey }};
            jQuery("#addRepeatItem").click(function () {
                jQuery("#repeat_list").append("" +
                    "<div id='field-repeat-item-" + i + "'>" +
                    "<div class='text-field px-3'>" +
                    "<input type=\"file\" name=\"attachments[" + i + "]\"> " +
                    "<span class='delete-row icon-close' onclick='delete_item(" + i + ")'>" +
                    "<span class='zmdi zmdi-close-circle'></span>" +
                    "</span>" +
                    "</div>" +
                    "</div>" +
                    "");
                i += 1;
                return false;
            });

        });

        function delete_item($id) {
            $('#field-repeat-item-' + $id).remove();
        }
    </script>
@endsection
