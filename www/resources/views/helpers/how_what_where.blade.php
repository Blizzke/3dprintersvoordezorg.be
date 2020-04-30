@extends('layouts.help')
@section('title', 'Hoe, wat, waar?')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>@yield('title')</h1>
            <div class="well">
                <p>Bedankt dat je mee wilt helpen!</p>
                @if (!Auth::user()->hasFeature('agreement:who_what_where')) <p>Gelieve deze pagina helemaal en goed door te lezen indien je gebruik wilt maken van deze site. <b>Pas als je onderaan bevestigd dat alles duidelijk is, krijg je de bestellijsten te zien.</b> </p>@endif
                <p>Voor vragen, suggesties, opmerkingen (na het lezen van deze tekst) kan je de Discord chat gebruiken (link rechtsboven).</p>
            </div>
            <h2>Wat is het opzet?</h2>
            <div class="well">
                In heel België is er veel vraag naar materiaal om te helpen met de huidige crisis.
                Het is niet doenbaar om als solo-maker iedereen te helpen. Daarom hebben we ons onder deze site verenigd.
                We kunnen alle aanvragen die binnen komen dan verdelen over iedereen die participeert, bij voorkeur de
                persoon die het dichtste tegen
                de aanvrager woont. &quot;We&quot; leggen ook niet echt regels op en gebruik van het platform is
                vanzelfsprekend gratis, maar we vragen je wel rekening te houden met onderstaande.
            </div>
            <h2>Mijn account</h2>
            <div class="well">
                <p>Na registratie wordt je gevraagd om op de chat te komen vragen om je account te unlocken. Dit dient om te zorgen dat iedereen minstens een keer gesproken hebben en dat we zeker zijn dat alles duidelijk is.</p>
                <p>Je kan dan in je profiel instellen welke items je wilt maken, je krijgt alleen nieuwe bestellingen te zien van deze items.</p>
            </div>
            <h2>Hoe verloopt een bestelling?</h2>
            <div class="well">
                <h3>Plaatsen</h3>
                <p>Wanneer de klant een bestelling plaatst wordt deze aan de site toegevoegd en indien nodig ook gesplitst.
                    Wanneer de klant meerdere soorten items
                    tegelijk besteld, behandelen we elke type als een aparte bestelling. Zo kan je als helper alleen
                    aannemen wat je effectief wilt/kunt maken.</p>
                <p>De site zal een verwittiging posten op discord in het <i>#bestellingen</i> kanaal. Hierin worden de 5
                    dichtsbijzijnde helpers gemeld.</p>

