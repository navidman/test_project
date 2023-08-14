@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','مشاهده صورتحساب')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/payments/images/icons/payments.gif') }}"></span>
    <span class="text">مشاهده درخواست</span>
@endsection

@section('content')
    <section class="form-section contact-show">
        <form action="{{ route('withdrawal.update', $Withdrawal->id) }}" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
            <div class="col-9">
                <div class="widget-block widget-item widget-style">
                    <div class="heading-widget">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <span class="widget-title">اطلاعات درخواست</span>
                            </div>
                            <div class="col-4 num-fa left">
                                {{ \Morilog\Jalali\Jalalian::forge($Withdrawal->created_at)->format('Y/m/d - H:i:s') }}
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-padding">
                        <div class="row">
                            <div class="col-4">
                                <div class="item-info">
                                    <div class="item-label">نام درخواست کننده</div>
                                    <div class="item-value num-fa">{{ $Withdrawal->user['name'] }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="item-info">
                                    <div class="item-label">مبلغ درخواستی</div>
                                    <div class="item-value num-fa">{{ number_format($Withdrawal->amount) }} تومان</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="item-info">
                                    <div class="item-label">مبلغ قابل برداشت</div>
                                    <div class="item-value num-fa">{{ number_format($Withdrawal->balance) }} تومان</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="item-info border-bottom-0 m-0 p-0">
                                    <div class="item-label">شماره شبا</div>
                                    <div class="item-value num-fa">IR{{ $Withdrawal->shaba }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                {{-- Publish Options --}}
                <div class="widget-block widget-item widget-style">
                    <div class="heading-widget">
                        <div class="row align-items-center">
                            <div @class('col')><span class="widget-title">اطلاعات پرداخت</span></div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-padding widget-content-padding-side">
                        <div class="form-group row no-gutters">
                            <div class="col-12 field-style">
                                <select class="form-control chosen-rtl select" name="status" id="status">
                                    <option value="new" @selected(old(
                                    "status", $Withdrawal->status) == "new")> جدید</option>
                                    <option value="accepted" @selected(old(
                                    "status", $Withdrawal->status) == "accepted")>تایید شود</option>
                                    <option value="rejected" @selected(old(
                                    "status", $Withdrawal->status) == "rejected")>رد شود</option>
                                </select>
                            </div>

                            {!! Form::label('status','وضعیت انتشار',['class'=>'col-12']) !!}
                        </div>
                        <button type="submit" class="submit-form-btn">بروزرسانی اطلاعات</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>

@endsection
