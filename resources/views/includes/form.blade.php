@foreach($form['fields'] as $gk => $gv)
  <div class="section input-area">
    <div class="container">
      @if(isset($gv['name']))
        <h3 class="subcopy">{{ $gv['name'] }}</h3>
      @endif
      <div class="ia-block">
        @foreach($gv['fields'] as $k => $v)
          @if($v['widget'] == 'hack')
            @include('widgets.'.$v['widget'])
          @elseif($v['widget'] == 'hidden')
            @include('widgets.'.$v['widget'])
          @elseif($v['widget'] == 'vanish')
          @else
            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">{!! @$v['name'] !!}</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <p class="control @if(isset($v['before']))has-icons-left"@endif">
                    @include('widgets.'.$v['widget'])
                    @if(isset($v['before']))
                      <span class="icon is-small is-left">
                        {!! $v['before'] !!}
                      </span>
                    @endif
                  </p>
                  @if(count($errors) > 0)
                    @if($errors->has($k))
                      @foreach($errors->get($k) as $m)
                        <span class="help is-danger">{{$m}}</span>
                      @endforeach
                    @endif
                  @endif
                </div>
              </div>
            </div>
          @endif
        @endforeach

      </div>
    </div>
  </div>
@endforeach
