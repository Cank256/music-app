<script setup>
import { Link } from '@inertiajs/vue3';
import '../../../../node_modules/@fortawesome/fontawesome-free/css/all.css';
</script>

<template>
    <div class="bottom-nav lg:hidden dark:bg-gray-900 fixed bottom-0 left-0 right-0 h-[60px] flex items-center justify-around">
        <Link :href="route('home')"><i class="fas fa-house text-gray-400 text-2xl"></i></Link>
        <Link :href="route('search')"><i class="fas fa-magnifying-glass text-gray-400 text-2xl"></i></Link>
        <Link :href="route('library')"><i class="fas fa-book text-gray-400 text-2xl"></i></Link>
        <Link :href="route('browse')"><i class="fas fa-dharmachakra text-gray-400 text-2xl"></i></Link>
        <Link :href="route('profile')"><i class="fas fa-user text-gray-400 text-2xl"></i></Link>
    </div>
</template>
