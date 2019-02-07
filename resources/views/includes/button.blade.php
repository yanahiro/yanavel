@if(isset($buttons))
  <div class="section button-area">
    <div class="has-text-centered">
      @foreach($buttons as $key => $button)
        @if(isset($button['href']))
          <a href="{{ $button['href'] }}" class="button btn-{{ $key }} wid-per30">
            <span>
              {{ $button['name'] }}
            </span>
          </a>
        @else
          <button type="submit" class="button btn-{{ $key }}">
            <span>
              {{ $button['name'] }}
            </span>
          </button>
        @endif
      @endforeach
    </div>
  </div>
@endif
