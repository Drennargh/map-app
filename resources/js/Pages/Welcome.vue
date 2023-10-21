<script setup>
import { Head } from '@inertiajs/vue3';
import Leaflet from '@/Components/Leaflet.vue';


</script>

<template>
    <Head title="Welcome" />
    <Leaflet :gpxFile="'/gpx/via-emilia.gpx'"></Leaflet>

</template>

<style>
</style>
