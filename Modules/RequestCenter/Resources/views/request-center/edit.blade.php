@extends('dashboard::layouts.dashboard.master')
@section('title','ویرایش درخواست')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/requestcenter/images/icons/request.gif') }}"></span>
    <span class="text">ویرایش درخواست</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('request-center.update', $RequestCenter->id) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">محتوای درخواست</span>
                                </div>
                                <div class="col-3 left">
                                    <a class="show-all" href="{{ route('request-center.create') }}">ایجاد درخواست جدید</a>
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
                                {!! Form::text('title',$RequestCenter->title,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'موضوع درخواست را وارد نمایید']) !!}
                                {!! Form::label('title','موضوع درخواست:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('text_content','متن درخواست') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea class="field-style input-text" id="text_content" name="text_content" placeholder="متن درخواست را وارد نمایید">{!! old('text_content', $RequestCenter->text_content) !!}</textarea>
                                @if($errors->has('text_content'))
                                    <span class="col-12 message-show">{{ $errors->first('text_content') }}</span>
                                @endif
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
                            {{--  هزنیه درخواست --}}
                            <div class="form-group row no-gutters">
                                @if($errors->has('amount'))
                                    <span class="col-12 message-show">{{ $errors->first('amount') }}</span>
                                @endif
                                {!! Form::text('amount',$RequestCenter->amount,[ 'id'=>'amount' , 'class'=>'col-12 field-style input-text number-format-only', 'placeholder'=>'هزینه را وارد نمایید']) !!}
                                {!! Form::label('amount','هزینه درخواست:',['class'=>'col-12']) !!}
                            </div>

                            {{--  عنوان فیلد سفارشی --}}
                            <div class="form-group row no-gutters">
                                @if($errors->has('title_field'))
                                    <span class="col-12 message-show">{{ $errors->first('title_field') }}</span>
                                @endif
                                {!! Form::text('title_field',$RequestCenter->title_field,[ 'id'=>'title_field' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان فیلد سفارشی را وارد نمایید']) !!}
                                {!! Form::label('title_field','عنوان فیلد سفارشی:',['class'=>'col-12']) !!}
                            </div>

                            {{--  فیلد سفارشی --}}
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select data-placeholder="یک مورد را انتخاب کنید..." class="form-control chosen-rtl select" name="field" id="field">
                                        <option selected value="no_field" @selected(old('field', $RequestCenter->field) == 'no_field')> بدون فیلد سفارشی</option>
                                        <option value="text" @selected(old('field', $RequestCenter->field) == 'text')> دریافت متن</option>
                                        <option value="select_ads" @selected(old('field', $RequestCenter->field) == 'select_ads')> انتخاب نیازمندی</option>
                                        <option value="select_resume" @selected(old('field', $RequestCenter->field) == 'select_resume')> انتخاب رزومه</option>
                                    </select>
                                </div>
                                {!! Form::label('field','فیلد سفارشی:',['class'=>'col-12']) !!}
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
