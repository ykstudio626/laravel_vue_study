@section('header')
<!DOCTYPE html>
<html lang="ja">
<head>
<title>
@yield('title')
</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
@yield('css')
</head>
<body class="container">XXX
<header>
	<?php if(Auth::check()): ?>
	<a href="/create">新規追加</a>
	<?php endif; ?>
</header>
@stop