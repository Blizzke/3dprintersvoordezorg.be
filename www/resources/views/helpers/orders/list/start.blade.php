<div class="well">
    <table class="table table-hover table-striped">
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
            @if(isset($show) && in_array('status', $show))
                <td>Status</td>
            @endif
            <td>Acties</td>
        </tr>
        </thead>
