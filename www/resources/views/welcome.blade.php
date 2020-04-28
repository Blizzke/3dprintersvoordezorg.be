@extends('layouts.request')
@section('title', 'Welkom')
@section('content')

    <div class="block-31" style="position: relative;">
        <div class="owl-carousel loop-block-31 ">
            <div class="block-30 block-30-sm item" style="background-image: url('/images/printer1.jpg');" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-md-7">
                            <h2 class="heading mb-5">3D Printers tegen Corona</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section section-counter">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pr-5">
                    <div class="block-48">
                        <span class="block-48-text-1">Reeds</span>
                        <div class="block-48-counter ftco-number" data-number="{{$printed}}">0</div>
                        <span class="block-48-text-1 mb-4 d-block">afgeleverd, {{$printing}} worden geprint door</span>
                        <div class="block-48-counter ftco-number" data-number="{{$helpers}}">0</div>
                        <span class="block-48-text-1 mb-4 d-block">vrijwilligers. {{$wait}} stuks staan nog in de wachtrij sinds gisteren.</span>
                        <p class="mb-0"><a href="{{ url('/helper/register') }}" class="btn btn-white px-3 py-2">Ik wil helpen</a></p>
                    </div>
                </div>
                <div class="col-md-6 welcome-text">
                    <h2 class="display-4 mb-3">Wie zijn we?</h2>
                    <p class="lead">
                        Met tientallen vrijwilligers helpen wij graag een handje mee in deze moeilijke tijden.
                        Via deze site bieden we tal van hulpstukken aan om mensen bij te staan in hun strijd tegen COVID-19. <br><br>
                        Ondanks het feit dat we deze items niet gratis kunnen aanbieden wegens de steeds hoger oplopende materiaalkosten, maken we hierop geen winst.
                        De bijdrage die we vragen wordt terug geinvesteerd in nieuw materiaal, zodat alle vrijwilligers jullie kunnen blijven verder helpen.
                    </p>
                    <p class="mb-4">
                        Door verder te gaan via "ik zoek materiaal" kun je een aanvraag indienen.
                        Hierna wordt je rechtstreeks gecontacteerd door iemand uit zo dicht mogelijk uit jouw buurt om de nodige details af te spreken.
                        Voor klachten en vragen kan je rechtstreeks contact opnemen messenger (graag geen Spam, we doen dit allemaal als vrijwillger)
                    </p>
                    <p class="mb-0"><a href="{{ url('/order/new') }}" class="btn btn-primary px-3 py-2">Ik zoek materiaal</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section border-top">
        <div class="container">
            <div class="row">

                <div class="col-md-4">
                    <div class="media block-6">
                        <div class="icon"><i class="fas fa-lightbulb"></i></div>
                        <div class="media-body">
                            <h3 class="heading">Onze missie</h3>
                            <p>Met tientallen vrijwilligers helpen wij graag een handje mee in deze moeilijke tijden. Via deze site bieden we tal van hulpstukken aan om mensen bij te staan in hun strijd tegen COVID-19.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="media block-6">
                        <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                        <div class="media-body">
                            <h3 class="heading">Doneer / Sponsor</h3>
                            <p>Help ons een handje door te doneren of verbruiksmateriaal te sponsoren.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="media block-6">
                        <div class="icon"><i class="fas fa-user-friends"></i></div>
                        <div class="media-body">
                            <h3 class="heading">Ik heb een 3D-printer en ik wil helpen</h3>
                            <p>Heb je zelf een 3D printer die momenteel stil staat en nog wat extra filament, help ons dan, want je weet hoe traag printen gaat => maar printers = meer mensen geholpen</p>
                            <p><a href="{{ url('/helper/register') }}" class="link-underline">Start met printen!</a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- .site-section -->

    <div class="site-section fund-raisers bg-light">
        <div class="container">
            <div class="row mb-3 justify-content-center">
                <div class="col-md-8 text-center">
                    <h2>Momenteel leveren we volgende hulpstukken</h2>
                    <p class="lead">Heb je nog andere stukken die hulpzaam kunnen zijn om te 3D printen? Contacteer ons via <a href="http://www.m.me/101001594912920">messenger</a> en dan voegen we ze toe.</p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                @foreach($items as $item)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3 mb-lg-0">
                        <div class="post-entry">
                            <a href="{{$item->image('large')}}" data-fancybox="images" class="mb-3 img-wrap">
                                <img src="{{$item->image('large')}}" alt="{{$item->title}}" class="img-fluid">
                            </a>
                            <h3><a href="{{ url('/order/new') }}">{{$item->title}}</a></h3>
                            <p><a href="{{ url('/order/new') }}" class="btn btn-primary">Bestel</a></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> <!-- .section -->

    <div class="featured-section overlay-color-2" style="background-image: url('images/shields1.jpg');">
        <div class="container">
            <div class="row">

                <div class="col-md-12 mb-12 mb-md-0">
                    <h2>Ik heb een 3D-printer en ik wil helpen</h2>
                    <p>
                        Heb je zelf een 3D printer die momenteel stil staat en nog wat extra filament,
                        help ons dan, want je weet hoe traag printen gaat => maar printers = meer mensen geholpen<br><br>
                        Eerst en vooral, deze website is enkel om mensen te helpen in deze corona tijden, aldus,
                        er worden geen cookies gebruikt en er worden geen persoonlijke gegevens aan derden verstrekt<br><br>
                        Schrijf jezelf hieronder in en je krijgt een lijst te zien van iedereen die hulpstukken wilt,
                        hoeveel en dewelke, zodra je ingelogd bent kies je er gewoon 1 van de lijst,
                        je bevestigt dat jij de maskers wilt maken en dan neem je rechtstreeks contact op
                        met diegene voor wie je wilt maken, zo simpel is het.
                    </p>

                    <p class="mb-0"><a href="{{ url('/helper/register') }}" class="btn btn-white px-3 py-2">Ik wil helpen</a></p>
                </div>

                <div class="col-md-6 pl-md-5">


                </div>

            </div>
        </div>
    </div> <!-- .featured-donate -->

    <!-- loader -->
@endsection
