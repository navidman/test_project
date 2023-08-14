@php use Modules\FileLibrary\Entities\FileLibrary @endphp@extends('dashboard::layouts.dashboard.master')

@section('title','ویرایش مطلب')

@section('lib')
    <script src="{{ asset('public/lib/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/lib/ckeditor/config.js') }}"></script>
@endsection

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/blog/images/icons/blog.gif') }}"></span>
    <span class="text">ویرایش مطلب</span>
@endsection

@section('content')
    <section class="form-section">
        <form action="{{ route('blog.update', $Blog->id) }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row">
                                <div class="col-9">
                                    <span class="widget-title">محتوای مطلب</span>
                                </div>
                                <div class="col-3 left">
                                    <a class="show-all" href="{{ route('blog.create') }}">افزودن مطلب جدید</a>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group row no-gutters">
                                @if($errors->has('title'))
                                    <span class="col-12 message-show">{{ $errors->first('title') }}</span>
                                @endif
                                {!! Form::text('title',$Blog->title,[ 'id'=>'title' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان را وارد نمایید']) !!}
                                {!! Form::label('title','عنوان:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('desc','چکیده') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea class="field-style input-text" id="desc" name="desc" placeholder="چکیده مطلب را وارد نمایید">{!! old('desc', $Blog->desc) !!}</textarea>
                                @if($errors->has('desc'))
                                    <span class="col-12 message-show">{{ $errors->first('desc') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div style="margin-bottom: 10px;">{!! Form::label('content_text','محتوای مطلب') !!}
                                    <span class="required">(الزامی)</span></div>
                                <textarea class="field-style input-text" id="content_text" name="content_text" placeholder="محتوای مطلب را وارد نمایید">{!! old('content_text', $Blog->content_text) !!}</textarea>
                                @if($errors->has('content_text'))
                                    <span class="col-12 message-show">{{ $errors->first('content_text') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    {{-- Publish Options --}}
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row align-items-center">
                                <div @class('col')><span class="widget-title">ثبت اطلاعات</span></div>
                                <div style="font-size: 16px; height: 20px" @class('col-auto')><a target="_blank" href="{{ url('blog' . '/' . $Blog->slug) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a></div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding widget-content-padding-side">
                            <div class="form-group row no-gutters">
                                @if($errors->has('time_watch'))
                                    <span class="col-12 message-show">{{ $errors->first('time_watch') }}</span>
                                @endif
                                {!! Form::text('time_watch',$Blog->time_watch,[ 'id'=>'time_watch' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'مدت زمان مطالعه را وارد نمایید']) !!}
                                {!! Form::label('time_watch','مدت زمان مطالعه(دقیقه):',['class'=>'col-12']) !!}
                            </div>

                            {{-- Publish --}}
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select class="form-control chosen-rtl select" name="status" id="status">
                                        <option value="">یک مورد را انتخاب کنید</option>
                                        <option selected value="published" @selected(old(
                                        "status", $Blog->status) == "published")> منتشر شود</option>
                                        <option value="draft" @selected(old(
                                        "status", $Blog->status) == "draft")>پیش نویس شود</option>
                                    </select>
                                </div>

                                {!! Form::label('status','وضعیت انتشار',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select data-placeholder="یک مورد را انتخاب کنید..." class="form-control chosen-rtl select" name="article_level" id="article_level">
                                        <option selected value="سطح پیشرفته" @selected(old(
                                        'article_level', $Blog->article_level) == 'سطح پیشرفته')> سطح پیشرفته</option>
                                        <option value="سطح متوسط" @selected(old(
                                        'article_level', $Blog->article_level) == 'سطح متوسط')>سطح متوسط</option>
                                        <option value="سطح مقدماتی" @selected(old(
                                        'article_level', $Blog->article_level) == 'سطح مقدماتی')>سطح مقدماتی</option>
                                    </select>
                                </div>

                                {!! Form::label('article_level','سطح مقاله',['class'=>'col-12']) !!}
                            </div>

                            {{-- Category --}}
                            <div class="form-group row no-gutters">
                                @if($errors->has('cat'))
                                    <span class="col-12 message-show">{{ $errors->first('cat') }}</span>
                                @endif
                                {!! Form::label('cat','دسته بندی ها',['class'=>'col-12']) !!}
                                <select multiple data-placeholder="دسته بندی ها را انتخاب نمایید..." id="cat" class="select chosen-rtl num-fa" name="cat[]">
                                    @php
                                        $BlogCategoryIDs = json_decode($Blog->cat);

                                        function in_array_all($needles, $haystack) {
                                            if ($haystack) {
                                                return empty(array_diff($needles, $haystack));
                                            }
                                        }
                                    @endphp

                                    @forelse($BlogCategory as $item)
                                        <option @selected(old("cat", in_array_all([$item->id], $BlogCategoryIDs)) == $item) value="{{ $item->id }}">{{ $item->title }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group row no-gutters">
                                @if($errors->has('visited'))
                                    <span class="col-12 message-show">{{ $errors->first('visited') }}</span>
                                @endif
                                {!! Form::text('visited',$Blog->visited,[ 'id'=>'visited' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'تعداد بازدید را وارد نمایید']) !!}
                                {!! Form::label('visited','تعداد بازدید:',['class'=>'col-12']) !!}
                            </div>

                            <div class="form-group row no-gutters">
                                @if($errors->has('visited'))
                                    <span class="col-12 message-show">{{ $errors->first('visited') }}</span>
                                @endif
                                <input type="checkbox" name="featured" id="featured" class="check-box-styled" {{ $Blog->featured || old('featured') ? 'checked' : '' }}>
                                <label for="featured">
                                    <span class="row">
                                        <span class="col-9">مقاله برگزیده</span>
                                        <span class="col-3">
                                            <span class="toggle"></span>
                                        </span>
                                    </span>
                                </label>
                            </div>

                            <button type="submit" class="submit-form-btn">بروزرسانی اطلاعات</button>
                        </div>
                    </div>

                    {{-- Thumbnail --}}
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <span class="widget-title">تصویر شاخص</span>
                        </div>

                        <div class="widget-content widget-content-padding widget-content-padding-side">
                            <div class="form-group row no-gutters">
                                @if($errors->has('thumbnail'))
                                    <span class="message-show">{{ $errors->first('thumbnail') }}</span>
                                @endif
                                <div class="col-12 field-style custom-select-field">
                                    <div class="thumbnail-image-upload">
                                        <div>
                                            <label for="thumbnail-image" id="thumbnail-label" class="thumbnail-label"><img id="thumbnail-preview" src="@if($Blog->thumbnail){{ asset( 'storage/' . FileLibrary::find($Blog->thumbnail)->path .'full/'. FileLibrary::find($Blog->thumbnail)->file_name)  }}@else{{ asset('public/modules/dashboard/admin/img/base/icons/image.svg') }}@endif"></label>
                                            <input onchange="readURL(this)" name="thumbnail" type="file" class="thumbnail-image" id="thumbnail-image" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tags --}}
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <span class="widget-title">برچسب ها</span>
                        </div>

                        <div class="widget-content widget-content-padding widget-content-padding-side">
                            <div class="form-group">
                                <div class="answer-question text-field-repeater">
                                    <div class="field-list" id="repeat_list">
                                        @php $tagKey = 1 @endphp
                                        @if($Blog->tag)
                                            @forelse(json_decode($Blog->tag) as $item)
                                                <div id="field-repeat-item-{{ $tagKey }}">
                                                    <div class="text-field">
                                                        <div class='text-field'>
                                                            <input placeholder='برچسب را وارد نمایید...' class='field-style input-text' type="text" name="tag[{{ $tagKey }}]" value="{{ $item }}">
                                                            <span class='delete-row icon-close' onclick='delete_item({{ $tagKey }})'>
                                                            <span class='zmdi zmdi-close-circle'></span>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php $tagKey += 1 @endphp
                                            @empty
                                            @endforelse
                                        @endif
                                    </div>
                                    <div class="add-field center" id="addRepeatItem">
                                        <span class="icon-plus"></span>افزودن برچسب
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection

@section('footer')
    {{-- CKEditor Config --}}
    <script type="text/javascript">
        CKEDITOR.replace('content_text', {
            language: 'fa',
            filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['path' => 'product','_token' => csrf_token()])}}",
            filebrowserUploadMethod: 'form',
            width: '100%',
            height: '500',
            uiColor: '#fdfdfd',
        });
    </script>

    {{-- Thumbnail Preview --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(input).prev().find('img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
    </script>

    {{-- Item Repeater --}}
    <script>
        var currentcheckcontent, lastcheckcontent;
        jQuery(document).ready(function () {
            var i = {{ $tagKey }};
            jQuery("#addRepeatItem").click(function () {
                i += 1;
                jQuery("#repeat_list").append("" +
                    "<div id='field-repeat-item-" + i + "'>" +
                    "<div class='text-field'>" +
                    "<input placeholder='برچسب را وارد نمایید...' class='field-style input-text' type=\"text\" name=\"tag[" + i + "]\"> " +
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
