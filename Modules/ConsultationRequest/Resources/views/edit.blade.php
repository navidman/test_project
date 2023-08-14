@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','مشاهده تماس')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/consultationrequest/images/icons/mobile.gif') }}"></span>
    <span class="text">مشاهده تماس</span>
@endsection

@section('content')
    <section class="form-section contact-show">
        <div class="row">
            <div class="col-9">
                <div class="widget-block widget-item widget-style">
                    <div class="heading-widget">
                        <div class="row align-items-end">
                            <div class="col-8"><span class="widget-title">{{ $ConsultationRequest->title }}</span></div>
                            <div class="col-4 left num-fa">{{ \Morilog\Jalali\Jalalian::forge($ConsultationRequest->created_at)->format('Y/m/d - H:i:s') }}</div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-padding">
                        <div class="left" dir="ltr">{{ $ConsultationRequest->message }}</div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="widget-block widget-item widget-style">
                    <div class="heading-widget">
                        <span class="widget-title">اطلاعات تماس</span>
                    </div>

                    <div class="widget-content widget-content-padding widget-content-padding-side">
                        <div class="item-info">
                            <div class="item-label">نام و نام خانوادگی</div>
                            <div class="item-value">{{ $ConsultationRequest->name }}</div>
                        </div>

                        <div class="item-info">
                            <div class="item-label">ایمیل</div>
                            <div class="item-value num-fa">{{ $ConsultationRequest->email }}</div>
                        </div>

                        <div class="item-info">
                            <div class="item-label">ایمیل</div>
                            <div class="item-value num-fa">{{ $ConsultationRequest->phone }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
