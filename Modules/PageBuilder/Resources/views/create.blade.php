@extends('dashboard::layouts.dashboard.master')

@section('title','افزودن برگه جدید')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/pagebuilder/images/icons/page.gif') }}"></span>
    <span class="text">افزودن برگه جدید</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('page-builder.store') }}" method="POST">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">محتوای برگه</span>
                                </div>
                                <div class="col-3 left"></div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding">
                            @csrf
                            <div class="form-group row no-gutters">
                                @if($errors->has('title'))
                                    <span class="col-12 message-show">{{ $errors->first('title') }}</span>
                                @endif
                                {!! Form::text('title',null,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان را وارد نمایید']) !!}
                                {!! Form::label('title','عنوان:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('content_text','محتوای برگه') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea class="field-style input-text" id="content_text" name="content_text" placeholder="محتوای برگه را وارد نمایید">{{ old('content_text') }}</textarea>
                                @if($errors->has('content_text'))
                                    <span class="message-show">{{ $errors->first('content_text') }}</span>
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
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select data-placeholder="یک مورد را انتخاب کنید..." class="form-control chosen-rtl select" name="status" id="status">
                                        <option selected value="published" @selected(old(
                                        'status') == 'published')> منتشر شود</option>
                                        <option value="draft" @selected(old(
                                        'status') == 'draft')>پیش نویس شود</option>
                                    </select>
                                </div>

                                {{-- Publish --}}
                                {!! Form::label('status','وضعیت انتشار',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                @if($errors->has('visited'))
                                    <span class="col-12 message-show">{{ $errors->first('visited') }}</span>
                                @endif
                                {!! Form::text('visited',null,[ 'id'=>'visited' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'تعداد بازدید را وارد نمایید']) !!}
                                {!! Form::label('visited','تعداد بازدید:',['class'=>'col-12']) !!}
                            </div>

                            <button type="submit" class="submit-form-btn create-btn">ایجاد برگه جدید</button>
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
        CKEDITOR.replace('content_text', {
            language: 'fa',
            filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['path' => 'product','_token' => csrf_token()])}}",
            filebrowserUploadMethod: 'form',
            width: '100%',
            height: '400',
            uiColor: '#fdfdfd',
        });
    </script>
@endsection
