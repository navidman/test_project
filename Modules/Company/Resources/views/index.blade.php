@extends('dashboard::layouts.dashboard.master')

@section('title','لیست شرکت ها')

@section('title-page')
    <span class="icon"><img src="{{ asset('public/modules/company/images/icons/company.gif') }}"></span>
    <span class="text">مدیریت شرکت ها</span>
@endsection

@section('content')
    <section class="report-table">
        <div class="row">
            <div class="col-12">
                <div class="widget-block widget-item widget-style">
                    <div class="heading-widget">
                        <div class="row align-items-center">
                            <div class="col-10">
                                <div class="form-style small-filter">
                                    <form action="{{ url('dashboard/users') }}" method="get" name="search">
                                        <div class="row align-items-end">
                                            <div class="col-3 field-block">
                                                <input class="text-input" value="@isset($_GET['search']){{ $_GET['search'] }}@endisset" id="search" type="text" name="search" placeholder="نام شرکت را وارد نمایید">
                                            </div>

                                            <div class="col-auto submit-field">
                                                <button type="submit">
                                                    <span class="zmdi zmdi-search"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-2 left"></div>
                        </div>
                    </div>

                    <div class="widget-content">
                        <form action="{{ url('dashboard/users/destroy') }}" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                            @csrf
                            <table class="table align-items-center">
                                <thead>
                                <tr>
                                    @can('isAdmin')
                                        <th class="delete-col">
                                            <input class="select-all" type="checkbox">
                                        </th>
                                    @endcan
                                    <th>نام شرکت</th>
                                    <th class="center">تعداد نیازمندی ها</th>
                                    <th class="center">رزومه پلاس</th>
                                    <th class="center">اشتراک</th>
                                    <th class="center">تاریخ ثبت</th>
                                    <th class="center">وب سایت</th>
                                    @can('isAdmin')
                                        <th width="80px" class="center">عملیات</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($Company as $item)
                                    <tr>
                                        @can('isAdmin')
                                            <td class="delete-col">
                                                <input class="delete-checkbox" type="checkbox" name="delete_item[{{ $item->id }}]" value="1">
                                            </td>
                                        @endcan
                                        <td class="cursor-pointer" onclick="window.location.href = '{{ url('dashboard') }}'">
                                            <img class="mr-2 border-radius-px-5" width="35" id="avatar-preview" src="@if($item->avatar){{ asset( 'storage/' . \Modules\FileLibrary\Entities\FileLibrary::find($item->avatar)->path .'35/'. \Modules\FileLibrary\Entities\FileLibrary::find($item->avatar)->file_name)  }}@else{{ asset('public/modules/dashboard/admin/img/base/icons/image.svg') }}@endif" srcset="@if($item->avatar){{ asset( 'storage/' . \Modules\FileLibrary\Entities\FileLibrary::find($item->avatar)->path .'35/'. \Modules\FileLibrary\Entities\FileLibrary::find($item->avatar)->file_name)  }}@else{{ asset('public/modules/dashboard/admin/img/base/icons/image.svg') }}@endif 1x, @if($item->avatar){{ asset( 'storage/' . \Modules\FileLibrary\Entities\FileLibrary::find($item->avatar)->path .'70/'. \Modules\FileLibrary\Entities\FileLibrary::find($item->avatar)->file_name)  }}@else{{ asset('public/modules/dashboard/admin/img/base/icons/image.svg') }}@endif 2x">
                                            <strong>{{ $item->company_name_fa }}</strong><span class="ml-1" style="font-size: 9px;color: #999999">({{ $item->company_name_en }})</span>
                                        </td>
                                        <td class="center num-fa">{{ \Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement::where('uid', $item->id)->count() }}</td>
                                        <td class="center num-fa">7</td>
                                        <td class="center num-fa"><span class="vip">VIP</span></td>
                                        <td class="center num-fa">{{ \Morilog\Jalali\Jalalian::forge($item->created_at)->format('Y/m/d') }}</td>
                                        <td class="center num-fa"><a target="_blank" href="{{ $item->website }}"><span style="font-size: 16px" class="zmdi zmdi-globe"></span></a></td>
                                        @can('isAdmin')
                                            <td class="center">
                                                {{--                                                <a href="{{ route('company.edit', $item->id) }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a>--}}
                                                <a href="{{ url('dashboard') }}" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-eye"></i></a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot class="num-fa">
                                <tr class="titles">
                                    @can('isAdmin')
                                        <th class="delete-col">
                                            <button class="table-btn table-btn-icon table-btn-icon-delete">
                                                <span><img src="{{ asset('public/modules/dashboard/admin/img/base/icons/trash.svg') }}" alt="شناسه" title="حذف"></span>
                                            </button>
                                        </th>
                                    @endcan
                                    <th>نام شرکت</th>
                                    <th class="center">تعداد نیازمندی ها</th>
                                    <th class="center">رزومه پلاس</th>
                                    <th class="center">اشتراک</th>
                                    <th class="center">تاریخ ثبت</th>
                                    <th class="center">وب سایت</th>
                                    @can('isAdmin')
                                        <th width="80px" class="center">عملیات</th>
                                    @endcan
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;" colspan="20">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                نمایش موارد {{ $Company->firstItem() }} تا {{ $Company->lastItem() }} از {{ $Company->total() }} مورد (صفحه {{ $Company->currentPage() }} از {{ $Company->lastPage() }})
                                            </div>
                                            <div class="col-8 left">
                                                <div class="pagination-table">
                                                    {{$Company->onEachSide(0)->links('vendor.pagination.default')}}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
