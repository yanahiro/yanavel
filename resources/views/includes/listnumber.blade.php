<div class="areaDisplay" id="{{ constant_value('common.list_link') }}">
  <div class="wrapDisplay">
    <div class="btn-group">
      <button type="button" class="btn btn-default">{{ '全件' }}&nbsp;:&nbsp;{{ sprintf('%s件', $list['paginate']['total']) }}</button>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-default">{{ '表示件数' }}&nbsp;:&nbsp;{{ sprintf('%s件', $list['count']) }}</button>
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        @foreach($list['display'] as $disp)
          <li><a href="{{ url($link.'/display/'.$disp.'#'.constant_value('common.list_link')) }}">{{ sprintf('%s件', $disp) }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
