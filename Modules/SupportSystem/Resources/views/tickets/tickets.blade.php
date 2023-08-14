@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','مشاهد تیکت')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/supportsystem/images/icons/support.gif') }}"></span>
    <span class="text">مشاهد تیکت</span>
@endsection

@section('content')
    <section class="form-section">
        <div class="widget-block widget-item widget-style support-block">
            <div class="heading-widget">
                <span class="widget-title">{{ $Support->title }}</span>
            </div>

            <div class="widget-content widget-content-padding">
                <div class="ticket-content">
                    {!! $Support->ticket_content !!}
                </div>

                @if($Attachments)
                    <div class="attachments pt-3">
                        <strong class="d-inline-block mb-2">فایل های پیوست شده:</strong>

                        @forelse($Attachments as $item)
                            <div class="attachments-item">
                                <a href="{{ url($item['path']) }}" download="{{ $item['name'] }}" class="">{{ $item['name'] }}</a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('support.ticket.store', $Support->id) }}" method="POST" enctype="multipart/form-data">
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="row">
                        <div class="col-9">
                            <span class="widget-title">ارسال پاسخ</span>
                        </div>
                        <div class="col-3 left"></div>
                    </div>
                </div>

                <div class="widget-content widget-content-padding">
                    @csrf

                    <div class="form-group">
                        <textarea class="field-style input-text" id="replay_text" name="replay_text" placeholder="متن پاسخ را وارد نمایید">{{ old('replay_text') }}</textarea>
                        @if($errors->has('replay_text'))
                            <span class="message-show">{{ $errors->first('replay_text') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="answer-question text-field-repeater">
                            <div class="field-list" id="repeat_list"></div>
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <div class="add-field center" id="addRepeatItem">
                                        <span class="icon-plus"></span>افزودن فایل
                                    </div>
                                </div>

                                <div class="col-4">
                                    <button type="submit" class="submit-form-btn create-btn">ارسال پاسخ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @forelse($Tickets as $ticket)
            <div class="widget-block widget-item widget-style support-block">
                <div class="heading-widget">
                    <div class="row align-items-center">
                        <div class="col"><span class="widget-title">{{ $ticket->user_tbl->full_name }}</span></div>
                        <div class="col-4 text-right num-fa">{{ \Morilog\Jalali\Jalalian::forge($ticket->created_at)->format('H:i - Y/m/d') }}</div>
                        <div class="col-auto">
                            <form action="{{ route('support.ticket.destroy', $ticket->id) }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                                @csrf
                                <button @class('delete-item')><i class="zmdi zmdi-delete"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-padding">
                    <div class="ticket-content">
                        {!! $ticket->replay_text !!}
                    </div>

                    @if($ticket->attachments)
                        <div class="attachments pt-3 mt-3">
                            <strong class="d-inline-block">فایل های پیوست شده:</strong>

                            @forelse(json_decode($ticket->attachments) as $item)
                                <div class="attachments-item">
                                    <a href="{{ asset( 'storage/' . \Modules\FileLibrary\Entities\FileLibrary::find($item)->path . \Modules\FileLibrary\Entities\FileLibrary::find($item)->file_name) }}" download="{{ \Modules\FileLibrary\Entities\FileLibrary::find($item)->org_name }}" class="">{{ \Modules\FileLibrary\Entities\FileLibrary::find($item)->org_name }}</a>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        @empty
        @endforelse
    </section>

@endsection

@section('footer')
    {{-- CKEditor Config --}}
    <script type="text/javascript">
        CKEDITOR.replace('replay_text', {
            language: 'fa',
            filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['path' => 'support','_token' => csrf_token()])}}",
            filebrowserUploadMethod: 'form',
            width: '100%',
            height: '200',
            uiColor: '#fdfdfd',
        });
    </script>

    {{-- Item Repeater --}}
    <script>
        var currentcheckcontent, lastcheckcontent;
        jQuery(document).ready(function () {
            var i = 0;
            jQuery("#addRepeatItem").click(function () {
                i += 1;
                jQuery("#repeat_list").append("" +
                    "<div id='field-repeat-item-" + i + "'>" +
                    "<div class='text-field px-3'>" +
                    "<input type=\"file\" name=\"attachments[" + i + "]\"> " +
                    "<span class='delete-row icon-close' onclick='delete_item(" + i + ")'>" +
                    "<span class='zmdi zmdi-close-circle'></span>" +
                    "</span>" +
                    "</div>" +
                    "</div>" +
                    "");
                return false;
            });

        });

        function delete_item($id) {
            $('#field-repeat-item-' + $id).remove();
        }
    </script>
@endsection
