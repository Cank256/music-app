<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import BrowseAll from '../Components/Browse/BrowseAll.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['topTags']);

console.log(props.topTags);

</script>

<template>
    <Head title="Browse" />
    <MainLayout>
        <BrowseAll :tags="topTags" />

    </MainLayout>

</template>