<!--            <h3>Valideren</h3>
            <p>De bestelling wordt dan opgevolgd door iemand van de site bij de klant. Zorgen dat alles duidelijk is etc.
            Deze persoon kan de bestelling dan vrijgeven naar "nieuw".</p>
            <p>Op dat moment zal een verwittiging gepost worden op discord in het <i>#bestellingen</i> kanaal. Hierin worden de 5
                dichtsbijzijnde helpers gemeld.</p> -->

            <h3>Accepteren</h3>
            <p>Je accepteert een bestelling om 1 van 2 redenen: Je kan ze zelf volledig produceren of je kan aanspreekpunt spelen
                en samenwerken met andere vrijwilligers als ze te groot is voor jouw alleen (bekijk dat wel op voorhand in de chat!).
                In beide gevallen ben jij verantwoordelijk voor de aflevering en het ontvangen van de betaling (en anderen ook betalen).</p>
            <p>Dit kan in het dashboard door op het play icon (<span class="glyphicon glyphicon-play"></span>) te
                klikken.
                Alternatief kan je via de link-button (<span class="glyphicon glyphicon-link"></span>) door klikken naar
                de bestelling-detail pagina (waar je nog wat meer informatie te zien krijgt) en daar "Ik ga deze
                uitvoeren" aan te klikken.</p>
            <p>Eenmaal geaccepteerd krijg je de contactgegevens van de klant te zien voor als je eventueel meer informatie nodig hebt.
                Alleen helpers die het order hebben geaccepteerd krijgen hier inzicht in, in het kader van de privacy. Van zodra je een order weer vrijgeeft of annuleert verlies je deze toegang weer.</p>

            <h3>Contacteren</h3>
            Je neemt dan contact op met de vragende partij om de praktische details van de bestelling af te spreken.

            <h4>Ophalen/Leveren/Opsturen?</h4>
            <p>In de eerste plek is dat hoe de items tot bij de persoon gaan geraken.</p>
            <p>We vragen over het algemeen - omdat er quasi geen winst gemaakt wordt - meestal aan de klant om de
                bestelling te komen halen.</p>
            <p>Dat kan natuurlijk alleen maar als jullie niet te ver uit elkaar wonen. Om hierin bij te staan is er op
                de detailpagina ook een overzichtskaart zichtbaar voor een nieuwe bestelling.</p>
            <p>Opsturen wordt meestal niet gedaan omdat je dan snel over 5&euro; spreekt, wat in veel gevallen meer is
                dan de rest van de bestelling.
                Het kan natuurlijk altijd in overeenkomst met de klant.</p>
            <p>Het staat je natuurlijk ook vrij om zelf te gaan leveren, dat is jouw beslissing. Zorg gewoon voor goede
                afspraken.</p>

            <h4>Prijs</h4>
            <p>Ook af te spreken is de prijs. De site vermeld voor de meeste items (m.u.v de gezichtsmaskers) de maximum
                prijs.
                Dit is de prijs waarvan wij onderling overeen gekomen zijn als zijnde "meer dan dit gaan we niet
                vragen". </p>
            <p>Normaal gezien kom je met deze prijzen qua materiaal zeker uit de kosten. Het staat je altijd vrij om
                minder te vragen of het zelfs gratis aan te bieden,
                dat is jouw keuze. We willen helpers gewoon niet dwingen hun materiaal zo weg te geven. Zolang
                jullie maar tot een akkoord komen.</p>
                <p>Je krijgt het geld <b><u>achteraf</u></b> (bij levering of op factuur). Vraag geen geld op voorhand, dat is NOT DONE.</p>

            <h4>Facturatie</h4>
            <p>Sommige klanten vragen/willen een factuur. Als je dit niet kan/wil, leg dat dan gewoon aan de klant uit
                en dan kan je de bestelling terug vrijgeven. Voeg dan wel een (interne) nota toe zodat de rest hiervan
                weet.</p>

            <h4>Geen akkoord?</h4>
            <p>Als je niet tot een akkoord kan komen met de klant kan je de bestelling weer vrij geven (<span
                    class="glyphicon glyphicon-minus" aria-hidden="true"></span>). De bestelling komt dan weer onder "nieuw" terecht.
                Probeer ook in dit geval een (interne) nota toe te voegen waarom, kom desnoods ook wat op de chat zeggen.</p>

            <h4>Vergissing/Bedenking van de klant?</h4>
            <p>Als de klant het order om een of ander niet meer wilt kan je de bestelling annuleren (<span
                class="glyphicon glyphicon-remove" aria-hidden="true"></span>)</p>

            <h3>Status</h3>
            <p>Elke normale bestelling doorloopt 4 statussen: Toegewezen, In productie, Te leveren, Afgewerkt (Ze begint
                als "Nieuw" en er is ook nog "Geannuleerd")
                Het is aan jou om te zorgen dat je voortgang gereflecteerd wordt in deze status. Van zodra je een
                overeenkomst met de klant hebt en &quot;eraan begint&quot;,
                zet je de bestelling dus in productie. Dat gebeurt via de detail pagina. We hebben momenteel nog geen
                email systeem om notificaties uit te sturen, dus de klant heeft momenteel alleen
                de link naar de bestelpagina om op te volgen.</p>

            <h3>Aantal toevoegen</h3>
            <p>Je kan registeren met hoeveel items je al klaar bent door dit formulier te gebruiken. Meerdere keren mag, de
                tellers houden de status bij. Zo ziet de klant ook de voortgang.</p>
            <p>Het is ook mogelijk om met meerderen samen aan een bestelling te werken. De andere helpers
            gebruiken dan het postvak icon (<span class="glyphicon glyphicon-inbox" aria-hidden="true"></span>, werk
                toevoegen) van op de overzichtspagina.</p>
            <p>Zelfs al heb je alles al, voeg het aantal dan nog altijd toe aan de bestelling, dat behoudt het
                overzicht.</p>

            <h3>Communicatie</h3>
            Zowel jijzelf als de klant kunt commentaar toevoegen die dan verschijnt omder het &quot;verloop bestelling&quot; deel.
            Helpers hebben de keuze om een commentaar als "intern" te markeren.
            Alleen andere helpers kunnen deze commentaar dan zien. Dit kan je bvb gebruiken voor "Betaling ontvangen" of
            andere nota's waarvan de klant die niet per se moet zien.

            <h3>Afgewerkt</h3>
            Als je een bestelling hebt afgewerkt, vergeet dan niet deze op klaar te zetten. Ze verdwijnt dan voor
            iedereen uit de lijst van actieve bestellingen en de tellers op de voorpagina worden ge&euml;pdated.
        </div>

        <h2>Printen</h2>
        <div class="well">
            <p>Van zodra je met een bestelling aan de slag gaat moet je natuurlijk gaan printen.</p>
            <p>Voor elk van de items verschijnt er dan op de bestelpagina wat meer technische details. Kwestie van op
                voorhand eea te kunen bekijken is deze info ook hieronder al eens toegevoegd.</p>
            <h3>Materiaal</h3>
            <p>De technische info van elk item vermeld welke materialen hiervoor kunnen gebruikt worden. We zijn alleen
                zeer strikt met het materiaal voor de gelaatsbeschermers.
                <b>Deze MOETEN IN PETG</b> geprint worden. Als je dit niet wilt/kunt, gelieve ze dan niet via dit
                platform te leveren (tenzij de klant hier expliciet zelf om vraagt en zich van de risico's bewust is).</p>
            <p>De reden waarom, afgezien van het feit dat we dit in overeenstemming beslist hebben, is dat PETG op dit
                moment het enige materiaal is waar we met zekerheid van kunnen zeggen dat het
                te desinfecteren valt. Dit werd onomstotelijk <a
                    href="https://help.prusa3d.com/en/article/prusa-face-shield-disinfection_125457" target="_blank">aangetoond
                    door Prusa</a>.
            </p>
            <h3>Faceshields</h3>
            <h4>Onderdelen</h4>
            <p>Dit is het enige item dat we maken dat uit verschillende onderdelen bestaat. Je hebt sowieso een vizier nodig, dat
            de meesten van ons maken met een lamineerhoes (daar heb je natuurlijk wel een lamineermachine voor nodig) of een overheadtransparant (zijn dunner en moeten extra
            gewassen worden om de "kleefrommel" eraf te krijgen waar je op kan schrijven). Voor de prusa modellen heb je ook nog knoopsgatelastiek of een alternatief nodig
            om het masker aan te kunnen doen.</p>
            <p>
            Niet iedereen kan/wil alle onderdelen doen. Je kan op je profiel ipv het item "Gelaatsscherm" ook een aantal van de "Gedeeltelijk gelaatsscherm" dingen aanvinken.
                Je krijgt dan geen nieuwe bestellingen voor schermen te zien maar je kan optioneel wel andere helpers bijstaan, dat moet je best via de chat co&ouml;rdineren.
            </p>
            <h4>Verstevigingsstuk Vizier</h4>
            <p>De prusa variant heeft een extra verstevigingsstuk voor onderaan op het vizier, maar ervaring leert dat dit meestal niet nodig is. Ofwel is de plastiek die je gebruikt
                er te dun voor en moet je het met lijm bevestigen (of het valt eraf): rommelig, ofwel is de plastiek dik genoeg om zonder ook sterk genoeg te zijn. Ik (Steve G) steek er meestal een paar
                bij elke grotere bestelling (ik lever de shields in onderdelen af omdat ze dan minder plaats innemen/gemakkelijker "proper" te houden zijn) en indien
                de klant er meer wilt komen ze daar achter vragen. Tot op heden (400+ shields) nog geen enkele vraag gehad.
            </p>
            <h4>Waarom PETG?</h4>
            <p>Iederen van ons heeft het argument al geopperd dat ook &quot;PLA te desinfecteren valt&quot; en dat &quot;PLA toch ook
                gebruikt wordt in vele andere landen en daar wel okay is&quot;: Het kan best zijn
                dat PLA eenmalig te desinfecteren valt, of misschien 5, 10 of 100x voor het aftakeling begint te
                vertonen. Het feit is: we weten het niet. Ook het aanvaarden van PLA in andere landen:
                Daar hebben zij expliciet achter gevraagd en zij nemen dan ook het risico op zich.</p>
            <p>Het gaat hier puur om: Wil jij iemands leven verwedden over het feit dat PLA het even goed doet voor een
                verschil in kost van 0.1&euro; per masker? </p>
            <p>De kans is redelijk groot dat jouw gelaatsbeschermer het enige gaat zijn dat de persoon in kwestie gaat hebben en
                kan dragen voor zolang deze crisis nog duurt.</p>
            <p>Kort gezegd: omdat we het niet weten willen we in deze tijden geen enkel risico nemen. Dus we kiezen dus voor het
                veiligste pad. (<a href="https://discordapp.com/channels/697806915861741658/697807457313095780/704194899213287504" target="_blank">klik ook eens hier</a> als je meer achtergrond wilt) </p>
            <p>Het is in het kader hiervan ook belangrijk dat je de klant op de hoogte brengt van de (niet)steriliteit
                van het product en dat hij zelf verantwoordelijkheid neemt hiervoor.
                We helpen mensen wel zoveel we kunnen, maar je wilt duidelijk maken dat aansprakelijkheid bij de klant ligt.
                Voor de gelaatsmaskers is er een disclaimer met meer informatie die je best altijd goed zichtbaar bijleverd.
            </p>
            <p>Dat gezegd zijnde: Be responsable. Werk - zeker voor gelaatsschermen - zoveel mogelijk met handschoenen en
                stop met het produceren van materiaal als je enige symptomen hebt!</p>

            <h3>Overzicht technische info</h3>
            <p>Ter info, dit is de technische info van alle items:</p>
            <ul>
                @foreach(\App\Item::all() as $item)
                    @if($item->maker_info)
                        <li><h4>{{$item->title}}</h4>
                            <dl>
                                @foreach($item->maker_info as $title => $data)
                                    <dt>{{$title}}</dt>
                                    <dd>{!! $data !!}</dd>
                                @endforeach
                            </dl>
                        </li>
                    @endif
                @endforeach
            </uL>
        </div>
        <h2>Mondmaskers</h2>
        <div class="well">
            Mondmaskers is een speciaal geval en wordt enkel door de mensen gedaan die hiervan stock hebben. Momenteel gaat het om (discord handles) timmeyvis, Davy Present en Steve G.
        </div>
        @if (!Auth::user()->hasFeature('agreement:who_what_where'))
        <div class="well">
            <form method="post">
                @csrf
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Ik bevestig alles gelezen en begrepen te hebben.">
                </div>
            </form>
        </div>
        @endif
    </div>

@endsection
