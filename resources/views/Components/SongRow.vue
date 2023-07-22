<script setup>
import { ref, toRefs } from 'vue';

let isHover = ref(false)
let isTrackTime = ref(null)

const props = defineProps({
    track: Object,
})

const { track } = toRefs(props)

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
                <button type="button" v-if="isHover">
                    <i class="fas fa-heart text-lg text-[#1BD760]"></i>
                </button>
                <div class="text-lg mx-8 text-gray-400">
                    1:02
                </div>
            </div>
    </li>
</template>
