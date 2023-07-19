<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import SearchResults from '../Components/Search/SearchResults.vue';
import BrowseAll from '../Components/Browse/BrowseAll.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['action', 'topArtists', 'topAlbums', 'topSongs']);

</script>

<template>
    <Head title="Welcome" />
    <MainLayout :action="action">
        <div>
            <BrowseAll />
        </div>
        <div>
            <SearchResults />
        </div>

    </MainLayout>

</template>
