@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','ویرایش نیازمندی')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/employmentadvertisement/images/icons/advertisement.gif') }}"></span>
    <span class="text">ویرایش نیازمندی</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('advertisement.update', $EmploymentAdvertisement->id) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">اطلاعات نیازمندی</span>
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
                                {!! Form::text('title',$EmploymentAdvertisement->title,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان را وارد نمایید']) !!}
                                {!! Form::label('title','عنوان:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                @if($errors->has('minimum_salary'))
                                    <span class="col-12 message-show">{{ $errors->first('minimum_salary') }}</span>
                                @endif
                                {!! Form::text('minimum_salary',$EmploymentAdvertisement->minimum_salary,[ 'id'=>'minimum_salary' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'حداقل حقوق را وارد نمایید']) !!}
                                {!! Form::label('minimum_salary','حداقل حقوق:',['class'=>'col-12']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <a href='{{ url('dashboard/advertisement/head-hunt/' . $EmploymentAdvertisement->id) }}' class="submit-form-btn mb-3" style="background: #1a5bff">پیشنهاد هدهانتر</a>
                    <a href='{{ url('dashboard/advertisement/expert-ads/' . $EmploymentAdvertisement->id) }}' class="submit-form-btn mb-3" style="background: #d7051e">پیشنهاد کارشناسان</a>

                    {{-- Publish Options --}}
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row align-items-center">
                                <div @class('col')><span class="widget-title">ثبت اطلاعات</span></div>
{{--                                <div style="font-size: 16px; height: 20px" @class('col-auto')><a target="_blank" href="{{ url('advertisement' . '/' . $EmploymentAdvertisement->slug) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a></div>--}}
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding widget-content-padding-side">
                            {{-- Publish --}}
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select class="select chosen-rtl" data-placeholder="یک مورد را انتخاب کنید" name="status" id="status">
                                        <option value="">یک مورد را انتخاب کنید</option>
                                        <option value="new" @selected(old(
                                        "status", $EmploymentAdvertisement->status) == "new")> نیازمندی جدید</option>
                                        <option value="published" @selected(old(
                                        "status", $EmploymentAdvertisement->status) == "published")> منتشر شود</option>
                                        <option value="draft" @selected(old(
                                        "status", $EmploymentAdvertisement->status) == "draft")>پیش نویس شود</option>
                                    </select>
                                </div>

                                {!! Form::label('status','وضعیت انتشار',['class'=>'col-12']) !!}
                            </div>

                            {{-- Gender --}}
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select class="select chosen-rtl" data-placeholder="یک مورد را انتخاب کنید" name="gender" id="gender">
                                        <option value="">یک مورد را انتخاب کنید</option>
                                        <option value="all" @selected(old(
                                        "gender", $EmploymentAdvertisement->gender) == "all")> آقا و خانم</option>
                                        <option value="male" @selected(old(
                                        "gender", $EmploymentAdvertisement->gender) == "male")> آقا</option>
                                        <option value="female" @selected(old(
                                        "gender", $EmploymentAdvertisement->gender) == "female")> خانم</option>
                                    </select>
                                </div>

                                {!! Form::label('gender','جنسیت',['class'=>'col-12']) !!}
                            </div>

                            {{-- Cooperation --}}
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select class="select chosen-rtl" data-placeholder="یک مورد را انتخاب کنید" name="cooperation_type" id="cooperation_type">
                                        <option value="">یک مورد را انتخاب کنید</option>
                                        <option value="تمام وقت" @selected(old(
                                        "cooperation_type", $EmploymentAdvertisement->cooperation_type) == "تمام وقت")> تمام وقت</option>
                                        <option value="پاره وقت" @selected(old(
                                        "cooperation_type", $EmploymentAdvertisement->cooperation_type) == "پاره وقت")> پاره وقت</option>
                                        <option value="دور کاری" @selected(old(
                                        "cooperation_type", $EmploymentAdvertisement->cooperation_type) == "دور کاری")> دور کاری</option>
                                        <option value="پروژه ای" @selected(old(
                                        "cooperation_type", $EmploymentAdvertisement->cooperation_type) == "پروژه ای")> پروژه ای</option>
                                    </select>
                                </div>

                                {!! Form::label('cooperation_type','نوع همکاری',['class'=>'col-12']) !!}
                            </div>

                            {{-- Category --}}
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select class="select chosen-rtl" data-placeholder="یک مورد را انتخاب کنید" name="cat" id="cat">
                                        <option value="">یک مورد را انتخاب کنید</option>
                                        @forelse($EmploymentAdvertisementCategory as $item)
                                            <option value="{{ $item->id }}" @selected(old("cat", $EmploymentAdvertisement->cat) ==
                                            $item->id)>{{ $item->title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                {!! Form::label('cat','دسته بندی:',['class'=>'col-12']) !!}
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
            height: '200',
            uiColor: '#fdfdfd',
        });
    </script>
@endsection
