@extends('dashboard::layouts.dashboard.master')

@section('title','افزودن سوال جدید')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/questioncenter/images/icons/question-center.gif') }}"></span>
    <span class="text">افزودن سوال جدید</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('question-center.store') }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">محتوای سوال</span>
                                </div>
                                <div class="col-3 left"></div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding">
                            @csrf
                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('title','سوال') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea style="min-height: 100px" class="field-style input-text" id="title" name="title" placeholder="سوال را وارد نمایید">{{ old('title') }}</textarea>
                                @if($errors->has('title'))
                                    <span class="message-show">{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('content_text','پاسخ') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea class="field-style input-text" id="content_text" name="content_text" placeholder="پاسخ را وارد نمایید">{{ old('content_text') }}</textarea>
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
                                <div class="col-12 field-style custom-select-field">
                                    <select class="form-control" name="cat" id="cat">
                                        <option value="">یک مورد را انتخاب کنید</option>
                                        @forelse($QuestionCenterCategory as $item)
                                            <option value="{{ $item->id }}" @selected(old('cat') == $item->id)>{{ $item->title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                {!! Form::label('cat','دسته بندی:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style custom-select-field">
                                    <select class="form-control" name="status" id="status">
                                        <option value="">یک مورد را انتخاب کنید</option>
                                        <option selected value="published" @selected(old('status') == 'published')> منتشر شود</option>
                                        <option value="draft" @selected(old('status') == 'draft')>پیش نویس شود</option>
                                    </select>
                                </div>

                                {{-- Publish --}}
                                {!! Form::label('status','وضعیت انتشار',['class'=>'col-12']) !!}
                            </div>

                            <button type="submit" class="submit-form-btn create-btn">ایجاد سوال جدید</button>
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
            height: '200',
            uiColor: '#fdfdfd',
        });
    </script>
@endsection
