@extends('layouts.request')
@section('title', "Ik zoek materiaal")
@section('content')


    <div class="block-31" style="position: relative;">
        <div class="owl-carousel loop-block-31 ">
            <div class="block-30 block-30-sm item" style="background-image: url('/images/shields1.jpg');"
                 data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-lg-7">
                            <h2 class="heading mb-5">@yield('title')</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section bg-light">
        <div class="container">
            <form method="post" action="/order/new" class="form-horizontal order-form">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Gegevens</h2>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="customer_id">Klantnummer</label>
                            <div class="col-lg-9">
                                <input type="text" name="customer_id" id="customer_id" class="form-control"
                                       value="{{ old('customer_id') }}"/>
                            </div>
                            <div class="col-lg-9 offset-lg-3">
                                (indien je het hebt: klantnummer van een vorige bestelling, je mag de rest van de
                                gegevens/contact leeg laten)
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label">Sector *</label>
                            <div class="col-lg-9">
                                @foreach(['zorgverlening' => 'Zorgverlener/Zorg instelling/School', 'supermarkt' => 'Winkel/bevoorrading',
                                            'bedrijf' => 'Werknemer/Werkgever', 'prive' => 'Privé/Particulier', 'helper' => 'Corona Helper (Privé)'] as $id => $name)
                                    <label class="radio-inline">
                                        <input type="radio" name="sector" id="{{$id}}"
                                               value="{{$id}}" {{ old('sector')==$id ? 'checked' : '' }}> {{$name}}
                                    </label>
                                @endforeach
                                @error('sector')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="name">Naam *</label>
                            <div class="col-lg-9">
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"/>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-lg-9 offset-lg-3">
                                <p>(Instelling/Bedrijf/Persoon)</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="street">Straat</label>
                            <div class="col-lg-5">
                                <input type="text" name="street" id="street" class="form-control"
                                       value="{{ old('street') }}"/>
                            </div>
                            <label class="col-lg-2 control-label" for="number">Nummer</label>
                            <div class="col-lg-2">
                                <input type="text" name="number" id="number" class="form-control"
                                       value="{{ old('number') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="zip">Postcode *</label>
                            <div class="col-lg-2">
                                <input type="text" name="zip" id="zip"
                                       class="form-control @error('zip') is-invalid @enderror"
                                       value="{{ old('zip') }}"/>
                                @error('zip')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                            <label class="col-lg-2 control-label" for="city">Gemeente</label>
                            <div class="col-lg-5">
                                <input type="text" name="city" id="city" class="form-control"
                                       value="{{ old('city') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="country_id">Land</label>
                            <div class="col-lg-9">
                                <select class="form-control" id="country_id" name="country_id">
                                    <option value="1" selected>Belgi&euml;</option>
                                    <option value="2">Nederland</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h2>Contactmethodes (minstens 1 invullen)</h2>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="phone">Telefoon</label>
                            <div class="col-lg-9">
                                <input type="text" name="phone" id="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}"/>
                                @error('phone')<div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="mobile">GSM</label>
                            <div class="col-lg-9">
                                <input type="text" name="mobile" id="mobile"
                                       class="form-control @error('mobile') is-invalid @enderror"
                                       value="{{ old('mobile') }}"/>
                                @error('mobile')<div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="email">E-mail</label>
                            <div class="col-lg-9">
                                <input type="text" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"/>
                                @error('email')<div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="for">Ter attentie van</label>
                            <div class="col-lg-9">
                                <input type="text" name="for" id="for" class="form-control" value="{{ old('for') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="comment">Opmerkingen</label>
                            <div class="col-lg-9">
                        <textarea type="text" name="comment" id="comment" rows="5"
                                  class="form-control">{{ old('comments') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 2rem;">
                    <div class="col-lg-12">
                        <h2>Item</h2>
                        <div class="well">
                        <p>Door de oplopende materiaalkost zien we ons genoodzaakt een vergoeding aan te rekenen om
                            ons toe te laten nieuw materiaal aan te schaffen.</p>
                        <p>Wanneer er "<i>maximum</i>" vermeld staat wil dat zeggen dat de kostprijs nooit meer zal zijn,
                            maar mogelijk wel minder.<br/>
                            De effectieve prijs <b>wordt eerst overeengekomen</b> voor er geprint wordt,
                            want deze hangt af van de kosten van de persoon die je bestelling zal behandelen. <p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        @error('quantity')<div class="alert alert-danger">{{ $message }}</div> @enderror

                        <div class="form-group row">
                            @foreach($items as $item)
                                <div class="col-sm-12 col-md-6 col-lg-4 d-flex align-items-stretch" style="margin-bottom: 2em;">
                                    <div class="card">
                                        <a href="{{$item->image()}}" data-fancybox="images" data-title="{{$item->title}}">
                                            <img src="{{$item->image('small')}}" class="card-img-top" alt="{{$item->title}}" style="max-height: 280px;">
                                        </a>
                                        <div class="card-body">
                                            <label for="{{$item->type}}"><h5 class="card-title">{{$item->title}}</h5></label>
                                            <p class="card-text">
                                                {!! $item->description !!}
                                            </p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">{{$item->verbose_price}} {{ $item->unit }}</li>
                                            <li class="list-group-item">
                                                <label class="control-label" for="item">Aantal stuks *</label>
                                                <input type="text" name="quantity[{{$item->type}}]" id="{{$item->name}}" class="form-control" placeholder="0" value="{{old("quantity.{$item->type}")}}"/>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-danger">
                                    <p>Beste mensen: dit is <b>geen webshop</b>!</p>
                                    <p>Elke aanvraag wordt door 1 of meerdere vrijwilligers - zo dicht mogelijk in je buurt - opgepikt.</p>
                                    <p>We doen <i>onze uiterste best</i> maar kunnen helaas geen garanties bieden over de levertermijn en of er &uuml;berhaupt iemand in je buurt actief is.
                                        Gelieve hier rekening mee te houden! Je kan het mogelijk sneller krijgen als je bereid bent voor verzending te betalen (dan kunnen verder-wonende vrijwilligers dit ook opnemen), maar bpost rekent toch al snel 6€/pak aan.</p>
<!--                                    <p>De meeste vrijwilligers <b>kunnen geen factuur opmaken</b>.<br/>
                                        Als je er toch een wil:<br/>
                                    <ul>
                                        <li>Beperkt dit het aantal mensen dat je aanvraag kan opnemen enorm.</li>
                                        <li>Bij verwerking door meerdere vrijwilligers kan elke vrijwilliger alleen zijn stuk factureren.</li>
                                        <li>Voor enkele &euro;'s een factuur opmaken is enorm kostinefficient, een boekhouder vraagt meer om dat in te boeken.</li>
                                        <li>(uitzondering hierop is de IIR maskers, iedereen die deze verdeeld kan hiervoor factuur opmaken)</li>
                                    </ul>-->
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button class="btn btn-success btn-submit" style="width: 100%">Bestel</button>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>

@endsection

