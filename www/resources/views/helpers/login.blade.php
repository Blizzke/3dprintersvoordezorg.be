@extends('layouts.request')
@section('title', 'Helper login')
@section('content')
<div class="content">
    <div class="title m-b-md">
        @yield('title')
    </div>

    {!! Form::open(['url' => 'helper/login']) !!}
        <div class="form-group">
            <label for="name">Inlognaam</label>
            <input id="name" name="name" type="text" class="@error('name') is-invalid @enderror"/>
            @error('name')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="phone">Telefoon/GSM</label>
            <input id="phone" name="phone" type="text" class="@error('phone') is-invalid @enderror"/>
            @error('phone')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-submit">Inloggen</button>
        </div>
    {!! Form::close() !!}
</div>
@endsection
