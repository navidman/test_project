<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td align="center">
                    <div class="footer-block">
                        <div class="block-right">
                            تمامی حقوق برای تاپلیکنت محفوظ است
                        </div>
                        <div class="block-left">
                            <a href="{{ env('APP_URL') }}">
                                © Copyright, {{ date("Y") }}, Toplicant.com
                            </a>
                        </div>
                    </div>

                    <div>
                        <img src="{{ 'https://' . env('APP_PANEL_URL') . '/public/mail/toplicant-logo-no-color.png' }}" width="37" alt="تاپلیکنت">
                    </div>

                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
