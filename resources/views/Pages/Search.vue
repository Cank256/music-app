<script setup>
import { watchEffect, ref } from 'vue';
import MainLayout from '../Layouts/MainLayout.vue';
import SearchResults from '../Components/Search/SearchResults.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['action']);

</script>

<template>
    <Head title="Search" />
    <MainLayout :action="action">
        <SearchResults />
    </MainLayout>

</template>
