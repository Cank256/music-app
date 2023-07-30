<script setup>
import { toRefs, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    albums: Object
})

const { albums } = toRefs(props)

const hasAlbums = computed(() => {
    return albums.value && Object.keys(albums.value).length > 0
})

</script>

<template>
    <div class="bg-gray-800 p-2 rounded-md m-2 h-[320px] rounded-md">
        <span class="text-gray-400 font-bold text-xl">Saved Albums</span>

        <div v-if="hasAlbums" class="mt-4">
            <ol>
                <div v-for="album in albums" class="flex">
                    <li class="text-gray-400">
                        <Link :href="route('search-album', {album: album.album_name, artist: album.artist_name})">
                            {{ album.album_name }}
                            ({{ album.artist_name }})
                        </Link>
                    </li>
                </div>
            </ol>
        </div>

        <div v-else class="mt-4">
            <span class="text-gray-400">No Favorite Albums yet</span>
        </div>
    </div>
</template>
