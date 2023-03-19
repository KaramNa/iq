@extends('layouts.admin' ,['page_title' => __('admin.pages')])
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 main-box">

            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-pages"></span> @lang('admin.pages')
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    <div class="col-12 col-lg-4 p-2 create-button">
                        @can('pages-create')
                            <a href="{{route('admin.pages.create')}}">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> @lang('admin.add_page')</span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>

            <div class="col-12 py-2 px-2 row">
                <div class="col-12 col-lg-4 p-2">
                    <form method="GET">
                        <input type="text" name="q" class="form-control" placeholder="@lang('Search')"
                               value="{{request()->get('q')}}">
                    </form>
                </div>
            </div>
            <div class="col-12 p-3" style="overflow:auto">
                <div class="col-12 p-0" style="min-width:1100px;">


                    <table class="table table-bordered  table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>المستخدم</th>
                            <th>الرابط</th>
                            <th>الشعار</th>
                            <th>العنوان</th>
                            <th>تحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>{{$page->id}}</td>
                                <td>{{$page->user->name}}</td>
                                <td>{{$page->slug}}</td>
                                <td>
                                    <img src="{{$page->image()}}" style="width:40px">
                                </td>
                                <td>{{$page->translate()->title}}</td>

                                <td style="width: 270px;">

                                    @can('pages-read')
                                        <a href="{{route('page.show',['page'=>$page])}}">
                                            <span class="btn  btn-outline-primary btn-sm font-1 mx-1">
                                                <span class="fas fa-search "></span> عرض
                                            </span>
                                        </a>
                                    @endcan

                                    @can('pages-update')
                                        <a href="{{route('admin.pages.edit',$page->id)}}">
                                            <span class="btn  btn-outline-success btn-sm font-1 mx-1">
                                                <span class="fas fa-wrench "></span> تحكم
                                            </span>
                                        </a>
                                    @endcan
                                    @can('pages-delete')
                                        <form method="POST" action="{{route('admin.pages.destroy',$page->id)}}"
                                              class="d-inline-block">@csrf @method("DELETE")
                                            <button class="btn  btn-outline-danger btn-sm font-1 mx-1"
                                                    onclick="var result = confirm('هل أنت متأكد من عملية الحذف ؟');if(result){}else{event.preventDefault()}">
                                                <span class="fas fa-trash "></span> حذف
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 p-3">
                {{$pages->appends(request()->query())->render()}}
            </div>
        </div>
    </div>
@endsection
