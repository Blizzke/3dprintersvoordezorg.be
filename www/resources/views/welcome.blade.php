@extends('layouts.request')
@section('title', 'Welkom')
@section('content')
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ route('dashboard') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    @endif

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h1>3D Printers tegen Corona</h1>
        </div>
    <div class="row">

    <div class="row">
        <div class="col-sm-12">
            <div class="jumbotron">
                <p>Met tientallen vrijwilligers helpen wij graag een handje mee in deze moeilijke tijden. Via deze site bieden we tal van hulpstukken aan om mensen bij te staan in hun strijd tegen COVID-19.</p>

                <p>Ondanks het feit dat we deze items niet gratis kunnen aanbieden wegens de steeds hoger oplopende materiaalkosten,
                    maken we hierop geen winst. De bijdrage die we vragen wordt terug geinvesteerd in nieuw materiaal, zodat alle vrijwilligers jullie kunnen blijven verder helpen.</p>

                <p>Door verder te gaan via "ik zoek materiaal" kun je een aanvraag indienen. Hierna wordt je rechtstreeks gecontacteerd door iemand uit zo dicht mogelijk uit jouw buurt om de nodige details af te spreken.</p>

                <p>Voor klachten en vragen kan je rechtstreeks contact opnemen <a href="http://www.m.me/101001594912920" target="_blank">messenger</a> (graag geen Spam, we doen dit allemaal als vrijwillger)</p>
            </div>
        <div>
    </div>

    <div class="row margin-top-20">
        <div class="col-sm-12">
            <div class="well">
                <p>We hebben net een nieuwe site online gezet die we de komende dagen nog wat meer zullen aankleden.</p>
                <p>Het was gewoon belangrijk dat we zsm een vlotter bestel systeem hadden, vandaar de wat kale look.</p>
                <p>Je bent wel degelijk op de juiste plek!</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3 col-sm-offset-3">
            <a class="btn btn-lg btn-success" href="{{ url('/order/new') }}">Ik zoek materiaal</a>
        </div>
        <div class="col-sm-3 col-sm-offset-1">
            <a class="btn btn-lg btn-success" href="{{ url('/helper/register') }}">Ik wil helpen</a>
        </div>
    </div>

    <div class="row margin-top-20">
        @foreach($items as $item)
            <div class="col-sm-3">
                <a href="{{$item->image('small')}}" class="thumbnail" data-toggle="lightbox" data-title="{{$item->title}}">
                    <img src="{{$item->image('large')}}" alt="{{$item->title}}" />
                </a>
            </div>
        @endforeach
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
@endsection
