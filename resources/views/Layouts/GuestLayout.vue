<script setup>
import GuestTopNav from '../Components/Navs/TopNavs/GuestTopNav.vue'
import GuestSideNav from '../Components/Navs/SideNavs/GuestSideNav.vue'
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 mt-1">
            <GuestTopNav/>
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
