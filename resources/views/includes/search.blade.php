@if(isset($search))
  <div class="search-area">
    {!! \SearchView::open() !!}
    <div class="sa-block">
      <div class="reset has-text-right mb10"><a href="{{ void() }}" class="button -reset">reset</a></div>
      <div class="sa-conditions">
        @foreach($search['fields'] as $gk => $gv)
          @foreach($gv['fields'] as $k => $v)
            <div class="field is-horizontal">
              <div class="field-label">
                <label class="label">{{ $v['name'] }}</label>
              </div>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    @include('widgets.'.$v['widget'])
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endforeach
        @if($search['order']['string'] != '')
          {!! \Form::hidden('o', $search['order']['string']) !!}
        @endif
      </div>
      <div class="section has-text-centered">
        <button class="button wid-per30">検索</button>
      </div>
    </div>
    {!! \Form::hidden('rand', str_random(20)) !!}
    {!! \SearchView::close() !!}
  </div>
@endif
