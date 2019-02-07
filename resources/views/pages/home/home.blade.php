@extends('extends.master')

@section('content')
<section class="section menu-area">
  <div class="container">
    @foreach($menus as $menu)
      @if ($loop->index % 4 == 0)
        <div class="columns">
      @endif
      <div class="column is-one-quarter">
        <a href="{{url($menu['self']->url)}}">
          <div class="card">
            <div class="menu-icon"><i class="fa fa-{{ $menu['self']->icon }}"></i></div>
            <div class="menu-title">{{ $menu['self']->menu_name }}</div>
          </div>
        </a>
      </div>
      @if ($loop->index % 4 == 3 || $loop->last)
        </div>
      @endif
    @endforeach
  </div>
</section>
@endsection
