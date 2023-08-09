<script setup>
import { ref, toRefs, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import '../../../../node_modules/@fortawesome/fontawesome-free/css/all.css';
import uniqolor from 'uniqolor';

let randColor = ref('')
randColor.value = uniqolor.random()

const props = defineProps({
    image: String,
    title: String,
    type: String,
    tag: String
})
const { image, title, type, tag } = toRefs(props)

let capitalizedTitle = computed(() => {
    if (!title.value) return '';
    return title.value.replace(/\b\w/g, function (l) { return l.toUpperCase() });
});

</script>

<template>
    <Link :href="type == 'system' ? route(tag) : route('get-tag', { tag: title })">
        <div v-if="randColor.color" :style="`background-color: ${randColor.color};`" class="bg-gray-800 p-6 mt-4 w-[190px] h-[190px] max-sm:w-[150px] md:w-[130px] max-sm:h-[200px] md:h-[160px] max-sm:ml-1 max-sm:mr-1 rounded-md m-2 hover:bg-gray-600 cursor-pointer relative overflow-hidden">
            <div class="text-white font-semibold text-[1.3rem]">{{ capitalizedTitle }}</div>
            <i :class="`fas fa-${image} text-8xl md:text-7xl absolute contrast-[0.8] -right-5 bottom-3 rotate-[30deg] text-white opacity-[0.4]`"></i>
        </div>
    </Link>
</template>
