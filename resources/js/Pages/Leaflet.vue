<script setup>
import { reactive, onMounted, defineProps } from 'vue';
import L from 'leaflet';
import '@raruto/leaflet-elevation/src/index.js';
import '@raruto/leaflet-elevation/src/index.css';

const props = defineProps({
    tracks: {
        type: Array,
        required: true,
    }
});

const data = reactive({
    map: null,
    elevationControl: null,
    pointIcon: null,
    points: null,

});
data.points = [
    { latlng: [47.5854438, 18.8260240], name: "Éles-kő" },
    { latlng: [47.5838863, 18.8235221], name: "Ilona-lak" },
    { latlng: [47.5689002, 18.8909285], name: "Bronz-barlang" },
    { latlng: [47.5574055, 18.8954788], name: "Karády-lak" },
    { latlng: [47.5860042, 18.8590258], name: "Kereszt a Kutya-hegyi kőfejtőnél" },
    { latlng: [47.5946092, 18.8383717], name: "Kutya-hegyi zsomboly" },
    { latlng: [47.5852204, 18.8420916], name: "vaditató" },
    { latlng: [47.5675421, 18.8644739], name: "mészégető" },
    { latlng: [47.5568284, 18.8683407], name: "festékégető" },
    { latlng: [47.5627022, 18.8804863], name: "festékégető" },
    { latlng: [47.5825126, 18.8512647], name: "kőfejtő" },
    { latlng: [47.5966170, 18.8405121], name: "barlang" },
    { latlng: [47.5692769, 18.9233352], name: "vaslelőhely" },
    { latlng: [47.5609284, 18.9319601], name: "Hét-lyuk zsomboly" },
    { latlng: [47.5532424, 18.8973270], name: "festékégető" },
    { latlng: [47.5372269, 18.8914775], name: "katonasírok" },
    { latlng: [47.5934486, 18.8812427], name: "Fülkés-kő" },
];
onMounted(() => {
    initMap();
    loadGPX(props.tracks);
});

function initMap() {
    data.map = L.map('map').setView([41.4583, 12.7059], 5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        Id: 'topo',
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        attribution: '&copy; <a href="https://github.com/adoroszlai">Attila Doroszlai</a> (<a href="https://github.com/adoroszlai/joebed/blob/gh-pages/LICENSE.md">MIT License</a>)',
    }).addTo(data.map);

    data.pointIcon = L.icon({
        iconUrl: 'images/elevation-point.png',
        iconSize: [12, 12], // size of the icon
    });
    L.marker([51.5, -0.09], { icon: data.pointIcon }).addTo(data.map);
    // Iterate through the points and add markers to the map
    data.points.forEach(function (point) {
        var marker = L.marker(point.latlng, { icon: data.pointIcon }).addTo(data.map);
        marker.bindPopup(point.name);
    });


    data.elevationControl = L.control.elevation({
        theme: 'yellow-theme',
        detached: true,
        elevationDiv: '#elevation-div',
        followMarker: true,
        zFollow: 15,
        legend: false,
        srcFolder: 'http://unpkg.com/@raruto/leaflet-elevation/src/',
    }).addTo(data.map);

}

function loadGPX(fileNames) {
    for (const originalFileName of fileNames) {
        const fileName = `/tracks/${originalFileName}.gpx`;

        data.elevationControl.load(fileName);
    }
}


</script>

<template>
    <div class="flex flex-col h-screen max-h-screen">
        <div id="map" class="h-full z-10"></div>
    </div>
</template>


