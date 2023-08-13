<script setup>
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import LoadingSearchCard from '@/Components/Cards/LoadingSearchCard.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['action']);

let searchQuery = ref(''); // Initialize search query
let loading = ref(false); // Initialize loading state
let typing = ref(false);
let results = ref([]);

const artistsDisplayCount = ref(4);
let artistsState = false;
const albumsDisplayCount = ref(4);
let albumsState = false;

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
                results.value = response.data; // Assuming the data you want is in response.data
                loading.value = false; // Stop the loading animation once results have been obtained
            });
        loading.value = true;
        typing.value = true;
    } else {
        loading.value = false;
        typing.value = false;
    }
}

const getImage = (data) => {
    return data.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
};

</script>

<template>
    <Head title="Search" />
    <MainLayout>

        <div class="max-w-7xl mx-auto lg:px-8 space-y-6 max-lg:mt-[-43px]">
            <div class="w-[78.58vw] h-[91vh] max-sm:w-[97.5vw] md:max-lg:w-[98.5vw] md:max-lg:h-[94vh] overflow-x-hidden mt-12 ml-[7.5rem] max-lg:ml-[.3rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-800">
                <div class="search-tab mt-12 justify-center">
                    <div class="search-input flex items-center border rounded-full px-6 focus-within:ring focus-within:ring-gray-400">
                        <input class="search-input-field border-0 bg-transparent text-gray-400 rounded-full text-lg focus:outline-none focus:ring-0" type="text" v-model="searchQuery" @input="handleInput" placeholder="Search for Artists, Albums ..."/>
                        <button @click="search" class="flex-1 bg-transparent border-0 cursor-pointer">
                            <i class="fas fa-search text-xl text-gray-600"></i>
                        </button>
                    </div>
                </div>
                <div v-if="!typing" class="pr-8 pl-8 pt-12 mt-[100px] opacity-[.1]">
                    <center>
                        <i class="fa fa-search font-bold text-gray-700 text-9xl max-sm:text-7xl"></i>
                    </center>
                    <center>
                        <span class="font-bold text-gray-700 text-9xl max-sm:text-7xl">Search</span>
                    </center>
                </div>
                <div v-if="typing" class="scrollable-content pr-8 pl-8 pt-12 max-sm:pr-3 max-sm:pl-3 max-sm:mt-[10px] max-sm:pt-[2rem]">
                    <div v-if="results.artists">
                        <div class="flex justify-between items-center mb-6 max-sm:mb-0">

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
                        <div class="py-1.5 mt-6 mb-6 md:max-lg:mt-1"></div>

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

    .search-input-field {
        width: 70vh;
        height: 7vh;
    }

    .scrollable-content {
        margin-top: 100px; /* Adjust as needed - this needs to be at least the height of .search-tab */
        overflow-y: scroll; /* Enable vertical scrolling */
        height: calc(100vh - 100px); /* Adjust as needed - this needs to be the viewport height minus .search-tab's height */
    }

    @media not all and (min-width: 640px) {
        .search-input-field {
            width: 35vh;
            height: 7vh;
        }
    }

    @media (min-width: 768px) {
        .search-input-field {
            width: 50vh;
            height: 7vh;
        }
    }
</style>
