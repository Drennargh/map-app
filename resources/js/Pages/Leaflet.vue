<script setup>
import { reactive, onMounted, defineProps } from "vue";
import "@raruto/leaflet-elevation/libs/leaflet-distance-marker.css";
import "@raruto/leaflet-elevation/libs/leaflet-distance-marker.js";
import "@raruto/leaflet-elevation/libs/leaflet-gpxgroup.js";
import "@raruto/leaflet-elevation/dist/leaflet-elevation.min.css";
import "@raruto/leaflet-elevation/dist/leaflet-elevation.min.js";
import "@raruto/leaflet-elevation/libs/leaflet-edgescale.js";

const props = defineProps({
    tracks: {
        type: Array,
        required: true,
    },
});
const data = reactive({
    opts: null,
    points: null,
    map: null,
    routes: null,
});

data.opts = {
    map: {
        center: [41.4583, 12.7059],
        zoom: 5,
        fullscreenControl: false,
        searchControl: false,
        loadingControl: false,
    },
    points: {
        icon: {
            iconUrl: "images/elevation-point.png",
            iconSize: [12, 12],
        },
    },
    elevation: {
        theme: "yellow-theme",
        detached: true,
        elevationDiv: "#elevation-div",
        legend: false,
        srcFolder: "http://unpkg.com/@raruto/leaflet-elevation/src/",
    },
    elevationControl: {
        url: "https://raruto.github.io/leaflet-elevation/examples/via-emilia.gpx",
        options: {
            theme: "lightblue-theme",
            collapsed: false,
            detached: true,
            summary: "multiline",
            hotline: false,
        },
    },
    layersControl: {
        options: {
            collapsed: false,
        },
    },
};
data.points = [
    { latlng: [47.5854438, 18.826024], name: "Éles-kő" },
    { latlng: [47.5838863, 18.8235221], name: "Ilona-lak" },
    { latlng: [47.5689002, 18.8909285], name: "Bronz-barlang" },
    { latlng: [47.5574055, 18.8954788], name: "Karády-lak" },
    {
        latlng: [47.5860042, 18.8590258],
        name: "Kereszt a Kutya-hegyi kőfejtőnél",
    },
    { latlng: [47.5946092, 18.8383717], name: "Kutya-hegyi zsomboly" },
    { latlng: [47.5852204, 18.8420916], name: "vaditató" },
    { latlng: [47.5675421, 18.8644739], name: "mészégető" },
    { latlng: [47.5568284, 18.8683407], name: "festékégető" },
    { latlng: [47.5627022, 18.8804863], name: "festékégető" },
    { latlng: [47.5825126, 18.8512647], name: "kőfejtő" },
    { latlng: [47.596617, 18.8405121], name: "barlang" },
    { latlng: [47.5692769, 18.9233352], name: "vaslelőhely" },
    { latlng: [47.5609284, 18.9319601], name: "Hét-lyuk zsomboly" },
    { latlng: [47.5532424, 18.897327], name: "festékégető" },
    { latlng: [47.5372269, 18.8914775], name: "katonasírok" },
    { latlng: [47.5934486, 18.8812427], name: "Fülkés-kő" },
];

onMounted(() => {
    // Initialize the map
    initMap();
    // Load GPX files
    loadGPX(props.tracks);
});
function initMap() {
    data.map = L.map("map", data.opts.map);
}
function loadGPX(fileNames) {
    fileNames = ["bfmt-lw", "bfmt-hm", "bfmt-sr"];
    fileNames = ["bfmt-lw"];

    if (fileNames.length > 1) {
        loadMultipleTracks(fileNames);
    } else {
        loadSingleTrack(fileNames);
    }
}

function loadSingleTrack(track) {
    const controlElevation = L.control
        .elevation(data.opts.elevationControl.options)
        .addTo(data.map);
    // const controlLayer = L.control.layers(null, null, data.opts.layersControl.options);

    // controlElevation.on(
    //     "eledata_loaded",
    //     ({ layer, name }) =>
    //         controlLayer.addTo(map) &&
    //         layer.eachLayer(
    //             (trkseg) =>
    //                 trkseg.feature.geometry.type != "Point" &&
    //                 controlLayer.addOverlay(
    //                     trkseg,
    //                     (trkseg.feature &&
    //                         trkseg.feature.properties &&
    //                         trkseg.feature.properties.name) ||
    //                         name
    //                 )
    //         )
    // );

    controlElevation.load(modifyFileNames(track));
}

function loadMultipleTracks(tracks) {
    data.map.on("plugins_loaded", function (e) {
        data.routes = L.gpxGroup(modifyFileNames(tracks), {
            points: data.points,
            points_options: data.opts.points,
            elevation: true,
            elevation_options: data.opts.elevation,
            legend: true,
            distanceMarkers: true,
        });
        // remove chart-placeholder text
        data.map.on("eledata_added eledata_clear", ({ type }) => {
            let p = document.querySelector(".chart-placeholder");
            if (p) {
                p.style.display = type == "eledata_added" ? "none" : "";
            }
        });
        data.routes.addTo(data.map);
    });
}

function modifyFileNames(fileNames) {
    // Use the map method to modify each file name
    const modifiedFileNames = fileNames.map((originalFileName) => {
        return `/tracks/${originalFileName}.gpx`;
    });
    return modifiedFileNames;
}
</script>

<template>
    <div class="flex flex-col h-screen max-h-screen">
        <div id="map" class="h-full z-10"></div>
        <div id="elevation-div" class="leaflet-control elevation">
            <p
                class="chart-placeholder min-h-20 text-center font-sans italic opacity-60 text-sm"
            >
                move mouse over a track...
            </p>
        </div>
    </div>
</template>

<style>
.leaflet-right .leaflet-control-layers-list {
    max-width: 250px;
    max-height: 25vh;
    overflow: auto;
}

.leaflet-tooltip {
    font-weight: 700;
}
</style>
