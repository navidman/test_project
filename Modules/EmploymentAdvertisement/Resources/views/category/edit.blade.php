@extends('dashboard::layouts.dashboard.master')

@section('title','ویرایش گروه شغلی')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/employmentadvertisement/images/icons/category.gif') }}"></span>
    <span class="text">ویرایش گروه شغلی</span>
    <span class="desc">نیازمندی ها</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('advertisement-category.update', $EmploymentAdvertisementCategory->id) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">ویرایش گروه شغلی</span>
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
                                {!! Form::text('title',$EmploymentAdvertisementCategory->title,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان گروه شغلی را وارد نمایید', 'dir' => 'auto']) !!}
                                {!! Form::label('title','عنوان گروه شغلی:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                @if($errors->has('slug'))
                                    <span class="col-12 message-show">{{ $errors->first('slug') }}</span>
                                @endif
                                {!! Form::text('slug',$EmploymentAdvertisementCategory->slug,[ 'id'=>'slug' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'شناسه گروه شغلی را وارد نمایید', 'dir' => 'auto']) !!}
                                {!! Form::label('slug','شناسه گروه شغلی:',['class'=>'col-12']) !!}
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
