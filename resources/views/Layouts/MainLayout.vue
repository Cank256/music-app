<script setup>
import TopNav from '../Components/Navs/TopNav.vue'
import SideNav from '../Components/Navs/SideNav.vue'

defineProps({
    action: String
})

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <TopNav :action="action" />
            <SideNav />

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
