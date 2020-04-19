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

    {!! Form::open(['url' => 'helper/register']) !!}
        <div class="form-group">
            <label for="name">Inlognaam</label>
            <input id="name" name="name" type="text" class="@error('name') is-invalid @enderror"/>
            @error('name')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="display_name">Weergavenaam (zichtbaar)</label>
            <input id="display_name" name="display_name"type="text" class="@error('display_name') is-invalid @enderror"/>
            @error('display_name')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="street">Straat</label>
            <input id="street" name="street" type="text" class="@error('street') is-invalid @enderror"/>
            @error('street')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="number">Nummer</label>
            <input id="number" name="number" type="text" class="@error('number') is-invalid @enderror"/>
            @error('number')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="zip">Postcode</label>
            <input id="zip" name="zip" type="text" class="@error('zip') is-invalid @enderror"/>
            @error('zip')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="city">Gemeente</label>
            <input id="city" name="city" type="text" class="@error('city') is-invalid @enderror"/>
            @error('city')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="country">Land</label>
            {!! Form::select('country', $countries) !!}
            @error('country')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input id="email" name="email" type="text" class="@error('email') is-invalid @enderror"/>
            @error('email')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="phone">Telefoon</label>
            <input id="phone" name="phone" type="text" class="@error('phone') is-invalid @enderror"/>
            @error('phone')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="mobile">GSM</label>
            <input id="mobile" name="mobile" type="text" class="@error('mobile') is-invalid @enderror"/>
            @error('mobile')<div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-submit">Registreer</button>
        </div>
    {!! Form::close() !!}
</div>
@endsection
