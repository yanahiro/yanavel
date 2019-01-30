@extends('extends.master')

@section('content')
<section class="section menu-area">
  <div class="container">
    @foreach($menus as $menu)
      @if ($loop->index % 4 == 0)
        <div class="columns">
      @endif
      <div class="has-background-warning column is-one-quarter">
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
    <div class="columns">
      <div class="has-background-warning column">first</div>
      <div class="column">second</div>
      <div class="column">third</div>
      <div class="column">fourth</div>
    </div>
    <div class="columns">
      <div class="column">fifth</div>
      <div class="has-background-warning column">sixth</div>
      <div class="column">seventh</div>
      <div class="has-background-warning column">eighth</div>
    </div>
  </div>
</section>
@endsection
