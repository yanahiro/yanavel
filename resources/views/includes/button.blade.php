@if(isset($buttons))
  <div class="section button-area">
    <div class="container has-text-centered">
      @foreach($buttons as $key => $button)
        <button type="submit" class="button btn-{{ $key }} btn-lg btn-block">
          <span>
            {{ $button['name'] }}
          </span>
        </button>
      @endforeach
    </div>
  </div>
@endif
