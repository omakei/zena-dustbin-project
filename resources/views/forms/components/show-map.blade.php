<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/css/ol.css" type="text/css">
    <style>
        .map {
            height: 400px;
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/build/ol.js"></script>
    <title>Zena Dustbin Project</title>
</head>
<body>
<h2 style="padding-bottom: 5px; font-weight: bold">  {{(\App\Models\Dustbin::find($getLabel()))->registration_number}} Dustbin Location</h2>
<div id="map" class="map"></div>
<div id="popup" class="ol-popup">
    <a href="#" id="popup-closer" class="ol-popup-closer"></a>
    <div id="popup-content"></div>
</div>
<script type="text/javascript">
    var trashStyle = new ol.style.Style({
        image: new ol.style.Icon({
            anchor: [0, 0],
            size: [120, 120],
            offset: [0, 0],
            opacity: 1,
            scale: 0.25,
            src: `{{asset('dustbin.png')}}`
        })
    });

    var zoomToExtentControl = new ol.control.ZoomToExtent({
        extent: [34.8924826, -6.3728253, 34.8924826, -6.3728253]
    });

    var map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            }),
        ],
        controls: ol.control.defaults({
            zoom: true,
            attribution: true,
            rotate: true
        }),
        view: new ol.View({
            center: ol.proj.fromLonLat([{{(\App\Models\Dustbin::find($getLabel()))->longitude}}, {{(\App\Models\Dustbin::find($getLabel()))->latitude}}]),
            zoom: 13
        })
    });

    var layer = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [
                new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([{{(\App\Models\Dustbin::find($getLabel()))->longitude}}, {{(\App\Models\Dustbin::find($getLabel()))->latitude}}])),
                })
            ]
        }),
        style: trashStyle
    });



    map.addLayer(layer);
    layer.getSource().changed();

    var container = document.getElementById('popup');
    var content = document.getElementById('popup-content');
    var closer = document.getElementById('popup-closer');

    var overlay = new ol.Overlay({
        element: container,
        autoPan: true,
        autoPanAnimation: {
            duration: 250
        }
    });


    closer.onclick = function() {
        overlay.setPosition(undefined);
        closer.blur();
        return false;
    };

    map.on('singleclick', function (event) {

        if (map.hasFeatureAtPixel(event.pixel) === true) {
            var coordinate = event.coordinate;

            content.innerHTML = `{{(\App\Models\Dustbin::find($getLabel()))->registration_number}} Dustbin Location`;
            overlay.setPosition(coordinate);
        } else {
            overlay.setPosition(undefined);
            closer.blur();
        }
    });

    map.addControl(zoomToExtentControl);
    var controls = map.getControls();
    var attributionControl;
    controls.forEach(function (el) {
        console.log(el instanceof ol.control.Attribution);
        if (el instanceof ol.control.Attribution) {
            attributionControl = el;
        }
    });
    map.removeControl(attributionControl);
    map.updateSize();
</script>
</body>
</html>







{{--<x-forms::field-wrapper--}}
{{--    :id="$getId()"--}}
{{--    :label="$getLabel()"--}}
{{--    :label-sr-only="$isLabelHidden()"--}}
{{--    :helper-text="$getHelperText()"--}}
{{--    :hint="$getHint()"--}}
{{--    :hint-icon="$getHintIcon()"--}}
{{--    :required="$isRequired()"--}}
{{--    :state-path="$getStatePath()"--}}
{{-->--}}
{{--    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">--}}
{{--        <!-- Interact with the `state` property in Alpine.js -->--}}
{{--    </div>--}}
{{--    <div id="map" class="map"></div>--}}

{{--</x-forms::field-wrapper>--}}
{{--@push('script')--}}
{{--    console.log('omakei')--}}
{{--    var layer = new ol.layer.Vector({--}}
{{--            source: new ol.source.Vector({--}}
{{--                features: [--}}
{{--                    new ol.Feature({--}}
{{--                        geometry: new ol.geom.Point(ol.proj.fromLonLat([0,0]),--}}
{{--                    })--}}
{{--                ]--}}
{{--            })--}}
{{--         });--}}

{{--    map.addLayer(layer);--}}


{{--    var container = document.getElementById('popup');--}}
{{--    var content = document.getElementById('popup-content');--}}
{{--    var closer = document.getElementById('popup-closer');--}}

{{--    var overlay = new ol.Overlay({--}}
{{--        element: container,--}}
{{--        autoPan: true,--}}
{{--        autoPanAnimation: {--}}
{{--         duration: 250--}}
{{--        }--}}
{{--    });--}}
{{--    map.addOverlay(overlay);--}}

{{--    closer.onclick = function() {--}}
{{--        overlay.setPosition(undefined);--}}
{{--        closer.blur();--}}
{{--        return false;--}}
{{--    };--}}

{{--    map.on('singleclick', function (event) {--}}
{{--        if (map.hasFeatureAtPixel(event.pixel) === true) {--}}
{{--            var coordinate = event.coordinate;--}}

{{--            content.innerHTML = `Dustbin Location`;--}}
{{--            overlay.setPosition(coordinate);--}}
{{--        } else {--}}
{{--            overlay.setPosition(undefined);--}}
{{--            closer.blur();--}}
{{--        }--}}
{{--    });--}}

{{--@endpush--}}
