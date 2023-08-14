@extends('dashboard::layouts.dashboard.master')

@section('title','ویرایش دسته بندی')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/blog/images/icons/category.gif') }}"></span>
    <span class="text">ویرایش دسته بندی</span>
    <span class="desc">وبلاگ</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('blog-category.update', $BlogCategory->id) }}" method="post" enctype="multipart/form-data">
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
                                {!! Form::text('title',$BlogCategory->title,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان دسته بندی را وارد نمایید', 'dir' => 'auto']) !!}
                                {!! Form::label('title','عنوان دسته بندی:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                @if($errors->has('slug'))
                                    <span class="col-12 message-show">{{ $errors->first('slug') }}</span>
                                @endif
                                {!! Form::text('slug',$BlogCategory->slug,[ 'id'=>'slug' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'شناسه دسته بندی را وارد نمایید', 'dir' => 'auto']) !!}
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
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select data-placeholder="یک مورد را انتخاب کنید..." class="form-control chosen-rtl select" name="parent" id="parent">
                                        <option value="">بدون سردسته</option>
                                        @forelse($ParentCategories as $item)
                                            <option value="{{ $item->id }}" @selected(old('parent', $BlogCategory->parent) == $item->id)>{{ $item->title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                {!! Form::label('parent','دسته بندی مادر:',['class'=>'col-12']) !!}
                            </div>

                            <button type="submit" class="submit-form-btn">بروزرسانی اطلاعات</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection
