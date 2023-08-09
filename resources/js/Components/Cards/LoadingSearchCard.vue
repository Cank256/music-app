<script setup>
import { toRefs, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import '../../../../node_modules/@fortawesome/fontawesome-free/css/all.css'; // Add a loading state and initialize it as true

const props = defineProps({
    image: String,
    title: String,
    subTitle: String,
    listeners: Number,
    icon: String,
    type: String,
    mbid: String,
    isLoading: Boolean
});

const { image, title, subTitle, icon, type, mbid, isLoading } = toRefs(props);

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

let capitalizedTitle = computed(() => {
    if (!title.value) return '';
    return title.value.replace(/\b\w/g, function (l) { return l.toUpperCase() });
});

</script>

<template>
    <Link :href="route(`get-${type}`, type === 'album' ? { artist: subTitle, album: title } : type === 'artist' ? mbid ? { use: 'mbid', mbid } : { use: 'name', artist: title } : { mbid })">
        <div v-if="!isLoading" class="bg-gray-800 p-2 rounded-md m-2 w-[230px] h-[300px] max-sm:w-[150px] md:w-[165px] max-sm:h-[200px] md:h-[250px] max-sm:ml-1 max-sm:mr-1 rounded-md hover:bg-gray-600 cursor-pointer relative overflow-hidden">
            <div class="relative">
                <img class="rounded" :src="image ? image : '/images/album.png'" alt="">
                <i :class="`fas fa-${icon} text-green-600 text-4xl absolute bottom-2 right-3 transform translate-x-2 translate-y-2 opacity-0 transition-opacity duration-300`"></i>
            </div>
            <div class="text-white pt-4 font-semibold text-[14px]">{{ capitalizedTitle }}</div>
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
