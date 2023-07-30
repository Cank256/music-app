<script setup>
import { ref, toRefs, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    artists: Object
})

const { artists } = toRefs(props)

const artistsDisplayCount = ref(10);

const hasArtists = computed(() => {
    return artists.value && Object.keys(artists.value).length > 0
})

</script>

<template>
    <div class="bg-gray-800 p-2 rounded-md m-2 h-[320px] rounded-md">
        <span class="text-gray-400 font-bold text-xl">Saved Artists</span>

        <div v-if="hasArtists" class="mt-4">
            <ol>
                <div v-for="artist in artists.slice(0, artistsDisplayCount)" class="flex">
                    <li class="text-gray-400 mb-6 hover:text-white">
                        <Link :href="route('search-artist', {artist: artist.artist_name})">
                            {{ artist.artist_name }}
                        </Link>
                    </li>
                </div>
                <Link v-if="artists.length > 10" class="pr-6 text-green-400 text-l font-semibold">See More Artists</Link>
            </ol>
        </div>

        <div v-else class="mt-4">
            <span class="text-gray-400">No Favorite Artists yet</span>
        </div>
    </div>
</template>
