<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import HomeCard from '@/Components/Cards/HomeCard.vue';
import { Head } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';

const props = defineProps(['favoriteArtists', 'favoriteAlbums']);

const artistsDisplayCount = ref(5);
const albumsDisplayCount = ref(5);
// const songsDisplayCount = ref(5);

let artistsState = ref(false);
let albumsState = ref(false);
// let songsState = ref(false);

// Functions to increase the display counts
const showMoreArtists = () => {
    artistsDisplayCount.value += 5;
    artistsState = ref(true);
}
const showMoreAlbums = () => {
    albumsDisplayCount.value += 5;
    albumsState = ref(true);
}
// const showMoreSongs = () => {
//     songsDisplayCount.value += 5;
//     songsState = ref(true);
// }

// Functions to reduce the display counts
const showLessArtists = () => {
    artistsDisplayCount.value -= 5;
    artistsState = ref(false);
}

const showLessAlbums = () => {
    albumsDisplayCount.value -= 5;
    albumsState = ref(false);
}

</script>

<template>
    <Head title="Library" />
    <MainLayout>
        <div class="max-w-7xl mx-auto lg:px-8 space-y-6">
                <div class="w-[78.58vw] h-[91vh] overflow-x-hidden mt-12 ml-[7.5rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-700">
                    <div class="pr-8 pl-8 pt-12">
                        <div class="flex justify-between items-center">
                            <span class="pl-2 text-white text-3xl font-semibold">
                                Favorite Albums ({{ favoriteAlbums.length }})
                            </span>

                            <div v-if="favoriteAlbums.length > 5">
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
                            <div v-for="album in favoriteAlbums.slice(0, albumsDisplayCount)">
                                <HomeCard :image="album.image" :title="album.album_name" :subTitle="album.artist_name" icon="eye" type="album"/>
                            </div>
                        </div>
                    </div>

                    <div class="pr-8 pl-8 pt-12">
                        <div class="flex justify-between items-center">
                            <span class="pl-2 text-white text-3xl font-semibold">
                                Favorite Artists ({{ favoriteArtists.length }})
                            </span>
                            <div v-if="favoriteArtists.length > 5">
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
                            <div v-for="artist in favoriteArtists.slice(0, artistsDisplayCount)">
                                <HomeCard :image="artist.image" :title="artist.artist_name" :listeners="Number(artist.listeners)" icon="eye" type="artist" :mbid="artist.mbid" />
                            </div>
                        </div>
                    </div>

                    <!-- <div class="pr-8 pl-8 pt-6">
                        <div class="flex justify-between items-center">
                            <span class="pl-2 text-white text-2xl font-semibold">
                                Recommended Songs
                            </span>

                            <button v-if="!songsState" @click="showMoreSongs" class="pr-6 text-white text-l font-semibold">
                                Show More
                            </button>
                            <button v-if="songsState" @click="showLessSongs" class="pr-6 text-white text-l font-semibold">
                                Show Less
                            </button>
                        </div>

                        <div class="py-1.5"></div>

                        <div class="flex flex-wrap items-center gap-1">
                            <div v-for="song in topSongs.slice(0, songsDisplayCount)">
                                <HomeCard :image="getImage(song)" :title="song.name" :subTitle="song.artist.name" icon="eye" type="song" :mbid="song.mbid" />
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

    </MainLayout>
</template>
