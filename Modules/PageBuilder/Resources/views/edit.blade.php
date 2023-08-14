@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','ویرایش برگه')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/pagebuilder/images/icons/page.gif') }}"></span>
    <span class="text">ویرایش برگه</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('page-builder.update', $Page->id) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">محتوای برگه</span>
                                </div>
                                <div class="col-3 left">
                                    <a class="show-all" href="{{ route('page-builder.create') }}">افزودن برگه جدید</a>
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
                                {!! Form::text('title',$Page->title,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان را وارد نمایید']) !!}
                                {!! Form::label('title','عنوان:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('content_text','محتوای برگه') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea class="field-style input-text" id="content_text" name="content_text" placeholder="محتوای برگه را وارد نمایید">{!! old('content_text', $Page->content_text) !!}</textarea>
                                @if($errors->has('content_text'))
                                    <span class="col-12 message-show">{{ $errors->first('content_text') }}</span>
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
                                <div @class('col')><span class="widget-title">ثبت اطلاعات</span></div>
                                <div style="font-size: 16px; height: 20px" @class('col-auto')><a target="_blank" href="https://{{ env('APP_URL') . '/page' . '/' . $Page->slug }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a></div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding widget-content-padding-side">
                            {{-- Publish --}}
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select class="form-control chosen-rtl select" name="status" id="status">
                                        <option selected value="published" @selected(old(
                                        "status", $Page->status) == "published")> منتشر شود</option>
                                        <option value="draft" @selected(old(
                                        "status", $Page->status) == "draft")>پیش نویس شود</option>
                                    </select>
                                </div>

                                {!! Form::label('status','وضعیت انتشار',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                @if($errors->has('visited'))
                                    <span class="col-12 message-show">{{ $errors->first('visited') }}</span>
                                @endif
                                {!! Form::text('visited',$Page->visited,[ 'id'=>'visited' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'تعداد بازدید را وارد نمایید']) !!}
                                {!! Form::label('visited','تعداد بازدید:',['class'=>'col-12']) !!}
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
