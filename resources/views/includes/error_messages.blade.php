@if(count($errors))
<div class="section">
  <div class="container">
    <div class="notification is-warning">
      <button class="delete"></button>
      <span>エラーが発生しております。内容ご確認ください。</span>
    </div>
  </div>
</div>
@endif

@if(isset($my_errors))
<div class="section">
  <div class="container">
    <div class="notification is-warning">
      <button class="delete"></button>
      @if(isset($my_errors))
        @foreach ($my_errors as $error)
          <span>{{ $error }}</span>
        @endforeach
      @endif
    </div>
  </div>
</div>
@endif
