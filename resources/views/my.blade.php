@extends('common.layout')

@section('css')
<link href="{{{asset('/css/my.css')}}}" rel="stylesheet">
@stop

@section('title')
このページ
@stop

@include('common.header')

@section('content')
<h1>タイトル</h1>
<article>あいうあいうあいうあいうあいう</article>
@stop

@section('script')
<script type="text/javascript" src="{{{asset('/js/my.js')}}}"></script>
@stop

@include('common.footer')