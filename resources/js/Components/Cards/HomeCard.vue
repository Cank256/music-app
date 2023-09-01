<script setup>
import { toRefs, computed } from 'vue';
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

let capitalizedTitle = computed(() => {
    if (!title.value) return '';
    return title.value.replace(/\b\w/g, function (l) { return l.toUpperCase() });
});

</script>

<template>
    <Link :href="route(`get-${type}`, type === 'album' ? { artist: subTitle, album: title } : type === 'artist' ? mbid ? { use: 'mbid', mbid } : { use: 'name', artist: title } : { mbid })">
        <div class="bg-gray-800 p-2 rounded-md m-2 w-[220px] h-[320px] max-sm:w-[150px] md:max-lg:w-[150px] max-sm:h-[200px] md:max-lg:h-[230px] max-sm:ml-1 max-sm:mr-1 rounded-md hover:bg-gray-600 cursor-pointer overflow-hidden">
            <div class="">
                <img class="rounded" :src="image ? image : '/assets/images/album.png'" alt="">
                <i :class="`fas fa-${icon} text-green-600 text-4xl relative bottom-[3rem] left-[10rem] transform translate-x-2 translate-y-2 opacity-0 transition-opacity duration-300`"></i>
            </div>
            <div class="text-white mt-[-20px] font-semibold text-[15px] max-sm:text-[13px] max-sm:mt-[-30px]">{{ capitalizedTitle}}</div>
            <div v-if="!listeners" class="text-gray-400 pt-1 pb-3 text-[14px] max-sm:text-[12px]">{{ subTitle }}</div>
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
