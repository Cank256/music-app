<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import SearchResults from '../Components/Search/SearchResults.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['action']);

</script>

<template>
    <Head title="Welcome" />
    <MainLayout :action="action">
        <div>
            <SearchResults />
        </div>

    </MainLayout>

</template>
