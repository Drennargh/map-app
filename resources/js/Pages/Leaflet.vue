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
    routes: null,
});
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


