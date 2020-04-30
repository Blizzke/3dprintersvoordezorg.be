@extends('layouts.help')
@section('title', 'Nieuwe account - vergrendeld')
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <h1>@yield('title')</h1>
            <div class="alert alert-danger">
                <p>Omwille van een aantal spijtige misverstanden tussen klanten, bestellingen en vrijwilligers,
                    zien we ons genoodzaakt aanwezigheid op de discord chat (link: rechtsboven) als eis in te voeren.<p>
                <p>Dit teneinde e.e.a. beter te kunnen co&ouml;rdineren en sneller op grote bestellingen te kunnen inspelen.</p>
                <p>Je kan op de chat onder #wie_is_wie of #website de volgende link posten om je account te laten unlocken:</p>
                <p>{{url('/helper/unlock/'.$user->id)}}</p>
            </div>
        </div>
    </div>
@endsection
