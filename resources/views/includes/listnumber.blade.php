<div class="" id="{{ constant_value('common.list_link') }}">
  <div class="level mb10">
    <div class="level-left">
      <p class="result-count">{{ '全件' }}&nbsp;:&nbsp;{{ sprintf('%s件', $list['paginate']['total']) }}</p>
    </div>
    <div class="level-right">
      <div class="select">
        <select onChange="location.href=value;">
          @foreach($list['display'] as $disp)
            <option value="{{ url($link.'/display/'.$disp.'#'.constant_value('common.list_link')) }}">{{ sprintf('%s件', $disp) }}</option>
          @endforeach
        </select>
        <div>
    </div>
  </div>
</div>
