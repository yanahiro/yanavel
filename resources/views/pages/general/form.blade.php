@extends('extends.master')

@section('content')
  <div class="areaForm">
    <div class="wrapForm">
      @include('includes.error_messages')

      {!! Formview::open() !!}

      @if($form['conf'])
        {!! Form::hidden('conf', 'conf') !!}
      @endif

      <div class="stlSimpleTable">
        @include('includes.form')
      </div>

      @include('includes.button', ['buttons' => $form['buttons']])

      {!! Formview::close() !!}
    </div>
  </div>
@endsection
