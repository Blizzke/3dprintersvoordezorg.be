@extends('layouts.request')
@section('title', 'Welkom')
@section('content')
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/helper/dashboard') }}">Home</a>
            @else
                <a href="{{ route('/helper/login') }}">Login</a>
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            3D Printers tegen Corona
        </div>

        <div class="disclaimer">
            <p>Met tientallen vrijwilligers helpen wij graag een handje mee in deze moeilijke tijden. Via deze site bieden we tal van hulpstukken aan om mensen bij te staan in hun strijd tegen COVID-19.</p>

            <p>Ondanks het feit dat we deze items niet gratis kunnen aanbieden wegens de steeds hoger oplopende materiaalkosten,
                maken we hierop geen winst. De bijdrage die we vragen wordt terug geinvesteerd in nieuw materiaal, zodat alle vrijwilligers jullie kunnen blijven verder helpen.</p>

            <p>Door verder te gaan via "ik zoek materiaal" kun je een aanvraag indienen. Hierna wordt je rechtstreeks gecontacteerd door iemand uit zo dicht mogelijk uit jouw buurt om de nodige details af te spreken.</p>

            <p>Voor klachten en vragen kan je rechtstreeks contact opnemen <a href="http://www.m.me/101001594912920" target="_blank">messenger</a> (graag geen Spam, we doen dit allemaal als vrijwillger)</p>
        </div>

        <div class="links">
            <a class="link-button" href="{{ url('/zoeken') }}">Ik zoek materiaal</a>
            <a class="link-button" href="{{ url('/helper/register') }}">Ik wil helpen</a>
        </div>
    </div>
</div>
@endsection
