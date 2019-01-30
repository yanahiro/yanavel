<p class="txt_plane">
  @if(isset($v['value_human']))
    {{ $v['value_human'] }}
  @else
    {{ @$v['value'] }}
  @endif
  {!! Form::hidden($k, @$v['value'], @$v['option']) !!}
  &nbsp;
</p>
