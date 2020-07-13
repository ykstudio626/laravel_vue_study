@extends('layouts.app')

@section('css')
<link href="{{{asset('/css/my.css')}}}" rel="stylesheet">
@stop

@section('title')
このページ
@stop

@include('common.header')

@section('content')
<div id="app">
  <div class="row">
    <example-component></example-component>
    <example-component2></example-component2>
  </div>
</div>

<h1>一覧表示</h1>
<article>
	<form action="/search" method="get">
		<label>search<input type="text" name="word" value="{{ @$word }} " /></label>
		<input type="submit" value="検索" />
	</form> 
<div class="row">
@if (!empty($posts))
  <?php 
  foreach($posts as $post){ ?>

  <div class="card-unit col-md-3 mb-5 p-2">
  <div class="card">
    <a href="/post/{{ $post->id }}">
      <img src="/user_images/{{ $post->image }}" class="card-img-top" />
    </a>
    <div class="card-body">
      <a href="#" class="badge badge-primary">{{ @$post->category->name }}</a>
      <h5 class="card-title">{{ $post->title }}</h5>
      <p class="card-text"><?php echo mb_substr($post->content, 0 , 30) ?></p>
      <a class="btn btn-outline-primary" href="/post/{{ $post->id }}/edit/" class="card-link">編集</a>
      <!-- <a href="#" class="card-link">Another link</a> -->
      <form class="mini" action="/post/{{ $post->id }}" method="post">
      	@csrf
  		@method('delete')
  		<input class="btn btn-outline-danger" type="submit" value="削除" />
  	</form>

    </div>
    
  </div>
  </div>

  <?php
  }
   ?>
  </div>
  {{ $posts->links() }}
@endif
</article>
@stop



@include('common.footer')

@section('script')
<script type="text/javascript" src="{{{asset('/js/my.js')}}}"></script>
@stop
