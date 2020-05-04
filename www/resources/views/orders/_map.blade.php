@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
@endpush
@push('javascript')
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
    <script type="text/javascript">
        $(function () {
            var map = L.map('map').setView({!! $order->customer->geo_coordinates_string !!}, 10);

            var tile_layer = L.tileLayer(
                "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                {
                    "attribution": '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    "detectRetina": false,
                    "maxNativeZoom": 18,
                    "maxZoom": 18,
                    "minZoom": 0,
                    "noWrap": false,
                    "opacity": 1,
                    "subdomains": "abc",
                    "tms": false
                }
            ).addTo(map);

            var goldIcon = new L.Icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var greenIcon = new L.Icon({
              iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
              shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
              iconSize: [25, 41],
              iconAnchor: [12, 41],
              popupAnchor: [1, -34],
              shadowSize: [41, 41]
            });

            var blueIcon = new L.Icon({
              iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
              shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
              iconSize: [25, 41],
              iconAnchor: [12, 41],
              popupAnchor: [1, -34],
              shadowSize: [41, 41]
            });

            customer = L.marker({!! $order->customer->geo_coordinates_string !!}, {icon: greenIcon}).addTo(map)
                .bindPopup('{{$order->customer->title}}') @if(is_helper()) .openPopup() @endif;

            @if (is_helper() && ($order->working_on_it || is_dispatcher()))
                    @foreach($order->closestHelpers(false) as $helper)
                    L.marker({!! $helper['location_string'] !!}, {icon: @if($helper['id'] == Auth::user()->id) goldIcon @else blueIcon @endif}).addTo(map)
                        .bindPopup('{{$helper['name']}} ({{$helper['distance']}})');
                    @endforeach
            @endif
            @if(!$order->is_new)
                maker = L.marker({!! $order->helper->geo_coordinates_string !!}, {icon: goldIcon}).addTo(map)
                    .bindPopup('{{$order->helper->title}}') @if(is_customer()) .openPopup() @endif;

                var group = new L.featureGroup([customer, maker]);
                map.fitBounds(group.getBounds(), {"padding": [20, 40]});
            @endif
        });
    </script>
@endpush
