@extends('layouts.request')
@section('title', "Items bestellen")
@section('content')
<form method="post" action="/order/new" class="form-horizontal">
    @csrf
    <div class="col-sm-12">
        <h2>Gegevens</h2>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Type *</label>
        <div class="col-sm-9">
            @foreach(['zorgverlening' => 'Zorgverlener/Zorg instelling/School', 'supermarkt' => 'Winkel/bevoorrading',
                        'bedrijf' => 'Werknemer/Werkgever', 'prive' => 'Privé/Particulier', 'helper' => 'Corona Helper (Privé)'] as $id => $name)
            <label class="radio-inline">
                <input type="radio" name="type" id="{{$id}}" value="{{$id}}"> {{$name}}
            </label>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="name">Naam (Instelling/Bedrijf/Persoon) *</label>
        <div class="col-sm-5">
            <input type="text" name="name" id="name" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="for">Ter attentie van</label>
        <div class="col-sm-5">
            <input type="text" name="for" id="for" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="street">Straat</label>
        <div class="col-sm-9">
            <input type="text" name="street" id="street" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="number">Nummer</label>
        <div class="col-sm-1">
            <input type="text" name="number" id="number" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="zip">Postcode *</label>
        <div class="col-sm-2">
            <input type="text" name="zip" id="zip" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="city">Gemeente</label>
        <div class="col-sm-4">
            <input type="text" name="city" id="city" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="country">Land</label>
        <div class="col-sm-4">
            <select class="form-control">
                <option value="1" selected>Belgi&euml;</option>
                <option value="2">Nederland</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <h2>Contactmethodes (minstens 1 invullen)</h2>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="phone">Telefoon</label>
        <div class="col-sm-5">
            <input type="text" name="phone" id="phone" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="mobile">GSM</label>
        <div class="col-sm-5">
            <input type="text" name="mobile" id="mobile" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="email">E-mail</label>
        <div class="col-sm-5">
            <input type="text" name="email" id="email" class="form-control" />
        </div>
    </div>
    <div class="col-sm-12">
        <h2>Item</h2>
    </div>
    <div class="col-sm-12">
        <p>Door de oplopende materiaalkost zien we ons genoodzaakt een vergoeding aan te rekenen om ons toe te laten nieuw materiaal aan te schaffen.</p>
        <p>Wanneer er "maximum" vermeld staat wil dat zeggen dat de kostprijs nooit meer zal zijn, maar mogelijk wel minder.<br/>
            Het hangt van kost af van de persoon die je bestelling zal behandelen en wordt eerst overeengekomen voor er tot productie wordt overgegaan.</p>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="item">Ik zou graag willen *</label>
        <div class="col-sm-9">
        @foreach($items as $item)
            <div class="radio">
                <label>
                <input type="radio" name="item" value="{{$item->name}}">
                    <b>{{$item->title}}</b><br/>
                    Bestelhoeveelheid/Prijs: {{$item->verbose_price}} {{ $item->unit }}<br/>
                    {!! $item->description !!}<br/>
                    <a href="{{$item->image()}}" data-toggle="lightbox" data-title="{{$item->title}}">
                        <img src="{{$item->image('small')}}" height="100" alt="{{$item->title}}" class="img-fluid"/>
                    </a>
                </label>
            </div>
        @endforeach
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="quantity">Aantal *</label>
        <div class="col-sm-1">
            <input type="text" name="quantity" id="quantity" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="comment">Opmerkingen</label>
        <div class="col-sm-9">
            <textarea type="text" name="comment" id="comment" rows="5" class="form-control"></textarea>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
@endsection

