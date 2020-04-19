@extends('layouts.help')
@section('title', 'Dashboard')
@section('content')
<div class="row justify-content-center">
    @if (session('status'))
        <div class="col-md-8">
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        </div>
    @endif

    @include('helpers.orders.new')
    @include('helpers.orders.yours')
    @include('helpers.orders.in-progress')

</div>
@endsection
