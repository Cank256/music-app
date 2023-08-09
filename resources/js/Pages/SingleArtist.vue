<script setup>
import SongRow from '@/Components/SongRow.vue'
import HomeCard from '@/Components/Cards/HomeCard.vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head, Link} from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps(['artist', 'topTracks', 'topAlbums', 'similarArtists', 'isFavorite']);

const displayCount = ref(5);
let showMore = ref(false);

const albumsDisplayCount = ref(4);
let albumsState = ref(false);

const similarArtistsDisplayCount = ref(4);
let similarArtistsState = ref(false);

// let isHovered = ref(false);

const showMoreTracks = () => {
    displayCount.value += 5;
    showMore = true;
}

const showLessTracks = () => {
    displayCount.value -= 5;
    showMore = false;
}

const showMoreAlbums = () => {
    albumsDisplayCount.value += 6;
    albumsState = ref(true);
}

const showLessAlbums = () => {
    albumsDisplayCount.value -= 6;
    albumsState = ref(false);
}

const showMoreSimilarArtists = () => {
    similarArtistsDisplayCount.value += 6;
    similarArtistsState = ref(true);
}

const showLessSimilarArtists = () => {
    similarArtistsDisplayCount.value -= 6;
    similarArtistsState = ref(false);
}

</script>

<template>
    <Head :title="artist.name" />
    <MainLayout>

        <div class="max-w-7xl mx-auto lg:px-8 space-y-6 max-lg:mt-[-40px]">
            <div class="w-[78.58vw] h-[91vh] max-sm:w-[97.5vw] md:w-[98.8vw] overflow-x-hidden mt-12 max-sm:mt-0 ml-[7.5rem] max-sm:ml-0 md:ml-0 shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-900">
                <div class="pr-8 pl-8 pt-6 max-sm:pr-0 max-sm:pl-0 pt-6 max-sm:pt-1 border-2 border-t-0 border-gray-800 max-sm:border-transparent">
                    <div class="p-8 max-sm:pl-3 max-sm:pr-2 overflow-x-hidden">

                        <div class="py-1.5"></div>
                        <div class="flex items-center w-full relative h-full max-sm:mt-4">
                            <img width="140" :src="artist.image" class="rounded-lg">

                            <div class="w-full ml-5">

                                <div class="text-white absolute w-full cursor-pointer top-0 font-semibold mb-2 text-4xl max-sm:text-2xl text-4xl mt-1 max-sm:mt-3 text-4xl">
                                    {{ artist.name }}
                                </div>

                                <div class="text-gray-300 text-[18px] flex mt-12 mb-2">
                                    Artist
                                </div>

                                <div class="text-gray-300 text-[16px] flex mb-4">
                                    <div class="flex">{{ topAlbums.length }} Albums</div>
                                </div>

                                <div class="flex gap-5 bottom-0 mt-2 mb-1.5">
                                    <Link :href="route(isFavorite ? 'remove-favorite' : 'add-favorite', { type: 'artist', artist: artist.name, mbid: artist.mbid, image: artist.image[0], listeners: artist.listeners })" :method="isFavorite ? 'delete' : 'post'">
                                        <i
                                            :class="{ 'fas': isFavorite, 'fa-regular': !isFavorite }"
                                            class="fa-heart text-[#1BD760] text-3xl"
                                            >
                                        </i>
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="text-2xl mt-8 mb-6 text-gray-400 font-bold">Info</div>
                        </div>

                        <div class="text-gray-300 mt-6 leading-8">
                            {{ artist.summary }}
                        </div>

                        <div class="mt-6"></div>
                        <div>
                            <div class="text-2xl mt-12 mb-6 text-gray-400 font-bold">Popular Songs</div>
                        </div>
                        <div class="flex items-center justify-between px-5 pt-2">
                            <div class="flex items-center justify-between text-gray-400">
                                <div class="mr-8">Rank</div>
                                <div>Title</div>
                            </div>
                            <div class="text-gray-400">Listeners</div>
                            <div><i class="fa fa-clock text-transparent"></i></div>
                        </div>
                        <div class="border-b border-b-[#2A2A2A] mt-2"></div>
                        <div class="mb-4"></div>
                        <ul class="w-full" v-for="track in topTracks.slice(0, displayCount)">
                            <SongRow :track="track" forWho="artist" :mbid="track.mbid"/>
                        </ul>

                        <button v-if="!showMore" @click="showMoreTracks" class="text-gray-300 font-bold mt-4">Show More</button>
                        <button v-if="showMore" @click="showLessTracks" class="text-gray-300 font-bold mt-4">Show Less</button>

                        <div class="mt-6"></div>

                        <div class="pt-6">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-400 text-2xl font-bold">
                                    Popular Albums for {{ similarArtists.name }}
                                </span>

                                <button v-if="!albumsState" @click="showMoreAlbums" class="pr-6 text-white text-l font-semibold">
                                    Show More
                                </button>
                                <button v-if="albumsState" @click="showLessAlbums" class="pr-6 text-white text-l font-semibold">
                                    Show Less
                                </button>
                            </div>
                            <div class="flex flex-wrap items-center md:ml-[-20px]">
                                <div v-for="album in topAlbums.slice(0, albumsDisplayCount)">
                                    <HomeCard :image="album.image" :title="album.name" :subTitle="album.artist" icon="eye" type="album"/>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6"></div>

                        <div class="pt-6">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-400 text-2xl font-bold">
                                    Similar Artists
                                </span>

                                <button v-if="!similarArtistsState" @click="showMoreSimilarArtists" class="pr-6 text-white text-l font-semibold">
                                    Show More
                                </button>
                                <button v-if="similarArtistsState" @click="showLessSimilarArtists" class="pr-6 text-white text-l font-semibold">
                                    Show Less
                                </button>
                            </div>
                            <div class="flex flex-wrap items-center md:ml-[-20px]">
                                <div v-for="similarArtist in similarArtists.slice(0, similarArtistsDisplayCount)">
                                    <HomeCard :image="similarArtist.image" :title="similarArtist.name" icon="eye" type="artist" :mbid="similarArtist.mbid"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
    .circle {
        width: 4px;
        height: 4px;
        background-color: rgb(189, 189, 189);
        border-radius: 100%;
    }
</style>
