@extends('layouts.request')
@section('title', 'Ik wil meehelpen')
@section('content')
<div class="content">
    <div class="title m-b-md">
        @yield('title')
    </div>

    <div class="disclaimer">
        <p>Heb je zelf een 3D printer die momenteel stil staat en nog wat extra filament, help ons dan, want je weet hoe
            traag printen gaat => meer printers = meer mensen geholpen</p>

        <p>Deze website is enkel om mensen te helpen in deze corona tijden, er worden geen persoonlijke gegevens aan
            derden verstrekt.</p>

        <p>Als je nog steeds wil helpen, registreer jezelf dan hieronder. Je krijgt dan toegang tot de lijst van
            aanvragen.
            Deze lijst toont het overzicht van iedereen die hulpstukken wilt, hoeveel en welke.
            Als je een bestelling wilt vervullen kies je er gewoon 1 van de lijst.
            Je kan dan contact nemen met de persoon in kwestie voor de details en afspreken van de prijs en je werkt de
            aanvraag af, zo simpel is het.</p>
    </div>

    <form method="post" action="/helper/register" class="form-horizontal">
        @csrf
        <div class="form-group">
            <label class="col-sm-3 control-label" for="name">Inlognaam *</label>
            <div class="col-sm-9">
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}"/>
                @error('name')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="display_name">Weergavenaam (zichtbaar) *</label>
            <div class="col-sm-9">
                <input id="display_name" name="display_name"type="text" class="form-control @error('display_name') is-invalid @enderror" value="{{old('display_name')}}"/>
                @error('display_name')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="street">Straat</label>
            <div class="col-sm-9">
                <input id="street" name="street" type="text" class="form-control @error('street') is-invalid @enderror" value="{{old('street')}}"/>
                @error('street')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="number">Nummer</label>
            <div class="col-sm-2">
                <input id="number" name="number" type="text" class="form-control @error('number') is-invalid @enderror" value="{{old('nunber')}}"/>
                @error('number')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="zip">Postcode* </label>
            <div class="col-sm-2">
                <input id="zip" name="zip" type="text" class="form-control @error('zip') is-invalid @enderror" value="{{old('zip')}}"/>
                @error('zip')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="city">Gemeente *</label>
            <div class="col-sm-5">
                <input id="city" name="city" type="text" class="form-control @error('city') is-invalid @enderror" value="{{old('city')}}"/>
                @error('city')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="country_id">Land</label>
            <div class="col-sm-4">
                <select class="form-control" id="country_id" name="country_id">
                    <option value="1" selected>Belgi&euml;</option>
                    <option value="2">Nederland</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="email">E-mail</label>
            <div class="col-sm-9">
                <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror value="{{old('email')}}""/>
                @error('email')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-sm-12">
            Vul ofwel uw telefoon ofwel uw gsm nummer in, deze wordt gebruikt om mee in te loggen samen met de inlognaam
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="phone">Telefoon</label>
            <div class="col-sm-9">
                <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}"/>
                @error('phone')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="mobile">GSM</label>
            <div class="col-sm-9">
                <input id="mobile" name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" value="{{old('mobile')}}"/>
                @error('mobile')<div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <button class="btn btn-success btn-submit">Registreer</button>
            </div>
        </div>
    </form>
</div>
@endsection
