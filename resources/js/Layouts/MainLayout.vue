<script setup>
import TopNav from '@/Components/Navs/TopNav.vue'
import SideNav from '@/Components/Navs/SideNav.vue'

</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <TopNav />
        <SideNav />

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
