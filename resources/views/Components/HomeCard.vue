<script setup>
import { toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    image: String,
    title: String,
    subTitle: String,
    icon: String
})
const { image, title, subTitle, icon } = toRefs(props)
</script>

<template>
    <Link href="#">
        <div class="bg-gray-800 p-4 rounded-md m-2 hover:bg-gray-600 cursor-pointer relative">
            <div class="relative">
                <img class="rounded-md" :src="image" alt="">
                <i :class="`fas fa-${icon} text-green-600 text-4xl absolute bottom-2 right-3 transform translate-x-2 translate-y-2 opacity-0 transition-opacity duration-300`"></i>
            </div>
            <div class="text-white pt-4 font-semibold text-[17px]">{{ title }}</div>
            <!-- <div class="text-gray-400 pt-1 pb-3 text-[14px]">{{ subTitle }}</div> -->
        </div>
    </Link>
</template>

<style>
    /* Show the icon on hover */
    .bg-gray-800:hover i {
        opacity: 1;
    }
</style>
