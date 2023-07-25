<script setup>
import { toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';
import '../../../../node_modules/@fortawesome/fontawesome-free/css/all.css'; // Add a loading state and initialize it as true

const props = defineProps({
    image: String,
    title: String,
    isLoading: Boolean
});

const { image, title, isLoading } = toRefs(props);
</script>

<template>
    <Link href="#">
        <div v-if="!isLoading" class="bg-gray-800 p-2 rounded-md m-2 w-[230px] h-[300px] rounded-md hover:bg-gray-600 cursor-pointer relative overflow-hidden">
            <div class="relative">
                <img class="rounded" :src="image ? image : '/images/album.png'" alt="">
                <i :class="`fas fa-${icon} text-green-600 text-4xl absolute bottom-2 right-3 transform translate-x-2 translate-y-2 opacity-0 transition-opacity duration-300`"></i>
            </div>
            <div class="text-white pt-4 font-semibold text-[14px]">{{ title }}</div>
            <div v-if="!listeners" class="text-gray-400 pt-1 pb-3 text-[14px]">{{ subTitle }}</div>
            <div v-else class="text-gray-400 pt-1 pb-3 text-[14px]">{{ formatListeners(listeners) }} Listeners</div>
        </div>
        <div v-else class="bg-gray-800 p-6 mt-4 w-[190px] h-[190px] rounded-md m-2 animate-pulse"></div>
    </Link>
</template>

<style>
/* Optional: Add some styling for the loading animation */
@keyframes pulse {
    0%, 100% {
        background-color: #2D3748;
    }
    50% {
        background-color: #4A5568;
    }
}
.animate-pulse {
    animation: pulse 1.5s ease-in-out infinite;
}
</style>
