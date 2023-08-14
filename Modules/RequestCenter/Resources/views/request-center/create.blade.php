@extends('dashboard::layouts.dashboard.master')

@section('title','افزودن درخواست جدید')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/requestcenter/images/icons/request.gif') }}"></span>
    <span class="text">افزودن درخواست جدید</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('request-center.store') }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <span class="widget-title">ایجاد درخواست</span>
                        </div>

                        <div class="widget-content widget-content-padding">
                            @csrf
                            <div class="form-group row no-gutters">
                                @if($errors->has('title'))
                                    <span class="col-12 message-show">{{ $errors->first('title') }}</span>
                                @endif
                                {!! Form::text('title',null,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان را وارد نمایید']) !!}
                                {!! Form::label('title','موضوع درخواست:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('text_content','متن درخواست') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea class="field-style input-text" id="text_content" name="text_content" placeholder="متن درخواست را وارد نمایید">{{ old('text_content') }}</textarea>
                                @if($errors->has('text_content'))
                                    <span class="message-show">{{ $errors->first('text_content') }}</span>
                                @endif
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
                            {{--  هزنیه درخواست --}}
                            <div class="form-group row no-gutters">
                                @if($errors->has('amount'))
                                    <span class="col-12 message-show">{{ $errors->first('amount') }}</span>
                                @endif
                                {!! Form::text('amount',null,[ 'id'=>'amount' , 'class'=>'col-12 field-style input-text number-format-only', 'placeholder'=>'هزینه را وارد نمایید']) !!}
                                {!! Form::label('amount','هزینه درخواست:',['class'=>'col-12']) !!}
                            </div>

                            {{--  عنوان فیلد سفارشی --}}
                            <div class="form-group row no-gutters">
                                @if($errors->has('title_field'))
                                    <span class="col-12 message-show">{{ $errors->first('title_field') }}</span>
                                @endif
                                {!! Form::text('title_field',null,[ 'id'=>'title_field' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان فیلد سفارشی را وارد نمایید']) !!}
                                {!! Form::label('title_field','عنوان فیلد سفارشی:',['class'=>'col-12']) !!}
                            </div>

                            {{--  فیلد سفارشی --}}
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select data-placeholder="یک مورد را انتخاب کنید..." class="form-control chosen-rtl select" name="field" id="field">
                                        <option selected value="no_field" @selected(old('field') == 'no_field')> بدون فیلد سفارشی</option>
                                        <option selected value="text" @selected(old('field') == 'text')> دریافت متن</option>
                                        <option selected value="select_ads" @selected(old('field') == 'select_ads')> انتخاب نیازمندی</option>
                                        <option selected value="select_resume" @selected(old('field') == 'select_resume')> انتخاب رزومه</option>
                                    </select>
                                </div>
                                {!! Form::label('field','فیلد سفارشی:',['class'=>'col-12']) !!}
                            </div>

                            <button type="submit" class="submit-form-btn create-btn">ایجاد درخواست</button>
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
        CKEDITOR.replace('text_content', {
            language: 'fa',
            filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['path' => 'request-center','_token' => csrf_token()])}}",
            filebrowserUploadMethod: 'form',
            width: '100%',
            height: '200',
            uiColor: '#fdfdfd',
        });
    </script>
@endsection
