<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@hasSection('title')@yield('title') - @endif پنل مدیریت</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/modules/dashboard/admin/img/base/favicon.svg') }}">

    {{-- Notifier --}}
    <link href="{{ asset('public/modules/dashboard/admin/css/notifi/style.css') }}" rel="stylesheet" type="text/css">

    {{-- Library Storage --}}
    <link href="{{ asset('public/modules/dashboard/admin/plugins/chosen.jquery/css/chosen.min.css') }}" rel="stylesheet" type="text/css">

    {{-- Web Admin --}}
    <link href="{{ asset('public/modules/dashboard/admin/css/admin-style.min.css') }}" rel="stylesheet" type="text/css">

    @yield('lib')
</head>
<body>
<main class="main-admin">
    <div class="row no-gutters">
        <aside class="col-2 sidebar-col">
            <div class="sidebar">
                <div class="sidebar CustomScrollbar">
                    @include('dashboard::layouts.dashboard.section.sidebar')
                    @yield('sidebar')
                </div>
                <span class="version">MD CMS - v{{ env('APP_VERSION') }}</span> <span class="update">Last Update: {{ env('APP_LAST_VERSION') }}</span>
            </div>
        </aside>

        <article class="col-10 content-page content-block">
            <div class="heading-content-section">
                <div class="heading-inner">
                    <div class="row align-items-center">
                        <div class="col-7">
                            <h2 class="title-page">@yield('title-page')</h2>
                        </div>
                        <div class="col-5 left head-btn-col">
                            <div class="header-btn profile-btn">
                                <div class="icon">
                                    <i class="zmdi zmdi-account-o"></i>
                                </div>

                                <div class="menu-drop-down-header">
                                    <ul>
                                        <li>
                                            <a href="{{ Url('dashboard/users/' . auth()->user()->id . '/edit')}}"> <span class="text">ویرایش حساب</span> <i class="zmdi zmdi-account-box-o"></i> </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <span class="text">خروج از حساب</span> <i class="zmdi zmdi-power"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                            @if (auth()->user()->role == "admin")
                                <div class="header-btn notification-btn">
                                    <div class="icon">
                                        <a href="#"> <i class="zmdi zmdi-notifications-none  notification-icon "></i> <span class="badge-icon-header num-fa light-mode">9</span> </a>
                                    </div>
                                </div>
                            @endif
                            <div class="header-btn notification-btn">
                                <div class="icon">
                                    <a href="#"> <i style="font-size: 20px; height: 22px" class="zmdi zmdi-headset-mic"></i> <span class="badge-icon-header badge-icon-default num-fa light-mode">2</span> </a>
                                </div>
                            </div>
                            <div class="header-btn notification-btn">
                                <div class="icon">
                                    <a href="#"> <i style="font-size: 20px; height: 22px" class="zmdi zmdi-comment-alt-text"></i> <span class="badge-icon-header badge-icon-warning num-fa light-mode">6</span> </a>
                                </div>
                            </div>
                            <div class="header-btn wallet-btn">
                                <div class="icon">
                                    <a href="{{ Url('/') }}"><i class="zmdi zmdi-wallpaper"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-page">
                @yield('content')
            </div>
        </article>
    </div>
</main>


{{-- Library --}}
<script src="{{ asset('public/modules/dashboard/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/modules/dashboard/admin/js/bootstrap.min.js') }}"></script>

{{-- Notify --}}
<script src="{{ asset('public/modules/dashboard/admin/css/notifi/index.var.js') }}"></script>

{{-- Chosen --}}
<script src="{{ asset('public/modules/dashboard/admin/plugins/chosen.jquery/js/chosen.jquery.min.js') }}"></script>

{{-- APP JS --}}
<script src="{{ asset('public/modules/dashboard/admin/js/admin.js') }}"></script>
<script src="{{ asset('public/modules/dashboard/admin/js/footer.js') }}"></script>

@yield('footer')

@php
    $msg = \Session::get('notification')
@endphp
{{-- Notification --}}
<script>
    var options = {
        position: "bottom-left",
        durations: {
            global: 10000,
            success: null,
            info: null,
            tip: null,
            warning: null,
            alert: null
        },
        labels: {
            success: '',
            alert: '',
            warning: '',
            info: '',
            tip: '',
        },
        icons: {
            prefix: '',
            suffix: '',
            success: '',
            alert: '',
            warning: '',
            info: '',
            tip: '',
        }
    };
    var notifier = new AWN(options);
</script>

@if($msg)
    @php $msg_icon = ''; @endphp
    @if($msg['class'] == 'success')
        @php $msg_icon = 'check' @endphp
    @elseif($msg['class'] == 'alert')
        @php $msg_icon = 'alert-circle-o' @endphp
    @elseif($msg['class'] == 'warning')
        @php $msg_icon = 'alert-triangle' @endphp
    @elseif($msg['class'] == 'info')
        @php $msg_icon = 'info-outline' @endphp
    @elseif($msg['class'] == 'tip')
        @php $msg_icon = 'help"' @endphp
    @endif
    <script>
        notifier.{{ $msg['class'] }}('{{ $msg['message'] }}<span class="awn-toast-icon"><i class="zmdi zmdi-{{ $msg_icon }}"></i></span>');
    </script>
@endif

</body>
</html>
