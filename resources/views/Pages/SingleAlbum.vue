<script setup>
import SongRow from '../Components/SongRow.vue'
import HomeCard from '../Components/Cards/HomeCard.vue'
import MainLayout from '../Layouts/MainLayout.vue'
import { ref, defineProps } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps(['album', 'similarAlbums', 'releaseDate', 'isFavorite']);

const displayCount = ref(5);
let showMore = ref(false);

const similarAlbumsDisplayCount = ref(4);
let similarAlbumsState = false;

// let isHovered = ref(false);

const getImage = (data) => {
    return data.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
};

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

        <div class="max-w-7xl mx-auto lg:px-8 space-y-6">
            <div class="w-[78.58vw] h-[91vh] overflow-x-hidden mt-12 ml-[7.5rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-900">
                <div class="pr-8 pl-8 pt-6">
                    <div class="p-8 overflow-x-hidden">

                        <div class="py-1.5"></div>
                        <div class="flex items-center w-full relative h-full">
                            <img width="140" :src="getImage(album)" class="rounded-lg">

                            <div class="w-full ml-5">

                                <div style="font-size: 33px;"
                                    class="text-white absolute w-full cursor-pointer top-0 font-bosemiboldld mb-2"
                                >
                                    {{ album.name }}
                                </div>

                                <div class="text-gray-300 text-[18px] flex mt-12 mb-2">
                                    <!-- <Link :href="route('search-artist', {mbid: artist.mbid})">{{ album.artist  }} </Link> -->
                                    {{ album.artist  }}
                                </div>

                                <div class="text-gray-300 text-[16px] flex mb-4">
                                    <div class="flex">Album</div>
                                    <div class="ml-2 flex">
                                        <div class="circle mt-2 mr-2" />
                                        <span v-if="album.tracks" class="-ml-0.5">{{ album.tracks.track.length }} songs</span>
                                        <span v-else class="-ml-0.5">0 songs</span>
                                    </div>
                                    <div class="ml-2 flex">
                                        <div class="circle mt-2 mr-2" />
                                        <span>Released on</span>
                                        <span class="ml-1 font-bold">{{ releaseDate.original['second_metadata_description'] }}</span>
                                    </div>
                                </div>

                                <div class="flex gap-5 bottom-0 mt-2 mb-1.5">
                                    <Link :href="route('add-favorite', {type: 'album', artist: album.artist, album: album.name, image: getImage(album), listeners: album.listeners })">
                                        <i
                                            :class="{ 'fas': isFavorite, 'fa-regular': !isFavorite }"
                                            class="fa-heart text-[#1BD760] text-3xl"
                                            >
                                        </i>
                                    </Link>
                                    <!-- <Link v-else :href="route('add-favorite', {type: 'album', identifier: 'name', content: album.name+'_'+album.artist})">
                                        <i
                                            :class="{ 'fas': isHovered, 'fa-regular': !isHovered }"
                                            class="fa-heart text-[#1BD760] text-3xl"
                                            @mouseenter="isHovered = false"
                                            @mouseleave="isHovered = true"
                                            >
                                        </i>
                                    </Link> -->
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="text-2xl mt-8 mb-6 text-gray-400 font-bold">Info</div>
                        </div>

                        <div v-if="album.wiki" class="text-gray-300 mt-6 leading-8">
                            {{ album.wiki.summary }}
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
                            <ul class="w-full" v-for="track in album.tracks.track.slice(0, displayCount)">
                                <SongRow :track="track"/>
                            </ul>

                            <button v-if="!showMore" @click="showMoreTracks(album.tracks.track.length)" class="text-gray-300 font-bold mt-4">Show More</button>
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
                                    <HomeCard :image="getImage(similarAlbum)" :title="similarAlbum.name" :subTitle="similarAlbum.artist.name" icon="eye" type="album"/>
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
