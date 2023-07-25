<script setup>
import { ref } from 'vue';
import MainLayout from '../Layouts/MainLayout.vue';
import LoadingSearchCard from '../Components/Cards/LoadingSearchCard.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['action']);

let searchQuery = ref(''); // Initialize search query
let loading = ref(false); // Initialize loading state
let results = ref([]);

const artistsDisplayCount = ref(4);
let artistsState = true;
const albumsDisplayCount = ref(4);
let albumsState = true;

const showMoreArtists = () => {
    artistsDisplayCount.value += 6;
    artistsState = true;
}

const showLessArtists = () => {
    artistsDisplayCount.value -= 6;
    artistsState = false;
}

const showMoreAlbums = () => {
    albumsDisplayCount.value += 6;
    albumsState = ref(true);
}

const showLessAlbums = () => {
    albumsDisplayCount.value -= 6;
    albumsState = ref(false);
}

const handleInput = () => {
    if (searchQuery.value.trim() !== '') {
        axios.get(`/searching?searchQuery=${searchQuery.value}`)
            .then(response => {
                console.log(response.data);
                results.value = response.data; // Assuming the data you want is in response.data
                loading.value = false; // Stop the loading animation once results have been obtained
            });
        loading.value = true;
    } else {
        loading.value = false;
    }
}

const getImage = (data) => {
    return data.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
};

</script>

<template>
    <Head title="Search" />
    <MainLayout>

        <div class="max-w-7xl mx-auto lg:px-8 space-y-6">
            <div class="w-[78.58vw] h-[91vh] overflow-x-hidden mt-12 ml-[7.5rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-800">
                <div class="search-tab mt-12 justify-center">
                    <div class="search-input flex items-center border rounded-full px-6 focus-within:ring focus-within:ring-gray-400">
                        <input class="border-0 bg-transparent text-gray-400 rounded-full text-lg focus:outline-none focus:ring-0" type="text" v-model="searchQuery" @input="handleInput" placeholder="Search for Artists, Albums ..." style="width: 70vh; height: 7vh;"/>
                        <button @click="search" class="flex-1 bg-transparent border-0 cursor-pointer">
                            <i class="fas fa-search text-xl text-gray-600"></i>
                        </button>
                    </div>
                </div>
                <div class="scrollable-content pr-8 pl-8 pt-12 mt-[100px]">
                    <div v-if="results.artists">
                        <div class="flex justify-between items-center mb-6">

                            <span class="text-gray-400 text-2xl font-bold">Artists</span>

                            <div v-if="!loading">
                                <button v-if="!artistsState" @click="showMoreArtists" class="pr-6 text-white text-l font-semibold">
                                    Show More
                                </button>
                                <button v-if="artistsState" @click="showLessArtists" class="pr-6 text-white text-l font-semibold">
                                    Show Less
                                </button>
                            </div>
                        </div>

                        <div class="py-1.5"></div>

                        <div class="flex flex-wrap items-center gap-1">
                            <div v-for="artist in results.artists.slice(0, artistsDisplayCount)">
                                <LoadingSearchCard :image="getImage(artist)" :title="artist.name" :listeners="Number(artist.listeners)" icon="eye" type="artist" :mbid="artist.mbid" :isLoading="loading"/>
                            </div>
                        </div>
                    </div>

                    <div v-if="results.albums">
                        <div class="py-1.5 mt-6 mb-6"></div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-gray-400 text-2xl font-bold">Albums</span>

                            <div v-if="!loading">
                                <button v-if="!albumsState" @click="showMoreAlbums" class="pr-6 text-white text-l font-semibold">
                                    Show More
                                </button>
                                <button v-if="albumsState" @click="showLessAlbums" class="pr-6 text-white text-l font-semibold">
                                    Show Less
                                </button>
                            </div>
                        </div>

                        <div class="py-1.5"></div>

                        <div class="flex flex-wrap items-center gap-1">
                            <div v-for="album in results.albums.slice(0, albumsDisplayCount)">
                                <LoadingSearchCard :image="getImage(album)" :title="album.name"  :subTitle="album.artist.name" icon="eye" type="album" :isLoading="loading"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style>
    /* Optional: Add some styling for the search tab */
    .search-tab {
        display: flex;
        align-items: center;
        z-index: 1000;
    }
    /* .search-tab {
        position: fixed;
        top: 50px;
        z-index: 1000;
        align-items: center;
    } */

    .scrollable-content {
        margin-top: 100px; /* Adjust as needed - this needs to be at least the height of .search-tab */
        overflow-y: scroll; /* Enable vertical scrolling */
        height: calc(100vh - 100px); /* Adjust as needed - this needs to be the viewport height minus .search-tab's height */
    }
</style>
