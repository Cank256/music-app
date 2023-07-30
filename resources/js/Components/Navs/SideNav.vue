<script setup>
import MenuItem from './MenuItem.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
const artists = computed(() => page.props.favorites.artists)
const albums = computed(() => page.props.favorites.albums)

const artistsDisplayCount = ref(3)
const albumsDisplayCount = ref(3)

</script>

<template>
    <nav class="h-[100%] inline-block align-baselin">
        <div class="h-[220px] pl-7 pt-3 w-[335px] fixed z-50 left-2 top-2 bg-white dark:bg-gray-800 rounded-xl">
            <ul>
                <MenuItem class="mt-[1px]" name="Home" iconString="house" pageUrl="home" />
                <MenuItem class="ml-[1px]" name="Search" iconString="magnifying-glass" pageUrl="search" />
                <MenuItem class="ml-[1px]" name="Library" iconString="book" pageUrl="library" />
                <MenuItem class="ml-[1px]" name="Browse" iconString="dharmachakra" pageUrl="browse" />
            </ul>
        </div>

        <div class="h-[695px] w-[335px] fixed overflow-x-hidden top-[27%] left-2 bg-white dark:bg-gray-800 rounded-xl">

            <div v-if="user" class="p-5 mx-2 mt-5 bg-gray-600 rounded-xl shadow-lg flex items-center space-x-4">
                <div>
                    <div>
                        <div class="text-l text-bolder font-bold text-black dark:text-white">Favorite Artists ({{ artists.length }})</div>
                        <div v-if="artists.length > 0">
                            <div class="text-l text-bolder font-medium text-black dark:text-white mt-2">
                                <ul>
                                    <div v-for="artist in artists.slice(0, artistsDisplayCount)">
                                        <li>
                                            <Link :href="route('search-artist', {artist: artist.artist_name})">{{ artist.artist_name }}</Link>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div v-else class="text-gray-400 text-xs mt-3">No Favorite Artists</div>
                    </div>

                    <div class="mt-4 w-60"><hr></div>

                    <div class="mt-4">
                        <div class="text-l text-bolder font-bold text-black dark:text-white">Favorite Albums  ({{ albums.length }})</div>
                        <div v-if="albums.length > 0">
                            <div class="text-l text-bolder font-medium text-black dark:text-white mt-2">
                                <ul>
                                    <div v-for="album in albums.slice(0, albumsDisplayCount)">
                                        <li>
                                            <Link :href="route('search-album', {album: album.album_name, artist: album.artist_name})">{{ album.album_name }} ({{ album.artist_name }})</Link>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div v-else class="text-gray-400 text-xs mt-3">No Favorite Artists</div>
                    </div>


                    <div class="mt-4 text-gray-300 hover:text-green-500 font-bold">
                        <Link :href="route('library')">Go to Library</Link>
                    </div>
                </div>
            </div>

            <div v-else class="p-5 mx-2 mt-5 bg-gray-600 rounded-xl shadow-lg flex items-center space-x-4">
                <div>
                    <div class="text-l text-bolder font-medium text-black dark:text-white">Create your Library</div>
                    <p class="mt-2 text-xs text-slate-500 text-black dark:text-white">For Albums and Artists</p>
                    <Link :href="route('browse')" as="button" class="mt-5 rounded-full dark:bg-white py-1 px-4 text-sm font-medium">
                        Add Favorites
                    </Link>
                </div>
            </div>

            <div class="mt-6 p-5 mx-2 bg-gray-600 rounded-xl shadow-lg flex items-center space-x-4">
                <div>
                    <div class="text-l text-bolder font-medium text-black dark:text-white">Stars to brighten up your day</div>
                    <p class="mt-2 text-xs text-slate-500 text-black dark:text-white">We got you!</p>
                    <Link :href="route('browse')" as="button" class="mt-5 rounded-full dark:bg-white py-1 px-4 text-sm font-medium">
                        Browse Artists
                    </Link>
                </div>
            </div>

            <div class="mt-6 p-5 mx-2 bg-gray-600 rounded-xl shadow-lg flex items-center space-x-4">
                <div>
                    <div class="text-l text-bolder font-medium text-black dark:text-white">Let's find you great Albums</div>
                    <p class="mt-2 text-xs text-slate-500 text-black dark:text-white">We keep updating them just for you</p>
                    <Link :href="route('browse')" as="button" class="mt-5 rounded-full dark:bg-white py-1 px-4 text-sm font-medium">
                        Browse Albums
                    </Link>
                </div>
            </div>
        </div>


    </nav>
</template>
