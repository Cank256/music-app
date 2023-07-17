<script setup>
import { toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    image: String,
    title: String,
    subTitle: String
})
const { image, title, subTitle } = toRefs(props)
</script>

<template>
    <Link>
        <div class="bg-gray-800 p-4 rounded-md m-2 hover:bg-gray-600 cursor-pointer">
            <img class="rounded-md" :src="image" alt="">
            <div class="text-white pt-4 font-semibold text-[17px]">{{ title }}</div>
            <div class="text-gray-400 pt-1 pb-3 text-[14px]">{{ subTitle }}</div>
        </div>
    </Link>
</template>
