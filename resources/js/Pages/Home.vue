<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import HomeCard from '@/Components/Cards/HomeCard.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps(['topArtists', 'topAlbums']);

const artistsDisplayCount = ref(5);
const albumsDisplayCount = ref(5);
// const songsDisplayCount = ref(5);

let artistsState = ref(false);
let albumsState = ref(false);
// let songsState = ref(false);

// ref for window width
const windowWidth = ref(window.innerWidth);

// Function to get the image URL of the artist from the "image" array.
const getImage = (data) => {
    return data.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
};

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

// Update window width ref on window resize
const updateWindowWidth = () => {
    windowWidth.value = window.innerWidth;
};

// Watch window width and adjust display count
watch(windowWidth, (newWidth) => {
    if (newWidth <= 640) {
        artistsDisplayCount.value = 4;
        albumsDisplayCount.value = 4;
    } else {
        artistsDisplayCount.value = 5;
        albumsDisplayCount.value = 5;
    }
});

onMounted(() => {
    window.addEventListener('resize', updateWindowWidth);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', updateWindowWidth);
});

</script>

<template>
    <Head title="Home" />
    <MainLayout>
        <div class="max-w-7xl mx-auto lg:px-8 space-y-6 max-sm:mt-[-43px]">
                <div class="w-[78.58vw] h-[91vh] max-sm:w-[97.5vw] overflow-x-hidden mt-12 ml-[7.5rem] max-sm:ml-[.3rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-700">
                    <div class="pr-8 pl-8 max-sm:pr-3 max-sm:pl-3 pt-6">
                        <div class="flex justify-between items-center">
                            <span class="pl-2 text-white text-2xl max-sm:text-lg font-semibold">
                                Recommended Albums
                            </span>

                            <button v-if="!albumsState" @click="showMoreAlbums" class="pr-6 text-white text-l max-sm:text-xs font-semibold">
                                Show More
                            </button>
                            <button v-if="albumsState" @click="showLessAlbums" class="pr-6 text-white text-l max-sm:text-xs font-semibold">
                                Show Less
                            </button>
                        </div>

                        <div class="py-1.5"></div>

                        <div class="flex flex-wrap items-center gap-1">
                            <div v-for="album in topAlbums.slice(0, albumsDisplayCount)">
                                <HomeCard :image="getImage(album)" :title="album.name" :subTitle="album.artist.name" icon="eye" type="album"/>
                            </div>
                        </div>
                    </div>

                    <div class="pr-8 pl-8 max-sm:pr-3 max-sm:pl-3 pt-6">
                        <div class="flex justify-between items-center">
                            <span class="pl-2 text-white text-2xl max-sm:text-lg font-semibold">
                                Recommended Artists
                            </span>
                            <button v-if="!artistsState" @click="showMoreArtists" class="pr-6 text-white text-l max-sm:text-xs font-semibold">
                                Show More
                            </button>
                            <button v-if="artistsState" @click="showLessArtists" class="pr-6 text-white text-l max-sm:text-xs font-semibold">
                                Show Less
                            </button>
                        </div>

                        <div class="py-1.5"></div>

                        <div class="flex flex-wrap items-center gap-1">
                            <div v-for="artist in topArtists.slice(0, artistsDisplayCount)">
                                <HomeCard :image="getImage(artist)" :title="artist.name" :listeners="Number(artist.listeners)" icon="eye" type="artist" :mbid="artist.mbid" />
                            </div>
                        </div>
                    </div>

                    <!-- <div class="pr-8 pl-8 max-sm:pr-3 max-sm:pl-3 pt-6">
                        <div class="flex justify-between items-center">
                            <span class="pl-2 text-white text-2xl max-sm:text-lg font-semibold">
                                Recommended Songs
                            </span>

                            <button v-if="!songsState" @click="showMoreSongs" class="pr-6 text-white text-l max-sm:text-xs font-semibold">
                                Show More
                            </button>
                            <button v-if="songsState" @click="showLessSongs" class="pr-6 text-white text-l max-sm:text-xs font-semibold">
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
