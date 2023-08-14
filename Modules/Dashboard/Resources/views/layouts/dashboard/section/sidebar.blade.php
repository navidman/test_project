<div class="branding-sidebar">
    <a href="{!! Url('/') !!}" class="logo-panel center w-100 d-inline-block"> <img width="180px" src="{{ asset('public/modules/dashboard/admin/img/base/dashboard-logo.png') }}"></a>
</div>
<ul class="menu-admin">
    <li class="@if (Request::is('dashboard')) {{ 'active-menu' }}@endif">
        <a href="{!! Url('dashboard') !!}"><i class="zmdi zmdi-desktop-windows"></i><span class="text">میزکار</span></a>
    </li>

    @can('isAuthor')
        <li class="child-menu @if (Request::is('dashboard/blog*')) {{ 'active-menu' }}@endif">
            <a href="#" class="@if (Request::is('dashboard/blog*')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><style>.st4{fill:#121331}</style><path style="fill:none" d="M0 0h24v24H0z" id="bounding_box"/><g id="design"><path class="st4" d="M20.25 9H16V3.75c0-.41-.34-.75-.75-.75H3.75c-.41 0-.75.34-.75.75v14C3 19.54 4.46 21 6.25 21h11.5c1.79 0 3.25-1.46 3.25-3.25v-8c0-.41-.34-.75-.75-.75zm-14 10.5c-.96 0-1.75-.79-1.75-1.75V4.5h10v13.25c0 .64.19 1.24.51 1.75H6.25zm13.25-1.75c0 .76-.5 1.41-1.18 1.64-.18.08-.37.11-.57.11-.38 0-.74-.13-1.03-.35a1.7 1.7 0 0 1-.72-1.4V10.5h3.5v7.25z"/><path class="st4" d="M12.25 6h-5.5c-.41 0-.75.34-.75.75v3.5c0 .41.34.75.75.75h5.5c.41 0 .75-.34.75-.75v-3.5c0-.41-.34-.75-.75-.75zm-.75 3.5h-4v-2h4v2zM12.25 14h-5.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h5.5c.41 0 .75.34.75.75s-.34.75-.75.75zM12.25 17.06h-5.5a.749.749 0 1 1 0-1.5h5.5c.41 0 .75.34.75.75s-.34.75-.75.75z"/></g></svg><span class="text">وبلاگ</span></a>
            <ul class="sub-menu-1" @if ( Request::is('dashboard/blog*') ) style="display: block"@endif>
                <li class="@if ( Request::is('dashboard/blog') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/blog') }}"><span class="text">همه مطالب</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/blog/create') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/blog/create') }}"><span class="text">افزودن مطلب</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/blog-category*') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/blog-category') }}"><span class="text">دسته بندی</span></a>
                </li>
            </ul>
        </li>

        <li class="@if (Request::is('dashboard/comment*')) {{ 'active-menu' }}@endif">
            <a href="{{ url('dashboard/comment') }}" class="@if (Request::is('dashboard/comment*')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><style>.st4{fill:#121331}</style><path style="fill:none" d="M0 0h24v24H0z" id="bounding_box"/><g id="design"><path class="st4" d="M15.25 20H2.75c-.41 0-.75-.34-.75-.75v-8.5C2 7.03 5.03 4 8.75 4h6.5C18.97 4 22 7.03 22 10.75v2.5c0 3.72-3.03 6.75-6.75 6.75zM3.5 18.5h11.75c2.89 0 5.25-2.36 5.25-5.25v-2.5c0-2.9-2.36-5.25-5.25-5.25h-6.5c-2.89 0-5.25 2.35-5.25 5.25v7.75z"/><path class="st4" d="M8 13c-.26 0-.52-.11-.71-.29-.18-.19-.29-.45-.29-.71 0-.27.11-.52.29-.71.37-.37 1.05-.37 1.42 0l.12.15c.04.06.07.12.09.18.03.06.05.12.06.18.01.07.02.14.02.2s-.01.13-.02.2c-.01.06-.03.12-.06.18-.02.06-.05.12-.09.17-.04.06-.08.11-.12.16-.19.18-.45.29-.71.29zM12 13c-.13 0-.26-.03-.38-.08-.13-.05-.23-.12-.33-.21-.18-.19-.29-.45-.29-.71 0-.13.03-.26.08-.38.05-.13.12-.23.21-.33.1-.09.2-.16.33-.21.18-.08.38-.1.57-.06.07.01.13.03.19.06.06.02.12.05.17.09.06.03.11.08.16.12.09.1.16.2.21.33.05.12.08.25.08.38 0 .26-.11.52-.29.71-.05.04-.1.09-.16.12-.05.04-.11.07-.17.09-.06.03-.12.05-.19.06-.06.01-.13.02-.19.02zM16 13c-.06 0-.13-.01-.19-.02a.603.603 0 0 1-.19-.06.757.757 0 0 1-.18-.09l-.15-.12c-.18-.19-.29-.44-.29-.71 0-.13.03-.26.08-.38s.12-.23.21-.33l.15-.12c.06-.04.12-.07.18-.09.06-.03.12-.05.19-.06.32-.06.66.04.9.27.18.19.29.45.29.71 0 .06-.01.13-.02.2-.01.06-.03.12-.06.18-.02.06-.05.12-.09.18l-.12.15c-.19.18-.45.29-.71.29z"/></g></svg><span class="text">دیدگاه کاربران</span><span class="badge-menu badge-default num-fa">{{ \Modules\CommentSystem\Entities\CommentSystem::where('status', '=', 'new' )->count() }}</span></a>
        </li>

        <li class="child-menu @if (Request::is('dashboard/page-builder*')) {{ 'active-menu' }}@endif">
            <a href="#" class="@if (Request::is('dashboard/page-builder*')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><style>.st4{fill:#121331}</style><path style="fill:none" d="M0 0h24v24H0z" id="bounding_box"/><g id="design"><path class="st4" d="m19.78 8.72-6.5-6.5a.77.77 0 0 0-.52-.22H5.75C4.79 2 4 2.79 4 3.75v16.5c0 .96.79 1.75 1.75 1.75h12.5c.96 0 1.75-.79 1.75-1.75V9.24c0-.2-.09-.38-.22-.52zM13.5 4.56l3.94 3.94H13.5V4.56zm5 15.69c0 .14-.11.25-.25.25H5.75c-.14 0-.25-.11-.25-.25V3.75c0-.14.11-.25.25-.25H12v5.75c0 .41.34.75.75.75h5.75v10.25z"/><path class="st4" d="M19.78 8.72c.13.14.22.32.22.52 0-.19-.07-.38-.22-.52zm-6.5-6.5a.704.704 0 0 0-.52-.22c.2 0 .38.09.52.22zM15.25 14.5h-6.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h6.5c.41 0 .75.34.75.75s-.34.75-.75.75zM15.25 17.5h-6.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h6.5c.41 0 .75.34.75.75s-.34.75-.75.75z"/></g></svg><span class="text">برگه ها</span></a>
            <ul class="sub-menu-1" @if ( Request::is('dashboard/page-builder*') ) style="display: block"@endif>
                <li class="@if ( Request::is('dashboard/page-builder') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/page-builder') }}"><span class="text">همه برگه ها</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/page-builder/create') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/page-builder/create') }}"><span class="text">افزودن برگه</span></a>
                </li>
            </ul>
        </li>
    @endcan

    @can('isOperator')
        <li class="@if (Request::is('dashboard/company*')) {{ 'active-menu' }}@endif">
            <a href="{{ url('dashboard/company') }}" class="@if (Request::is('dashboard/null*')) {{ 'active-sub-menu' }}@endif"><i class="zmdi zmdi-city-alt"></i><span class="text">شرکت ها</span></a>
        </li>

        <li class="child-menu @if (Request::is('dashboard/advertisement*') || Request::is('dashboard/ads*')) {{ 'active-menu' }}@endif">
            <a href="#" class="@if (Request::is('dashboard/advertisement*')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><style>.st1{fill:#121331}</style><path style="fill:none" d="M0 0h24v24H0z" id="bounding_area"/><g id="design"><path class="st1" d="M18.25 22H5.75C4.79 22 4 21.21 4 20.25V3.75C4 2.79 4.79 2 5.75 2h12.5c.96 0 1.75.79 1.75 1.75v16.5c0 .96-.79 1.75-1.75 1.75zM5.75 3.5c-.14 0-.25.11-.25.25v16.5c0 .14.11.25.25.25h12.5c.14 0 .25-.11.25-.25V3.75c0-.14-.11-.25-.25-.25H5.75z"/><path class="st1" d="M11.76 10.51H7.75c-.41 0-.75-.34-.75-.75V5.75c0-.41.34-.75.75-.75h4.01c.41 0 .75.34.75.75v4.01c0 .41-.34.75-.75.75zM8.5 9.01h2.51V6.5H8.5v2.51zM16.25 13.5h-8.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h8.5c.41 0 .75.34.75.75s-.34.75-.75.75zM16.25 16.26h-8.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h8.5c.41 0 .75.34.75.75s-.34.75-.75.75zM11.75 19h-4c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h4c.41 0 .75.34.75.75s-.34.75-.75.75z"/></g></svg><span class="text">نیازمندی ها</span></a>
            <ul class="sub-menu-1" @if ( Request::is('dashboard/advertisement*') || Request::is('dashboard/ads*')) style="display: block"@endif>
                <li class="@if ( Request::is('dashboard/advertisement') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/advertisement') }}"><span class="text">همه نیازمندی ها</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/advertisement-category*') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/advertisement-category') }}"><span class="text">گروه های شغلی</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/advertisement-proficiency*') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/advertisement-proficiency') }}"><span class="text">مدیریت تخصص ها</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/ads-personal-proficiency*') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/ads-personal-proficiency') }}"><span class="text">مدیریت تخصص های فردی</span></a>
                </li>
            </ul>
        </li>

        <li class="@if (Request::is('dashboard/employment-advertisement*')) {{ 'active-menu' }}@endif">
        </li>
        <li class="@if (Request::is('dashboard/resume-manager*')) {{ 'active-menu' }}@endif">
            <a href="{{ url('dashboard/resume-manager') }}" class="@if (Request::is('dashboard/resume-manager*')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><style>.st1{fill:#121331}</style><path style="fill:none" d="M0 0h24v24H0z" id="bounding_box"/><g id="design"><path class="st1" d="M12 5c-.66 0-1.19.53-1.19 1.19v.63c0 .65.53 1.18 1.19 1.18h.59c.33 0 .59-.27.59-.59V6.19C13.19 5.53 12.66 5 12 5z"/><path class="st1" d="M12 5c-.66 0-1.19.53-1.19 1.19v.63c0 .65.53 1.18 1.19 1.18h.59c.33 0 .59-.27.59-.59V6.19C13.19 5.53 12.66 5 12 5zM17.45 13.26c-.15.14-.34.22-.53.22-.2 0-.38-.08-.53-.22l-1.8-1.8a.197.197 0 0 0-.34.14v6.69c0 .41-.34.75-.75.75h-.01c-.41 0-.75-.34-.75-.75v-4.04c0-.41-.33-.75-.74-.75s-.74.34-.74.75v4.04c0 .41-.34.75-.75.75h-.01c-.41 0-.75-.34-.75-.75V11.6c0-.18-.22-.27-.34-.14l-1.8 1.8c-.15.14-.33.22-.53.22-.19 0-.38-.08-.53-.22a.754.754 0 0 1 0-1.06l2.61-2.61c.38-.38.89-.59 1.42-.59h2.84c.53 0 1.04.21 1.41.59l2.61 2.61c.3.29.3.77.01 1.06z"/><path class="st1" d="M12 22C6.49 22 2 17.51 2 12S6.49 2 12 2s10 4.49 10 10-4.49 10-10 10zm0-18.5c-4.69 0-8.5 3.81-8.5 8.5 0 4.69 3.81 8.5 8.5 8.5s8.5-3.81 8.5-8.5c0-4.69-3.81-8.5-8.5-8.5z"/></g></svg><span class="text">رزومه پلاس</span><span class="badge-menu badge-default num-fa">{{ \Modules\ResumeManager\Entities\ResumeManager::where('status', 'pending_operator')->get()->count() }}</span></a>
        </li>
        <li class="@if (Request::is('dashboard/request-center*')) {{ 'active-menu' }}@endif">
            <a href="{{ url('dashboard/request-center') }}" class="@if (Request::is('dashboard/request-center*')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><path style="fill:none" d="M0 0h24v24H0z" id="bounding_area"/><path d="m20.96 11.99-2.71-7.5a.76.76 0 0 0-.71-.49H6.47c-.32 0-.6.2-.71.49l-2.71 7.5c-.03.08-.05.17-.05.25v7.01c0 .96.79 1.75 1.75 1.75h14.5c.97 0 1.75-.79 1.75-1.75v-7.01c0-.08-.01-.17-.04-.25zM6.99 5.5h10.02l2.35 6.49h-3.11c-.96 0-1.75.79-1.75 1.75v1.52c0 .14-.11.25-.25.25h-4.5c-.14 0-.25-.11-.25-.25v-1.52c0-.96-.78-1.75-1.75-1.75H4.64L6.99 5.5zM19.5 19.25c0 .14-.11.25-.25.25H4.75c-.13 0-.25-.11-.25-.25v-5.76h3.25c.14 0 .25.12.25.25v1.52c0 .97.79 1.75 1.75 1.75h4.5c.97 0 1.75-.78 1.75-1.75v-1.52c0-.13.12-.25.25-.25h3.25v5.76z" id="design"/></svg><span class="text">درخواست ها<span class="badge-menu badge-default num-fa">{{ \Modules\RequestCenter\Entities\RequestReceived::where('status', 'replied')->orWhere('status', 'new')->get()->count() }}</span></span></a>
        </li>

        <li class="@if (Request::is('dashboard/payments')) {{ 'active-menu' }}@endif">
            <a href="{{ url('dashboard/payments') }}" class="@if (Request::is('dashboard/payments')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><path style="fill:none" d="M0 0h24v24H0z" id="bounding_area"/><g id="design"><path class="st1" d="M10.25 17h-4.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h4.5c.41 0 .75.34.75.75s-.34.75-.75.75z"/><path class="st1" d="M20.25 4H3.75C2.79 4 2 4.79 2 5.75v12.5c0 .96.79 1.75 1.75 1.75h16.5c.97 0 1.75-.79 1.75-1.75V5.75C22 4.79 21.22 4 20.25 4zM3.5 5.75c0-.14.11-.25.25-.25h16.5c.14 0 .25.11.25.25V8h-17V5.75zm0 3.75h17v2h-17v-2zm17 8.75c0 .14-.11.25-.25.25H3.75c-.14 0-.25-.11-.25-.25V13h17v5.25z"/></g></svg><span class="text">پرداخت ها<span class="badge-menu badge-success num-fa">{{ \Modules\Payments\Entities\Payments::where('viewed', 0)->get()->count() }}</span></span></a>
        </li>

        <li class="@if (Request::is('dashboard/withdrawal')) {{ 'active-menu' }}@endif">
            <a href="{{ url('dashboard/withdrawal') }}" class="@if (Request::is('dashboard/withdrawal')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><path style="fill:none" d="M0 0h24v24H0z" id="bounding_area"/><g id="design"><path class="st1" d="M10.25 17h-4.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h4.5c.41 0 .75.34.75.75s-.34.75-.75.75z"/><path class="st1" d="M20.25 4H3.75C2.79 4 2 4.79 2 5.75v12.5c0 .96.79 1.75 1.75 1.75h16.5c.97 0 1.75-.79 1.75-1.75V5.75C22 4.79 21.22 4 20.25 4zM3.5 5.75c0-.14.11-.25.25-.25h16.5c.14 0 .25.11.25.25V8h-17V5.75zm0 3.75h17v2h-17v-2zm17 8.75c0 .14-.11.25-.25.25H3.75c-.14 0-.25-.11-.25-.25V13h17v5.25z"/></g></svg><span class="text">درخواست تسویه<span class="badge-menu badge-success num-fa">{{ \Modules\Payments\Entities\Withdrawal::where('status', 'new')->get()->count() }}</span></span></a>
        </li>

        <li class="child-menu @if (Request::is('dashboard/question-center*')) {{ 'active-menu' }}@endif">
            <a href="#" class="@if (Request::is('dashboard/question-center*')) {{ 'active-sub-menu' }}@endif"><i class="zmdi zmdi-help-outline"></i><span class="text">مرکز سوالات</span></a>
            <ul class="sub-menu-1" @if ( Request::is('dashboard/question-center*') ) style="display: block"@endif>
                <li class="@if ( Request::is('dashboard/question-center') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/question-center') }}"><span class="text">همه سوالات</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/question-center/create*') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/question-center/create') }}"><span class="text">افزودن سوال</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/question-center-category*') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/question-center-category') }}"><span class="text">دسته بندی</span></a>
                </li>
            </ul>
        </li>
{{--        <li class="@if (Request::is('dashboard/null*')) {{ 'active-menu' }}@endif">--}}
{{--            <a href="{{ url('dashboard/') }}" class="@if (Request::is('dashboard/null*')) {{ 'active-sub-menu' }}@endif"><i class="zmdi zmdi-notifications-none"></i><span class="text">اعلانات</span><span class="badge-menu badge-danger num-fa">9</span></a>--}}
{{--        </li>--}}
        <li class="@if (Request::is('dashboard/consultation-request*')) {{ 'active-menu' }}@endif">
            <a href="{{ url('dashboard/consultation-request') }}" class="@if (Request::is('dashboard/consultation-request*')) {{ 'active-sub-menu' }}@endif"><i class="zmdi zmdi-headset-mic"></i><span class="text">تماس ها</span><span class="badge-menu badge-default num-fa">{{ \Modules\ConsultationRequest\Entities\ConsultationRequest::where('status', 'new')->get()->count() }}</span></a>
        </li>
        <li class="child-menu @if (Request::is('dashboard/support*')) {{ 'active-menu' }}@endif">
            <a href="#" class="@if (Request::is('dashboard/support*')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><path style="fill:none" d="M0 0h24v24H0z" id="bounding_area"></path><path d="M18 14.75h2.3a.749.749 0 1 0 0-1.5H18V11.5h2.3a.749.749 0 1 0 0-1.5H18v-.26c0-.97-.78-1.75-1.75-1.75H16c0-1.34-.66-2.53-1.68-3.25l1.45-1.45c.29-.3.29-.77 0-1.07a.754.754 0 0 0-1.06 0l-1.86 1.86c-.27-.06-.56-.09-.85-.09-.3 0-.59.03-.86.09L9.28 2.22a.754.754 0 0 0-1.06 0c-.29.29-.29.77 0 1.06l1.46 1.46A3.97 3.97 0 0 0 8 7.99h-.25C6.79 7.99 6 8.77 6 9.74V10H3.79c-.41 0-.75.34-.75.75s.34.75.75.75H6v1.75H3.79c-.41 0-.75.34-.75.75s.34.75.75.75H6v1.5c0 .08 0 .17.01.25H3.79c-.41 0-.75.34-.75.75s.34.75.75.75h2.49a5.75 5.75 0 0 0 5.47 3.99h.51c2.56 0 4.72-1.68 5.46-3.99h2.58a.749.749 0 1 0 0-1.5h-2.31c.01-.08.01-.17.01-.25v-1.5zm-6-9.26c.26 0 .51.04.74.11.02.01.04.01.06.02.99.34 1.7 1.27 1.7 2.37h-5a2.5 2.5 0 0 1 2.5-2.5zm4.5 10.76c0 2.17-1.64 3.97-3.75 4.21v-6.71c0-.41-.34-.75-.75-.75s-.75.34-.75.75v6.71c-2.11-.25-3.75-2.04-3.75-4.21V9.74c0-.14.12-.25.25-.25h8.5c.14 0 .25.11.25.25v6.51z" id="design"></path></svg><span class="text">پشتیبانی</span><span class="badge-menu badge-warning num-fa">{{ \Modules\SupportSystem\Entities\SupportSystem::where('status', 'new')->where('status', 'replay')->get()->count() }}</span></a>
            <ul class="sub-menu-1" @if (Request::is('dashboard/support*') || Request::is('dashboard/resume*')) style="display: block"@endif>
                <li class="@if ( Request::is('dashboard/support') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ url('dashboard/support') }}"><span class="text">همه تیکت ها</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/support-departments*') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/support-departments') }}"><span class="text">دپارتمان ها</span></a>
                </li>
            </ul>
        </li>
    @endcan

    @can('isAdmin')
        <li class="child-menu @if (Request::is('dashboard/users*')) {{ 'active-menu' }}@endif">
            <a href="#" class="@if (Request::is('dashboard/users*')) {{ 'active-sub-menu' }}@endif"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24" xml:space="preserve"><style>.st1{fill:#121331}</style><path style="fill:none" d="M0 0h24v24H0z" id="bounding_area"/><g id="design"><path class="st1" d="M18.9 4.76A9.978 9.978 0 0 0 11.76 2a9.974 9.974 0 0 0-7 3.1A9.978 9.978 0 0 0 2 12.24a9.974 9.974 0 0 0 3.1 7c.08.08.16.15.25.22A9.87 9.87 0 0 0 11.99 22h.25c2.39-.06 4.64-.95 6.41-2.54.2-.17.4-.36.59-.56A9.945 9.945 0 0 0 22 11.99v-.23a9.974 9.974 0 0 0-3.1-7zM12.21 20.5c-2.02.04-3.95-.61-5.5-1.86a3.247 3.247 0 0 1 3.04-2.13h4.5c1.36 0 2.59.87 3.04 2.13-1.44 1.17-3.2 1.81-5.08 1.86zm6.23-2.97a4.778 4.778 0 0 0-4.19-2.52h-4.5c-1.78 0-3.39 1.01-4.19 2.53a8.37 8.37 0 0 1-2.06-5.33 8.45 8.45 0 0 1 2.35-6.07 8.415 8.415 0 0 1 5.94-2.64h.22c2.19 0 4.26.83 5.85 2.35.82.78 1.47 1.7 1.92 2.7.44 1.01.69 2.11.72 3.24.05 2.12-.67 4.15-2.06 5.74z"/><path class="st1" d="M14.75 13.5h-3c-1.79 0-3.25-1.46-3.25-3.25v-2C8.5 6.46 9.96 5 11.75 5h.5c1.79 0 3.25 1.46 3.25 3.25v4.5c0 .41-.34.75-.75.75zm-3-7c-.96 0-1.75.79-1.75 1.75v2c0 .96.79 1.75 1.75 1.75H14V8.25c0-.96-.79-1.75-1.75-1.75h-.5z"/></g></svg><span class="text">مدیریت کاربران</span></a>
            <ul class="sub-menu-1" @if ( Request::is('dashboard/users*') ) style="display: block"@endif>
                <li class="@if ( Request::is('dashboard/users') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/users') }}"><span class="text">کاربران</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/users/'.auth()->user()->id  . '/edit') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/users/'. auth()->user()->id.'/edit')}}"><span class="text">پروفایل من</span></a>
                </li>
                <li class="@if ( Request::is('dashboard/users/create') ) {{ 'active-zir-menu' }}@endif">
                    <a href="{{ Url('dashboard/users/create') }}"><span class="text">افزودن کاربر</span></a>
                </li>
            </ul>
        </li>
    @endcan
</ul>
