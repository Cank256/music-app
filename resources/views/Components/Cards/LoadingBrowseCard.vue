<script setup>
import { ref, toRefs, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import '../../../../node_modules/@fortawesome/fontawesome-free/css/all.css';
import uniqolor from 'uniqolor';

let randColor = ref('');
let isLoading = ref(true); // Add a loading state and initialize it as true
randColor.value = uniqolor.random();

const props = defineProps({
    image: String,
    title: String,
});

const { image, title } = toRefs(props);

onMounted(() => {
    // Simulate an asynchronous operation
    setTimeout(() => {
        isLoading.value = false; // Set the loading state to false after some time (simulating data loading)
    }, 3000); // You can adjust the time as needed
});
</script>

<template>
    <Link href="#">
        <div v-if="!isLoading && randColor.color" :style="`background-color: ${randColor.color};`" class="bg-gray-800 p-6 mt-4 w-[190px] h-[190px] rounded-md m-2 hover:bg-gray-600 cursor-pointer relative overflow-hidden">
            <div class="text-white font-semibold text-[1.3rem]">{{ title }}</div>
            <i :class="`fas fa-${image} text-8xl absolute contrast-[0.8] -right-5 bottom-3 rotate-[30deg] text-white opacity-[0.4]`"></i>
        </div>
        <div v-else class="bg-gray-800 p-6 mt-4 w-[190px] h-[190px] rounded-md m-2 animate-pulse"></div>
        <!-- Replace the above div with your desired loading animation or text -->
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
