<div class="well">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            @if(isset($show) && in_array('id', $show))
                <td>#</td>
            @endif
            <td>Aangevraagd op</td>
            <td>Sector</td>
            <td>Naam</td>
            <td>Locatie</td>
            <td>Gevraagd</td>
            @if(isset($show) && in_array('helper', $show))
                <td>Door</td>
            @endif
            @if(isset($show) && in_array('status', $show))
                <td>Status</td>
            @endif
            <td>Acties</td>
        </tr>
        </thead>
