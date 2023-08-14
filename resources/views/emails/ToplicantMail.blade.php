@component('mail::message')
    <div>
        <div class="title-block">
            <div class="block-right">
                @if($body['interface'] === 'user-face')
                    <img src="{{ 'https://' . env('APP_PANEL_URL') . '/public/mail/user-avatar.png' }}" width="29" alt="{{$body['name']}}">
                    <span class="title-text">{{$body['name']}}</span>
                @elseif($body['interface'] === 'normal-face')
                    <span class="title-text">{{$body['name']}}</span>
                @endif
            </div>
            <div class="block-left">
                <a href="{{ env('APP_URL') }}">
                    <img src="{{ 'https://' . env('APP_PANEL_URL') . '/public/mail/toplicant-logo-colored.png' }}" width="32" alt="تاپلیکنت">
                </a>
            </div>
        </div>
        <div>
            <div class="content-mail">
                <div class="paragraph">
                    {!! $body['content'] !!}
                </div>
            </div>
        </div>
    </div>
@endcomponent
