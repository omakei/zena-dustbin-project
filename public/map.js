var maplayer = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        })
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([34.8924826, -6.3728253]),
        zoom: 4
    })
});

var trashStyle = new ol.style.Style({
    image: new ol.style.Icon({
        anchor: [0, 0],
        size: [120, 120],
        offset: [0, 0],
        opacity: 1,
        scale: 0.25,
        src: 'dustbin.png'
    })
});


omakei.forEach((data, index)=> {
    // let layerVector+index = ;
    console.log(data.lon)
    maplayer.addLayer(new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [
                new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([data.lon, data.lat])),
                })
            ]
        }),
        style: trashStyle
    }));
})



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
maplayer.addOverlay(overlay);

// closer.onclick = function() {
//     overlay.setPosition(undefined);
//     closer.blur();
//     return false;
// };

maplayer.on('singleclick', function (event) {
    if (map.hasFeatureAtPixel(event.pixel) === true) {
        var coordinate = event.coordinate;

        content.innerHTML = `Dustbin Location`;
        overlay.setPosition(coordinate);
    } else {
        overlay.setPosition(undefined);
        closer.blur();
    }
});
