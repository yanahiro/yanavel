<div class="txt_plane {{ @$v['conf_class'] }}">
  @if(isset($v['conf']) && $v['conf'] == 'secret')
    {{ secret(@$v['value']) }}
  @else
    @if(isset($v['value_human']))
      @if(isset($v['escape']) && $v['escape'])
        {!! $v['value_human'] !!}
      @else
        {{ $v['value_human'] }}
      @endif
    @else
      {{ @$v['value'] }}
    @endif
  @endif
  @if($v['value'] == '')
    &nbsp;
  @endif
</div>
