<script setup>
import SongRow from '@/Components/SongRow.vue'
import HomeCard from '@/Components/Cards/HomeCard.vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps(['album', 'similarAlbums', 'releaseDate', 'isFavorite']);

const displayCount = ref(5);
let showMore = ref(false);

const similarAlbumsDisplayCount = ref(4);
let similarAlbumsState = false;

// let isHovered = ref(false);

const showMoreTracks = (number) => {
    displayCount.value = number;
    showMore = true;
}

const showLessTracks = () => {
    displayCount.value = 5;
    showMore = false;
}

const showMoreSimilarAlbums = () => {
    similarAlbumsDisplayCount.value += 6;
    similarAlbumsState = ref(true);
}

const showLessSimilarAlbums = () => {
    similarAlbumsDisplayCount.value -= 6;
    similarAlbumsState = ref(false);
}

</script>

<template>
    <Head :title="album.name" />
    <MainLayout>

        <div class="max-w-7xl mx-auto lg:px-8 space-y-6 max-sm:mt-[-40px]">
            <div class="w-[78.58vw] h-[91vh] max-sm:w-[97.5vw] overflow-x-hidden mt-12 max-sm:mt-0 ml-[7.5rem] max-sm:ml-0 shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-900">
                <div class="pr-8 pl-8 max-sm:pr-0 max-sm:pl-0 pt-6 max-sm:pt-1 border-2 border-t-0 border-gray-800 max-sm:border-transparent">
                    <div class="p-8 max-sm:pl-3 max-sm:pr-2 overflow-x-hidden">

                        <div class="py-1.5"></div>
                        <div class="flex items-center w-full max-sm:max-w-[40vw] max-sm:flex-row max-sm:mt-6 relative h-full">
                            <img width="140" :src="album.image" class="rounded-lg flex-1">

                            <div class="w-full ml-5 flex-2 max-sm:ml-2 flex-col max-sm:hidden">

                                <div class="text-white absolute w-full cursor-pointer top-0 font-semibold mt-2 mb-2 max-sm:ml-3 text-4xl max-sm:text-lg">
                                    {{ album.name }}
                                </div>

                                <Link :href="route('search-artist', { use: 'name', artist: album.artist })" class="text-gray-300 text-[18px] max-sm:text-[16px] flex mt-12 mb-2 max-sm:mt-[90px] max-sm:ml-3">
                                    {{ album.artist  }}
                                </Link>

                                <div class="text-gray-300 text-[16px] max-sm:text-[14px] flex max-sm:flex-col mb-4 max-sm:hidden">
                                    <div class="flex max-sm:flex max-sm:ml-3">
                                        <div class="flex">Album</div>
                                        <div class="ml-2 flex">
                                            <div class="circle mt-3 mr-2" />
                                            <span v-if="album.tracks" class="-ml-0.5">{{ album.tracks.length }} Songs</span>
                                            <span v-else class="-ml-0.5">0 songs</span>
                                        </div>
                                    </div>
                                    <div class="ml-2 flex max-sm:ml-3">
                                        <div class="circle mt-3 mr-2 max-sm:hidden" />
                                        <span>Released on</span>
                                        <span class="ml-1 font-bold">{{ releaseDate.original['release_date'] }}</span>
                                    </div>
                                </div>

                                <div class="flex gap-5 bottom-0 mt-2 mb-1.5 max-sm:ml-3">
                                    <Link :href="route(isFavorite ? 'remove-favorite' : 'add-favorite', { type: 'album', artist: album.artist, album: album.name, image: album.image[0], listeners: album.listeners })" method="post">
                                        <i
                                            :class="{ 'fas': isFavorite, 'fa-regular': !isFavorite }"
                                            class="fa-heart text-[#1BD760] text-3xl"
                                            >
                                        </i>
                                    </Link>
                                </div>
                            </div>

                            <div class="w-full ml-5 md:hidden">

                                <div class="text-white absolute w-full h-full cursor-pointer font-semibold text-[18px] mb-8 mt-[-70px]">
                                    {{ album.name }}
                                </div>

                                <Link :href="route('search-artist', { use: 'name', artist: album.artist })" class="text-gray-300 absolute w-full text-[16px] mt-[5px] mb-">
                                    {{ album.artist }}
                                </Link>

                                <div class="absolute w-full bottom-0">
                                    <Link :href="route(isFavorite ? 'remove-favorite' : 'add-favorite', { type: 'album', artist: album.artist, album: album.name, image: album.image[0], listeners: album.listeners })" method="post">
                                        <i
                                            :class="{ 'fas': isFavorite, 'fa-regular': !isFavorite }"
                                            class="fa-heart text-[#1BD760] text-3xl"
                                            >
                                        </i>
                                    </Link>
                                </div>
                            </div>

                        </div>

                        <div class="text-gray-300 text-[14px] mt-4 flex flex-wrap flex-row md:hidden">
                            <div class="flex">
                                <span>Album</span>
                                <div class="flex ml-2">
                                    <div class="circle mt-2 mr-2" />
                                    <span v-if="album.tracks" class="-ml-0.5">{{ album.tracks.length }} Songs</span>
                                    <span v-else class="-ml-0.5">0 songs</span>
                                </div>
                            </div>
                            <div class="ml-2 flex max-sm:ml-3">
                                <div class="circle mt-2 mr-2" />
                                <span>Released</span>
                                <span class="ml-1 font-bold">{{ releaseDate.original['release_date'] }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="text-2xl mt-8 max-sm:mt-4 mb-6 max-sm:mb-3 text-gray-400 font-bold">Info</div>
                        </div>

                        <div v-if="album.summary" class="text-gray-300 mt-6 max-sm:mt-3 leading-8">
                            {{ album.summary }}
                        </div>

                        <div class="mt-6"></div>
                        <div>
                            <div class="text-2xl mt-8 mb-6 text-gray-400 font-bold">Songs</div>
                        </div>
                        <div v-if="album.tracks">
                            <div class="flex items-center justify-between px-5 pt-2">
                                <div class="flex items-center justify-between text-gray-400">
                                    <div class="mr-8">Rank</div>
                                    <div>Title</div>
                                </div>
                                <div><i class="fa fa-clock text-white"></i></div>
                            </div>
                            <div class="border-b border-b-[#2A2A2A] mt-2"></div>
                            <div class="mb-4"></div>
                            <ul class="w-full" v-for="track in album.tracks.slice(0, displayCount)">
                                <SongRow :track="track"/>
                            </ul>

                            <button v-if="!showMore" @click="showMoreTracks(album.tracks.length)" class="text-gray-300 font-bold mt-4">Show More</button>
                            <button v-if="showMore" @click="showLessTracks" class="text-gray-300 font-bold mt-4">Show Less</button>
                        </div>

                        <div v-else class="text-gray-400">
                            No songs
                        </div>

                        <div class="mt-6"></div>

                        <div class="pt-6">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-400 text-2xl font-bold">
                                    Similar Albums
                                </span>

                                <button v-if="!similarAlbumsState" @click="showMoreSimilarAlbums" class="pr-6 text-white text-l font-semibold">
                                    Show More
                                </button>
                                <button v-if="similarAlbumsState" @click="showLessSimilarAlbums" class="pr-6 text-white text-l font-semibold">
                                    Show Less
                                </button>
                            </div>
                            <div class="flex flex-wrap items-center">
                                <div v-for="similarAlbum in similarAlbums.slice(0, similarAlbumsDisplayCount)">
                                    <HomeCard :image="similarAlbum.image" :title="similarAlbum.name" :subTitle="similarAlbum.artist" icon="eye" type="album"/>
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
