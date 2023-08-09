<script setup>
import { computed, toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    name: String,
    email: String,
    image: String,
    type: String,
    joined: String,
})

const { name, email, image, type, joined } = toRefs(props)

const formatDate = computed(() => {
  const date = new Date(joined.value);

  const day = date.getDate();
  const year = date.getFullYear();

  // getMonth returns a zero-based index, so we use an array to get the month name
  const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "No", "Dec"];
  const month = monthNames[date.getMonth()];

  return `${day}-${month}-${year}`;
});

</script>

<template>
    <div class="bg-gray-800 p-2 rounded-md m-2 h-[320px] max-sm:h-[360px] max-md:h-[360px] rounded-md ">
        <div class="relative">
            <img class="rounded-xl" :src="image ? image : '/assets/images/album.png'" alt="" width="150" height="150">
        </div>
        <div class="text-white pt-6 font-semibold text-[22px]">{{ name }}</div>
        <div class="text-gray-400 pt-1 text-[18px]">{{ email }}</div>
        <div class="text-gray-400 pt-1 text-[18px]">{{ type }}</div>
        <div class="text-gray-400 pt-1 text-[18px]">Joined: {{ formatDate }}</div>
        <Link class="mt-4 inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded" :href="route('profile.edit')" as="button">Edit</Link>
    </div>
</template>
