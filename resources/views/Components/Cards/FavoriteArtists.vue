<script setup>
import { toRefs, computed } from 'vue';

const props = defineProps({
    artists: Object
})

const { artists } = toRefs(props)

const hasArtists = computed(() => {
    return artists.value && Object.keys(artists.value).length > 0
})

</script>

<template>
    <div class="bg-gray-800 p-2 rounded-md m-2 h-[320px] rounded-md">
        <span class="text-gray-400 font-bold text-xl">Saved Artists</span>

        <div v-if="hasArtists" class="mt-4">
            <!-- Display album data here -->
        </div>

        <div v-else class="mt-4">
            <span class="text-gray-400">No Favorite Artists yet</span>
        </div>
    </div>
</template>
