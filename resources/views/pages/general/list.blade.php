@extends('extends.master')

@section('content')
  <section class="section menu-area">
    <div class="container">

      @if(isset($list) && isset($list['operations']['upper']))
        <div class="upperList">
          <ul>
          @foreach($list['operations']['upper'] as $key => $operation)
            <li>
              <a href="{{ url($link.'/'.$key) }}" class="button -{{ $key }} btn-lg">
                {{ $operation['name'] }}
              </a>
            </li>
          @endforeach
          </ul>
        </div>
      @endif

      @include('includes.search')

      <div class="">
        @include('includes.pager')
        @include('includes.listnumber')
      </div>

      @include('includes.list')

      <div class="">
        @include('includes.pager')
      </div>

      @if(isset($list) && isset($list['operations']['lower']))
        <div class="lowerList">
          <div class="col-md-8 col-md-offset-2">
          @foreach($list['operations']['lower'] as $key => $operation)
            <div class="@if(count($list['operations']['lower'])==1) col-md-6 col-md-offset-3 @else col-md-{{ 12 / count($list['operations']['lower']) }} @endif">
              <a href="{{ url_add_qs($link.'/'.$key, $operation) }}" class="btn btn-{{ $key }} btn-lg btn-block" @if($key == 'export') data-send-exclusion page-load-exclusion @endif>
                <span>
                    {{ $operation['name'] }}
                </span>
              </a>
            </div>
          @endforeach
          </div>
        </div>
      @endif

      @include('includes.button', ['buttons' => $buttons])
    </div>
  </section>
@endsection
