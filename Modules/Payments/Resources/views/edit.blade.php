@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','مشاهده صورتحساب')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/payments/images/icons/payments.gif') }}"></span>
    <span class="text">مشاهده صورتحساب</span>
@endsection

@section('content')
    <section class="form-section contact-show">
        <div class="row">
            <div class="col-9">
                <div class="widget-block widget-item widget-style">
                    <div class="heading-widget">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <span class="widget-title">اطلاعات سفارش</span>
                            </div>
                            <div class="col-4 num-fa left">
                                {{ \Morilog\Jalali\Jalalian::forge($Payments->created_at)->format('Y/m/d - H:i:s') }}
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-padding">
                        <div class="row">
                            <div class="col-12">
                                <div class="item-info">
                                    <div class="item-label">عنوان</div>
                                    <div class="item-value num-fa">{{ $Payments->title }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="item-info">
                                    <div class="item-label">مبلغ پکیج</div>
                                    <div class="item-value num-fa">{{ number_format($Payments->amount) }} تومان</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="item-info">
                                    <div class="item-label">مبلغ تخفیف</div>
                                    <div class="item-value num-fa">{{ number_format($Payments->discount_amount) }} تومان</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="item-info">
                                    <div class="item-label">مبلغ پرداخت نهایی</div>
                                    <div class="item-value num-fa">{{ number_format($Payments->payment_amount) }} تومان</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="item-info border-bottom-0 m-0 p-0">
                                    <div class="item-label">توضیخات پرداخت</div>
                                    <div class="item-value num-fa">{{ $Payments->order_description ? : "بدون توضیح" }}</div>
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
                        <div class="mb-4 border-radius-px-10 p-2 light-mode center" style="font-size: 16px; font-weight: 500; {{ $Payments->status ? 'background-color: #31b400;' : 'background-color: #ff4141;' }}">{{ $Payments->status ? 'پرداخت شد' : 'پرداخت نشد' }}</div>
                        <div class="item-info">
                            <div class="item-label">نام پرداخت کننده</div>
                            <div class="item-value num-fa">{{ $Payments->user_tbl->full_name }}</div>
                        </div>
                        <div class="item-info {{ $Payments->status ? : 'border-bottom-0 p-0 m-0' }}">
                            <div class="item-label">درگاه پرداخت</div>
                            <div class="item-value num-fa">{{ $Payments->gateway }}</div>
                        </div>
                        @if($Payments->transaction_id)
                            <div class="item-info border-bottom-0 p-0 m-0">
                                <div class="item-label">کد تراکنش</div>
                                <div class="item-value num-fa">{{ $Payments->transaction_id }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
