@props(['url'])
<tr>
    <td style="text-align: center">
        <div class="header">
            <div class="header-inner">
                <div class="block-right">
                    <a href="{{ $url }}">
                        <img src="{{ 'https://' . env('APP_PANEL_URL') . '/public/mail/toplicant-text-logo.png' }}" width="61" class="logo" alt="{{ $slot }}">
                    </a>
                    <span>پـــلی بـرای متقاضیـان بـرگزیـــده</span>
                </div>
                <div class="block-left">
                    <a href="#">
                        <img src="{{ 'https://' . env('APP_PANEL_URL') . '/public/mail/facebook.png' }}" width="17" alt="facebook">
                    </a>
                    <a href="#">
                        <img src="{{ 'https://' . env('APP_PANEL_URL') . '/public/mail/linkedin.png' }}" width="17" alt="linkedin">
                    </a>
                    <a href="#">
                        <img src="{{ 'https://' . env('APP_PANEL_URL') . '/public/mail/instagram.png' }}" width="17" alt="instagram">
                    </a>
                    <a href="#">
                        <img src="{{ 'https://' . env('APP_PANEL_URL') . '/public/mail/twitter.png' }}" width="17" alt="twitter">
                    </a>
                </div>
            </div>
        </div>
        {{--@if (trim($slot) === 'Laravel')--}}
        {{--@else--}}
        {{--{{ $slot }}--}}
        {{--@endif--}}
    </td>
</tr>
