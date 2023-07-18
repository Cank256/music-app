<script setup>
import SearchTab from '../Components/Search/SearchTab.vue';
import MainLayout from '../Layouts/MainLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
});

</script>

<template>
    <Head title="Welcome" />
    <MainLayout>

    </MainLayout>

</template>
