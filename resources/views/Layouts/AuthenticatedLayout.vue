<script setup>
import { ref } from 'vue';
import TopNav from '../Components/Navs/TopNav.vue'
import AuthenticatedSideNav from '../Components/Navs/SideNavs/AuthenticatedSideNav.vue'

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <TopNav />
            <AuthenticatedSideNav />

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
