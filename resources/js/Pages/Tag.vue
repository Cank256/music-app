<script setup>
import HomeCard from '@/Components/Cards/HomeCard.vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';

const props = defineProps(['tag', 'artists', 'albums']);

const displayCount = ref(5);
let showMore = ref(false);

const albumsDisplayCount = ref(4);
let albumsState = ref(false);

const similarArtistsDisplayCount = ref(4);
let similarArtistsState = ref(false);

let capitalizedName = computed(() => {
    if (!props.tag.name) return '';
    return props.tag.name.replace(/\b\w/g, function (l) { return l.toUpperCase() });
});

const getImage = (data) => {
    return data.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
};

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
    <Head :title="capitalizedName" />
    <MainLayout>

        <div class="max-w-7xl mx-auto lg:px-8 space-y-6">
            <div class="w-[78.58vw] h-[91vh] overflow-x-hidden mt-12 ml-[7.5rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-900">
                <div class="pr-8 pl-8 pt-6">
                    <div class="p-8 overflow-x-hidden">

                        <div class="py-1.5"></div>
                        <div class="flex items-center w-full relative h-full">
                            <img width="140" :src="tag.image ? tag.image : '/assets/images/album.png'" class="rounded-lg">

                            <div class="w-full ml-5">

                                <div style="font-size: 33px;"
                                    class="text-white absolute w-full cursor-pointer top-0 font-bosemiboldld mb-2"
                                >
                                    {{ capitalizedName }}
                                </div>

                                <div class="text-gray-300 text-[18px] flex mt-4 mb-2">
                                    Genre
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="text-2xl mt-8 mb-6 text-gray-400 font-bold">Info</div>
                        </div>

                        <div class="text-gray-300 mt-6 leading-8">
                            {{ tag.wiki.summary }}
                        </div>

                        <!-- <div class="mt-6"></div>
                        <div>
                            <div class="text-2xl mt-12 mb-6 text-gray-400 font-bold">Popular Songs</div>
                        </div>
                        <div class="flex items-center justify-between px-5 pt-2">
                            <div class="flex items-center justify-between text-gray-400">
                                <div class="mr-8">Rank</div>
                                <div>Title</div>
                            </div>
                            <div class="text-gray-400">Listeners</div>
                            <div><i class="fa fa-clock text-white"></i></div>
                        </div>
                        <div class="border-b border-b-[#2A2A2A] mt-2"></div>
                        <div class="mb-4"></div>
                        <ul class="w-full" v-for="track in topTracks.slice(0, displayCount)">
                            <SongRow :track="track"/>
                        </ul>

                        <button v-if="!showMore" @click="showMoreTracks" class="text-gray-300 font-bold mt-4">Show More</button>
                        <button v-if="showMore" @click="showLessTracks" class="text-gray-300 font-bold mt-4">Show Less</button>
                        -->
                        <div class="mt-6"></div>

                        <div class="pt-6">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-400 text-2xl font-bold">
                                    Popular Albums Under <span class="text-gray-200">{{ capitalizedName }}</span>
                                </span>

                                <button v-if="!albumsState" @click="showMoreAlbums" class="pr-6 text-white text-l font-semibold">
                                    Show More
                                </button>
                                <button v-if="albumsState" @click="showLessAlbums" class="pr-6 text-white text-l font-semibold">
                                    Show Less
                                </button>
                            </div>
                            <div class="flex flex-wrap items-center">
                                <div v-for="album in albums.slice(0, albumsDisplayCount)">
                                    <HomeCard :image="getImage(album)" :title="album.name" :subTitle="album.artist.name" icon="eye" type="album"/>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6"></div>

                        <div class="pt-6">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-400 text-2xl font-bold">
                                    Popular Artists Under <span class="text-gray-200">{{ capitalizedName }}</span>
                                </span>

                                <button v-if="!similarArtistsState" @click="showMoreSimilarArtists" class="pr-6 text-white text-l font-semibold">
                                    Show More
                                </button>
                                <button v-if="similarArtistsState" @click="showLessSimilarArtists" class="pr-6 text-white text-l font-semibold">
                                    Show Less
                                </button>
                            </div>
                            <div class="flex flex-wrap items-center">
                                <div v-for="artist in artists.slice(0, similarArtistsDisplayCount)">
                                    <HomeCard :image="getImage(artist)" :title="artist.name" :listeners="Number(artist.listeners)" icon="eye" type="artist" :mbid="artist.mbid"/>
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
