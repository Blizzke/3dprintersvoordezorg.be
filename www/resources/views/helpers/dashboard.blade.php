@extends('layouts.help')
@section('title', 'Dashboard')
@section('content')
    @if (session('status'))
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif
    @if (!Auth::user()->hasFeature('notification:please_add_features'))
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="alert alert-success" role="alert">
                    Gelieve op je profiel-pagina aan te geven welke items je produceert, zodat de site de weergave op maat kan maken.
                </div>
            </div>
        </div>
    @endif

<div class="row justify-content-center">

    @if ($user->hasFeature('auth:dispatcher'))
        @include('helpers.orders.validate')
    @endif
    @include('helpers.orders.new')
    @include('helpers.orders.yours')
    @include('helpers.orders.in-progress')

</div>
<script type="text/javascript">
    $(function () {
        $('[data-work="1"]').click(function(e) {
            e.preventDefault()
            value = prompt('Hoeveel items zijn er klaar?');
            if (value) {
                $.post($(this).attr('href'), { "_token": "{{ csrf_token() }}", "items": value }, function(result) {
                    if (result && result.hasOwnProperty('redirect_to'))
                        // Backend returns a json object if we ajax to "work", redirect to the url it returns
                        top.location.href = result.redirect_to
                });
            }
        });
    });
</script>
@endsection
