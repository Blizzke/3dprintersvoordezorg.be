@extends('layouts.request')
@section('title', 'Ik wil meehelpen')
@section('content')

    <div class="block-31" style="position: relative;">
        <div class="owl-carousel loop-block-31 ">
            <div class="block-30 block-30-sm item" style="background-image: url('/images/printer1.jpg');"
                 data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-md-7">
                            <h2 class="heading mb-5">Registreer en print mee!</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="featured-section overlay-color-2">
        <div class="container">
            <div class="row">

                <div class="col-md-6 mb-5 mb-md-0">
                    <h2>@yield('title')</h2>
                    <p>Heb je zelf een 3D printer die momenteel stil staat en nog wat extra filament, help ons dan, want
                        je weet hoe
                        traag printen gaat => meer printers = meer mensen geholpen</p>

                    <p>Deze website is enkel om mensen te helpen in deze corona tijden, er worden geen persoonlijke
                        gegevens aan
                        derden verstrekt.</p>

                    <p>Als je nog steeds wil helpen, registreer jezelf dan hieronder. Je krijgt dan toegang tot de lijst
                        van
                        aanvragen.<br><br>
                        Deze lijst toont het overzicht van iedereen die hulpstukken wilt, hoeveel en welke.
                        Als je een bestelling wilt vervullen kies je er gewoon 1 van de lijst.<br><br>
                        Je kan dan contact nemen met de persoon in kwestie voor de details en afspreken van de prijs en
                        je werkt de
                        aanvraag af, zo simpel is het.</p>
                </div>

                <div class="col-md-6 pl-md-5">

                    <div class="form-volunteer">
                        <form method="post" action="/helper/register">
                            @csrf
                            <div class="form-group">
                                <input placeholder="Inlognaam *" id="name" name="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{old('name')}}"/>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                                <input placeholder="Weergavenaam (zichtbaar) *" id="display_name" name="display_name"
                                       type="text" class="form-control @error('display_name') is-invalid @enderror"
                                       value="{{old('display_name')}}"/>
                                @error('display_name')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                                <input placeholder="Straat" id="street" name="street" type="text"
                                       class="form-control @error('street') is-invalid @enderror"
                                       value="{{old('street')}}"/>
                                @error('street')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                                <input placeholder="Nummer" id="number" name="number" type="text"
                                       class="form-control @error('number') is-invalid @enderror"
                                       value="{{old('nunber')}}"/>
                                @error('number')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                                <input placeholder="Postcode *" id="zip" name="zip" type="text"
                                       class="form-control @error('zip') is-invalid @enderror" value="{{old('zip')}}"/>
                                @error('zip')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                                <input placeholder="Gemeente *" id="city" name="city" type="text"
                                       class="form-control @error('city') is-invalid @enderror"
                                       value="{{old('city')}}"/>
                                @error('city')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                                <select class="form-control" id="country_id" name="country_id">
                                    <option value="1" selected>Belgi&euml;</option>
                                    <option value="2">Nederland</option>
                                </select>

                                <input placeholder="E-mail" id="email" name="email" type="text"
                                       class="form-control @error('email') is-invalid @enderror value="{{old('email')}}
                                ""/>
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                                <div class="col-sm-12">
                                    Vul ofwel uw telefoon ofwel uw gsm nummer in, deze wordt gebruikt om mee in te
                                    loggen samen met de inlognaam
                                </div>

                                <input placeholder="Telefoon" id="phone" name="phone" type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{old('phone')}}"/>
                                @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                                <input placeholder="GSM" id="mobile" name="mobile" type="text"
                                       class="form-control @error('mobile') is-invalid @enderror"
                                       value="{{old('mobile')}}"/>
                                @error('mobile')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror

                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-white px-5 py-2" value="Registreer">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
