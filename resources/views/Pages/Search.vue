<script setup>
import SearchTab from '../Components/SearchTab.vue';
import GuestLayout from '../Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
});

</script>

<template>
    <Head title="Welcome" />
    <GuestLayout>

    </GuestLayout>

</template>
