<script setup>
import { ref, toRefs, watchEffect } from 'vue';
import { Link } from '@inertiajs/vue3';
import '../../../node_modules/@fortawesome/fontawesome-free/css/all.css';

const props = defineProps({
    iconString: String,
    pageUrl: String,
    name: String
})
const { iconString, pageUrl, name } = toRefs(props)

let icon = ref(null)
let textIsHover = ref(false)

watchEffect(() => {
    if (route.path == pageUrl.value) {
        icon.value = iconString.value + '-active'
        textIsHover.value = true
    } else {
        icon.value = iconString.value + '-inactive'
        textIsHover.value = false
    }
})

const isHover = () => {
    if (icon.value === iconString.value + '-active') return

    if (icon.value === iconString.value + '-inactive') {
        icon.value = iconString.value + '-inactive-hover'
        textIsHover.value = true
    } else if (icon.value === iconString.value + '-inactive-hover') {
        icon.value = iconString.value + '-inactive'
        textIsHover.value = false
    }
}
</script>

<template>
    <Link :href="route(`${pageUrl}`)">
        <li
            class="flex items-center justify-start cursor-pointer"
            @mouseenter="isHover()"
            @mouseleave="isHover()"
        >
            <i :class="`fas fa-${iconString} text-black dark:text-white text-xl`"></i>
            <div
                :class="textIsHover ? 'text-white ' : 'text-gray-400'"
                class="font-semibold text-lg ml-4 mt-0.5"
            >
                <span :class="route.path == pageUrl ? 'text-white' : ''">{{ name }}</span>
            </div>
        </li>
    </Link>
</template>
