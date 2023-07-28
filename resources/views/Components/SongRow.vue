<script setup>
import { ref, toRefs, onMounted  } from 'vue';

let isHover = ref(false)
let trackDuration = ref([])

const props = defineProps({
    track: Object,
    forWho: String,
    duration: String,
})

const { track, forWho, duration } = toRefs(props)

const formatDuration = (seconds) => {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
}

const getTrackDuration = () => {
    axios.get(`/track-duration?mbid=${duration}`)
            .then(response => {
                // trackDuration.value = response.data;
                console.log(response.data)
            });
}

onMounted(getTrackDuration);

</script>

<template>
    <li class="flex items-center justify-between h-[60px] rounded-md hover:bg-gray-600"
        @mouseenter="isHover = true"
        @mouseleave="isHover = false"
    >
        <div class="flex items-center w-full py-1.5 px-5">
            <div class="text-lg w-[6%] font-semibold text-gray-400">{{ track['@attr'].rank }}</div>
            <div class="text-lg w-[50%] font-semibold text-gray-400">{{ track.name }}</div>
            <div class="text-lg font-semibold text-gray-400">{{ track.listeners }}</div>
        </div>
        <div class="flex items-center">
                <!-- <button type="button" v-if="isHover">
                    <i class="fas fa-heart text-lg text-[#1BD760]"></i>
                </button> -->
                <div v-if="!forWho" class="text-lg mx-8 text-gray-400">
                    {{ formatDuration(track.duration) }}
                </div>

                <div v-if="forWho" class="text-lg mx-8 text-gray-400">
                    {{ trackDuration.duration }}
                </div>
            </div>
    </li>
</template>
