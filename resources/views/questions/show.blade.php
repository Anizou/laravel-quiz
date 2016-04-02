@extends('layouts/master')

@section('content')
    <h1>{{ $post->title }}</h1>

    <div class="text-right">
        <a href="{{ route('posts.index') }}" class="btn btn-primary">Back to list</a>
    </div>

    <div style="margin:20px 0">
        created at {{ $post->created_at }}
        <i class="glyphicon glyphicon-eye-open"></i> {{ $post->view_count }}
        <i class="glyphicon glyphicon-comment"></i> {{ $post->reply_count }}
    </div>

    <div style="margin:20px 0">{{ $post->content }}</div>

    <?php $page = $post->repliesPaginated ?>
    @foreach($page as $reply)
        @include('posts.partials.reply')
    @endforeach

    <div class="text-right">
        {!! $page->render() !!}
    </div>

    <form method="POST" action="{{ route('replies.store', $post) }}">
        {!! csrf_field() !!}
        <input type="hidden" name="post" value="{{ $post->id }}">

        <div class="form-group">
            <textarea name="content" class="form-control emoji-control">{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success pull-right">{{ trans('forum::general.reply') }}</button>
    </form>
@stop

