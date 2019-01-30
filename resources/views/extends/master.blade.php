<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="stylesheet" href="{{url('/')}}/css/bulma.css">
  <link rel="stylesheet" href="{{url('/')}}/css/fontawsome/css/all.min.css">
  <link rel="stylesheet" href="{{url('/')}}/css/style.css">


  <link rel="stylesheet" href="{{url('/')}}css/work.css">

</head>
<body>
  @include('common.header')
  @yield('content')
</body>
</html>