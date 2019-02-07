<div class="list-area">
  @if(isset($list) && count($list['data']) > 0)
    <div class="la-block">
      <table class="table is-bordered is-striped is-fullwidth">
        <thead>
          <tr>
            @foreach($list['columns'] as $key => $column)
              <th @if(isset($column['width']))width="{{ $column['width'] }}"@endif>
                @if(isset($search) && in_array($key, $search['order']['permit']))
                  <a href="{{ sort_url($key) }}#{{ constant_value('common.list_link') }}" class="{{ sort_class($key) }}">{{ $column['name'] }}</a>
                @else
                  <span>{{ $column['name'] }}</span>
                @endif
              </th>
            @endforeach

            @if(isset($list['operations']['list']))
              @foreach($list['operations']['list'] as $key => $operation)
                <th @if(isset($operation['width']))width="{{ $operation['width'] }}"@endif><span>{{ $operation['name'] }}</span></th>
              @endforeach
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach($list['data'] as $count => $data)
            <tr class="@if(isset($bi) && $data[$list['pk']] == $bi) exec @endif">
              @foreach($data as $key => $set)
                @if(isset($list['columns'][$key]))
                  <td>
                  <?php $elq = @$list['raw']->items()[$count]; ?>
                  @if(isset($list['columns'][$key]['type']) && replace_view_string($list['columns'][$key]['type'], $elq) == 'modal')
                      <?php $modal = $list['columns'][$key]['modal']; ?>
                      <button type="button" class="btn btn-{{$key}}" data-toggle="modal" data-target="#{{ replace_view_string($modal['modal_target'], @$elq) }}Modal">
                        {!! $list['columns'][$key]['text'] or $list['columns'][$key]['name'] !!}
                      </button>
                      @include('admin.includes.modal.'.$list['columns'][$key]['template'], $modal+['elq' => $elq])
                  @elseif(isset($list['columns'][$key]['a']))
                    {!! a($set, $list['columns'][$key]['a'], $elq, @$list['columns'][$key]['a_class'], @$list['columns'][$key]['a_text']) !!}
                  @else
                    @if(isset($list['columns'][$key]['escape']))
                      {!! $set !!}
                    @else
                      {{ $set }}
                    @endif
                  @endif
                  </td>
                @endif
              @endforeach

              @if(isset($list['operations']['list']))
                @foreach($list['operations']['list'] as $key => $operation)
                  <td>
                  <?php $is_disp = true; ?>
                  @if(isset($list_options_permit) && count($list_options_permit) > 0)
                    @if(isset($list_options_permit[$key][$list['raw'][$count]->id]) && $list_options_permit[$key][$list['raw'][$count]->id] != true)
                        <?php $is_disp = false; ?>
                    @endif
                  @endif
                    @if($is_disp)
                      <a href="{{ url($link.'/'.$key.'/'.$data[$list['pk']]) }}" class="button btn-{{ $key }}">{{ $operation['name'] }}</a>
                  @endif
                  </td>
                @endforeach
              @endif
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    @if(isset($search))
      <p>検索結果がありません</p>
    @else
      <p>データがありません</p>
    @endif
  @endif
</div>
