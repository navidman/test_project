@php use Morilog\Jalali\Jalalian; @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','داشبورد')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/dashboard/admin/img/base/icons/dashboard.gif ') }}"></span>
    <span class="text">میزکار</span>
@endsection

@section('lib')
    {{--    <script src="{{ asset('public/modules/dashboard/admin/js/masonry.pkgd.min.js ') }}"></script>--}}
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <div style="color: #dddddd; border: 5px dashed" @class('center mt-2 pt-5 mb-5 pb-5')>
                <h2 class="mb-3">محل قرار گیری ویجت ها و ابزارها</h2>
                <span style="font-size: 16px">برنامه نویسان در این محل مشغول کار هستند</span>
            </div>
        </div>
        <div class="col-6">
            <div style="color: #dddddd; border: 5px dashed" @class('center mt-2 pt-5 mb-5 pb-5')>
                <h2 class="mb-3">محل قرار گیری ویجت ها و ابزارها</h2>
                <span style="font-size: 16px">برنامه نویسان در این محل مشغول کار هستند</span>
            </div>
        </div>
    </div>
@endsection
