<script setup>
import { ref, toRefs, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    albums: Object
})

const { albums } = toRefs(props)

const albumsDisplayCount = ref(10);

const hasAlbums = computed(() => {
    return albums.value && Object.keys(albums.value).length > 0
})

</script>

<template>
    <div class="bg-gray-800 p-2 rounded-md m-2 h-[320px] rounded-md">
        <span class="text-gray-400 font-bold text-xl">Saved Albums ({{ albums.length }})</span>

        <div v-if="hasAlbums" class="mt-4">
            <ol>
                <div v-for="album in albums.slice(0, albumsDisplayCount)">
                    <li class="text-gray-400 mb-6 hover:text-white">
                        <Link :href="route('search-album', {album: album.album_name, artist: album.artist_name})">
                            {{ album.album_name }}
                            ({{ album.artist_name }})
                        </Link>
                    </li>
                </div>
                <Link v-if="albums.length > 10" class="pr-6 text-green-400 text-l font-semibold">See More Albums</Link>
            </ol>
        </div>

        <div v-else class="mt-4">
            <span class="text-gray-400">No Favorite Albums yet</span>
        </div>
    </div>
</template>
