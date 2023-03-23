@extends('layouts.admin',['page_title' => __('admin.articles')])
@section('content')
    <x-form.main title="{{ trans('admin.articles') }}">
        <x-form.index :label="trans('admin.add_article')" permission="articles-create"
                      :route="route('admin.articles.create')"/>

        <div class="col-12 border-top mt-5">

            <form method="GET" class="pt-3">
                <span>@lang('admin.translated_articles') </span>
                @foreach(LaravelLocalization::getSupportedLocales() as $key  => $lang)
                    <button type="submit" name="lang"
                            class="btn-sm btn-outline-dark
                                @if ((request()->lang ?? app()->getLocale()) == $key) active @endif"
                            value="{{ $key }}">{{ $lang['native'] }}
                    </button>
                @endforeach
            </form>

        </div>

        @php
            $columns = [
                '#',
                trans('admin.user'),
                trans('admin.image') ,
                trans('admin.title') ,
                trans('admin.featured'),
                trans('admin.status'),
                trans('admin.views'),
                trans('admin.actions'),
                ];
        @endphp

        <x-form.table :columns="$columns" :targetModel="$articles" model-name="article">

            @foreach($articles as $article)
                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->user->name}}</td>
                    <td><img src="{{$article->image()}}" style="width:40px"></td>
                    <td>{{$article->translate(request()->lang)->title}}</td>

                    <td>
                        @if($article->is_featured==1)
                            <span class="fas fa-check-circle text-success"></span>
                        @endif
                    </td>
                    <td>
                        @if($article->is_published == 1)
                            @lang('article.published')
                        @else
                            @lang('article.draft')
                        @endif
                    </td>
                    <td>{{$article->views}}</td>
                    <td class="row d-flex">
                        <x-form.action-button :route="route('article.show',$article->translate(request()->lang)->slug)"
                                              class="btn-outline-success" icon="fal fa-eye" permission="articles-read"
                                              :title="trans('admin.show')"/>


                        <x-form.action-button :route="route('admin.article-comments.index',['article_id'=>$article->id])"
                                              class="btn-outline-dark" icon="fal fa-comments" permission="comments-read"
                        :title="trans('admin.comments')"/>

                        <x-form.action-button :route="route('admin.articles.edit',['article'=>$article->id])"
                                              class="btn-outline-primary" icon="fal fa-edit" permission="articles-update"
                                              :title="trans('admin.update')"/>

                        <x-form.action-button
                            class="btn-outline-danger" icon="fal fa-trash" permission="articles-delete"
                            :delete-form="true" model-name="articles"
                            :target-model="$article" :title="trans('admin.delete')"/>


{{--                        @can('articles-delete')--}}
{{--                            <form method="POST"--}}
{{--                                  action="{{route('admin.articles.destroy',$article->id)}}"--}}
{{--                                  class="d-inline-block">@csrf @method("DELETE")--}}
{{--                                <button class="btn  btn-outline-danger btn-sm font-1 mx-1"--}}
{{--                                        onclick="var result = confirm('هل أنت متأكد من عملية الحذف ؟');if(result){}else{event.preventDefault()}">--}}
{{--                                    <span class="fas fa-trash "></span> حذف--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                        @endcan--}}
                    </td>
                </tr>
            @endforeach


        </x-form.table>

    </x-form.main>

@endsection
