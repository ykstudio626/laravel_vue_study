@extends('layouts.app')

@section('css')
<link href="{{{asset('/css/my.css')}}}" rel="stylesheet">
@stop

@section('title')
	@if($mode == 'edit')
	編集
	@else
	新規追加
	@endif
@stop

@section('content')
<h1>
	@if($mode == 'edit')
	編集
	@else
	新規追加
	@endif
</h1>
<?php 
if(empty($mode))$mode = 'new';
$title = (empty($post->title))?'':$post->title;
$content = (empty($post->content))?'':$post->content;
$image = (empty($post->image))?'':$post->image;
$category_id = (empty($post->category_id))?'':$post->category_id;
$image_path = (empty($image))?'':url('user_images/'.$image);
$action = ($mode == 'edit')?"post/{$post->id}":"post";
?>
<article>
	<form class="" action="/{{ $action }}" method="post">
		@csrf
		@if($mode == 'edit')
			@method('PUT')
		@endif
		<div class="form-group">
			<label>タイトル</label>
			<input class="form-control" type="text" name="title" value="<?php echo $title; ?>"/>
			@error('title')
			{{ $message }}
			@enderror
		</div>

		<div class="form-group">
			<label>本文</label>
			<textarea name="content" class="form-control"><?php echo $content; ?></textarea>
			@error('content')
			{{ $message }}
			@enderror
		</div>
		<div class="form-group">
			<label>カテゴリー</label>
			<!-- <select name="category_id" class="form-control">
				<option value="">選択してください	</option>
				@foreach ($categories as $k => $v)
					<option value="{{ $k }}" 
					@if($k == $category_id){{ "selected" }}@endif>{{ $v }}</option>
				@endforeach
			</select> -->
			{!! Form::select('category_id' , $categories , $category_id , ['class'=>'form-control' , 'placeholder' => '選択してください']) !!}
		</div>
		<div class="form-group">
			<input id="file" name="file" type="file" />
			<input type="hidden" name="image" value="{{ $image }}" />
			<button id="filedelete" class="btn btn-link">削除</button>
			<!-- <a class="btn" onclick="send()">アップロード</a> -->
			<img id="pic_thumb" class="thumb col-md-3" src="{{ $image_path }}" />
		</div>
		<input type="submit" value="送信" />
	</form> 
</article>
@stop

@section('script')
<script type="text/javascript" src="{{{asset('/js/my.js')}}}"></script>
@stop

@include('common.footer')