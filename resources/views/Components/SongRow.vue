<script setup>
import { ref, toRefs } from 'vue';

let isHover = ref(false)
let isTrackTime = ref(null)

// const props = defineProps({
//     track: Object,
//     artist: Object,
//     index: Number,
// })

// const { track, artist, index } = toRefs(props)

</script>

<template>
    <li
        class="flex items-center justify-between rounded-md hover:bg-[#2A2929]"
        @mouseenter="isHover = true"
        @mouseleave="isHover = false"
    >
        <div class="flex items-center w-full py-1.5">

                <span>
                    1
                </span>
                <div
                    class="text-white font-semibold"
                >
                    Sing It
                </div>
                <div class="text-sm font-semibold text-gray-400">Cank256</div>
        </div>
        <div class="flex items-center">
            <button type="button" v-if="isHover">
                <i class="fas fa-heart text-[#1BD760]"></i>
            </button>
            <div
                v-if="isTrackTime"
                class="text-xs mx-5 text-gray-400"
            >
                1:02
            </div>
        </div>
    </li>
</template>
