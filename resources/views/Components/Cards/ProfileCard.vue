<script setup>
import { toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    name: String,
    email: String,
    image: String,
    type: String,
})

const { name, email, image, type } = toRefs(props)


</script>

<template>
    <div class="bg-gray-800 p-2 rounded-md m-2 h-[320px] rounded-md">
        <div class="relative">
            <img class="rounded-xl" :src="image ? image : '/assets/images/album.png'" alt="" width="150" height="150">
        </div>
        <div class="text-white pt-6 font-semibold text-[22px]">{{ name }}</div>
        <div class="text-gray-400 pt-1 text-[18px]">{{ email }}</div>
        <div class="text-gray-400 pt-1 text-[18px]">{{ type }}</div>
        <div class="text-gray-400 pt-1 text-[18px]">Joined: {{ joined }}</div>
        <Link class="mt-4 inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded" :href="route('profile.edit')" as="button">Edit</Link>
    </div>
</template>
