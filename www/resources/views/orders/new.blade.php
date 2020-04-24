@extends('layouts.request')
@section('title', "Ik zoek materiaal")
@section('content')


    <div class="block-31" style="position: relative;">
        <div class="owl-carousel loop-block-31 ">
            <div class="block-30 block-30-sm item" style="background-image: url('/images/shields1.jpg');"
                 data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-md-7">
                            <h2 class="heading mb-5">@yield('title')</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="site-section bg-light">
        <div class="container">
            <div class="row">

                    <form method="post" action="/order/new" class="form-horizontal">
                        @csrf

                            <h2>Gegevens</h2>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="customer_id">Klantnummer</label>
                            <div class="col-sm-3">
                                <input type="text" name="customer_id" id="customer_id" class="form-control"
                                       value="{{ old('customer_id') }}"/>
                            </div>
                            <div class="col-sm-6">
                                (indien je het hebt: klantnummer van een vorige bestelling, je mag de rest van de
                                gegevens/contact leeg laten)
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Sector *</label>
                            <div class="col-sm-9">
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
                            <label class="col-sm-3 control-label" for="name">Naam (Instelling/Bedrijf/Persoon) *</label>
                            <div class="col-sm-5">
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"/>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="street">Straat</label>
                            <div class="col-sm-9">
                                <input type="text" name="street" id="street" class="form-control"
                                       value="{{ old('street') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="number">Nummer</label>
                            <div class="col-sm-1">
                                <input type="text" name="number" id="number" class="form-control"
                                       value="{{ old('number') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="zip">Postcode *</label>
                            <div class="col-sm-2">
                                <input type="text" name="zip" id="zip"
                                       class="form-control @error('zip') is-invalid @enderror"
                                       value="{{ old('zip') }}"/>
                                @error('zip')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="city">Gemeente</label>
                            <div class="col-sm-4">
                                <input type="text" name="city" id="city" class="form-control"
                                       value="{{ old('city') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="country_id">Land</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="country_id" name="country_id">
                                    <option value="1" selected>Belgi&euml;</option>
                                    <option value="2">Nederland</option>
                                </select>
                            </div>
                        </div>

                        <h2>Contactmethodes (minstens 1 invullen)</h2>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="phone">Telefoon</label>
                            <div class="col-sm-5">
                                <input type="text" name="phone" id="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}"/>
                                @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="mobile">GSM</label>
                            <div class="col-sm-5">
                                <input type="text" name="mobile" id="mobile"
                                       class="form-control @error('mobile') is-invalid @enderror"
                                       value="{{ old('mobile') }}"/>
                                @error('mobile')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="email">E-mail</label>
                            <div class="col-sm-5">
                                <input type="text" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"/>
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <h2>Item</h2>

                        <div class="col-sm-12">
                            <p>Door de oplopende materiaalkost zien we ons genoodzaakt een vergoeding aan te rekenen om
                                ons toe te laten nieuw materiaal aan te schaffen.</p>
                            <p>Wanneer er "maximum" vermeld staat wil dat zeggen dat de kostprijs nooit meer zal zijn,
                                maar mogelijk wel minder.<br/>
                                Het hangt van kost af van de persoon die je bestelling zal behandelen en wordt eerst
                                overeengekomen voor er tot productie wordt overgegaan.</p>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="item">Ik zou graag willen *</label>
                            <div class="col-sm-9">
                                @foreach($items as $item)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="item"
                                                   value="{{$item->name}}" {{ old('item')==$item->name ? 'checked' : '' }}>
                                            <b>{{$item->title}}</b><br/>
                                            Bestelhoeveelheid/Prijs: {{$item->verbose_price}} {{ $item->unit }}<br/>
                                            {!! $item->description !!}<br/>
                                            <a href="{{$item->image()}}" data-fancybox="images"
                                               data-title="{{$item->title}}">
                                                <img src="{{$item->image('small')}}" height="100" alt="{{$item->title}}"
                                                     class=""/>
                                            </a>
                                        </label>
                                    </div>
                                @endforeach
                                @error('item')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="quantity">Aantal *</label>
                            <div class="col-sm-2">
                                <input type="text" name="quantity" id="quantity"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity') }}"/>
                                @error('quantity')
                                <div class="alert alert-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="for">Ter attentie van</label>
                            <div class="col-sm-5">
                                <input type="text" name="for" id="for" class="form-control" value="{{ old('for') }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="comment">Opmerkingen</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="comment" id="comment" rows="5"
                                          class="form-control">{{ old('comments') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button class="btn btn-success btn-submit" style="width: 100%">Bestel</button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>





    <script type="text/javascript">
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@endsection

