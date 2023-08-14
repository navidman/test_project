<div class="comment-form" id="comment-form">
    <div class="site-notification success">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="icon">
                    <img src="{{ asset('public/site/assets/images/base/icon/success.svg') }}" alt="Check">
                </div>
            </div>
            <div class="col"><div class="text-message"></div></div>
        </div>
    </div>

    <form name="commentForm" id="commentForm">
        <div class="row">
            @guest
                <div class="col-6">
                    <div class="field-block">
                        <label for="name">Your name:</label>
                        <input id="name" name="name" type="text" placeholder="Name">
                        <span class="message-show" id="validation-name"></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="field-block">
                        <label for="email">Your Email:</label>
                        <input id="email" name="email" type="email" placeholder="Email">
                        <span class="message-show" id="validation-email"></span>
                    </div>
                </div>
            @endguest
            <div class="col-12">
                <div class="field-block">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" placeholder="Message"></textarea>
                    <span class="message-show" id="validation-message"></span>
                </div>
            </div>
        </div>
        <div class="submit-comment right">
            <button id="btn-save">Send</button>
        </div>
    </form>
    <div class="loading"><img src="{{ asset('public/modules/commentsystem/images/icons/loading.gif') }}"></div>
</div>

@include('commentsystem::site.script.ajax')
