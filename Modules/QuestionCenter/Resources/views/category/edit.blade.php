@extends('dashboard::layouts.dashboard.master')

@section('title','ویرایش دسته بندی')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/questioncenter/images/icons/category.gif') }}"></span>
    <span class="text">ویرایش دسته بندی</span>
    <span class="desc">بانک سوالات</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('question-center-category.update', $QuestionCenterCategory->id) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">ویرایش دسته بندی</span>
                                </div>
                                <div class="col-3 left"></div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group row no-gutters">
                                @if($errors->has('title'))
                                    <span class="col-12 message-show">{{ $errors->first('title') }}</span>
                                @endif
                                {!! Form::text('title',$QuestionCenterCategory->title,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان دسته بندی را وارد نمایید', 'dir' => 'auto']) !!}
                                {!! Form::label('title','عنوان دسته بندی:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                @if($errors->has('slug'))
                                    <span class="col-12 message-show">{{ $errors->first('slug') }}</span>
                                @endif
                                {!! Form::text('slug',$QuestionCenterCategory->slug,[ 'id'=>'slug' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'شناسه دسته بندی را وارد نمایید', 'dir' => 'auto']) !!}
                                {!! Form::label('slug','شناسه دسته بندی:',['class'=>'col-12']) !!}
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
                            <button type="submit" class="submit-form-btn">بروزرسانی اطلاعات</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection
