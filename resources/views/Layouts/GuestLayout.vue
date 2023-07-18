<script setup>
import TopNav from '../Components/Navs/TopNav.vue'
import GuestSideNav from '../Components/Navs/SideNavs/GuestSideNav.vue'
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 mt-1">
            <TopNav/>
            <GuestSideNav/>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
html {
    background: rgb(17 24 39);
}
</style>
