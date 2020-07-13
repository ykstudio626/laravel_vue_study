@extends('layouts.app')

@section('title')
	{{ $post->title }}
@stop

@section('content')
<h1>
	{{ $post->title }}
</h1>
<?php 
$title = (empty($post->title))?'':$post->title;
$content = (empty($post->content))?'':$post->content;
$image = (empty($post->image))?'':$post->image;
$image_path = (empty($image))?'':url('user_images/'.$image);
?>
<article>
		<div>
			{{ $content }}
		</div>
		<div class="pic">
			<img class="col-md-6" src="{{ $image_path }}" />
		</div>
</article>
@stop

@section('script')
@stop

@include('common.footer')