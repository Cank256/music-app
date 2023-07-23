<script setup>
import { toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    image: String,
    title: String,
    subTitle: String,
    listeners: Number,
    icon: String,
    type: String,
    mbid: String,
})
const { image, title, subTitle, icon, type, mbid } = toRefs(props)

function formatListeners(num) {
//   return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    if (num >= 1000000) {
        // Convert to millions (M) format
        return (num / 1000000).toFixed(1) + 'M';
    } else if (num >= 1000) {
        // Convert to thousands (K) format
        return (num / 1000).toFixed(1) + 'K';
    }
    // No formatting needed
    return num.toString();
}

</script>

<template>
    <Link :href="route(`search-${type}`, type === 'album' ? { artist: subTitle, album: title } : type === 'album' ? mbid ? { use: 'mbid', mbid } : { use: 'artist', artist: title } : { mbid })">
        <div class="bg-gray-800 p-2 rounded-md m-2 w-[230px] h-[300px] rounded-md hover:bg-gray-600 cursor-pointer relative overflow-hidden">
            <div class="relative">
                <img class="rounded" :src="image" alt="">
                <i :class="`fas fa-${icon} text-green-600 text-4xl absolute bottom-2 right-3 transform translate-x-2 translate-y-2 opacity-0 transition-opacity duration-300`"></i>
            </div>
            <div class="text-white pt-4 font-semibold text-[14px]">{{ title }}</div>
            <div v-if="!listeners" class="text-gray-400 pt-1 pb-3 text-[14px]">{{ subTitle }}</div>
            <div v-else class="text-gray-400 pt-1 pb-3 text-[14px]">{{ formatListeners(listeners) }} Listeners</div>
        </div>
    </Link>
</template>

<style>
    /* Show the icon on hover */
    .bg-gray-800:hover i {
        opacity: 1;
    }
</style>
