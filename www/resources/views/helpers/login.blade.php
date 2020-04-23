@extends('layouts.request')
@section('title', 'Helper login')
@section('content')

    <div class="block-31" style="position: relative;">
        <div class="owl-carousel loop-block-31 ">
            <div class="block-30 block-30-sm item" style="background-image: url('/images/printer1.jpg');"
                 data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-md-7">
                            <h2 class="heading mb-5">@yield('title')</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 50px;">


        {!! Form::open(['url' => 'helper/login']) !!}
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="name">Inlognaam</label>
            <div class="col-sm-10">
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"/>
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="phone">Telefoon/GSM</label>
            <div class="col-sm-10">
                <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror"/>
                @error('phone')
                <div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-submit" style="width: 100%">Inloggen</button>
        </div>
        {!! Form::close() !!}

    </div>
@endsection
