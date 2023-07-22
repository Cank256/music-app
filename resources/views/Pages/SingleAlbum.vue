<script setup>
import SongRow from '../Components/SongRow.vue'
import HomeCard from '../Components/Cards/HomeCard.vue'
import MainLayout from '../Layouts/MainLayout.vue'
import { defineProps } from 'vue';

const props = defineProps(['album']);

const getImage = (data) => {
    return data.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
};

</script>

<template>
    <MainLayout>
        <div class="w-[calc(100%-360px)] h-[91vh] overflow-x-hidden rounded-b-xl fixed mt-11 right-2 items-center justify-between bg-white dark:bg-gray-900">
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
                                {{ album.artist }}
                            </div>

                            <div class="text-gray-300 text-[16px] flex mb-4">
                                <div class="flex">Album</div>
                                <div class="ml-2 flex">
                                    <div class="circle mt-2 mr-2" />
                                    <span class="-ml-0.5">{{ album.tracks.track.length }} songs</span>
                                </div>
                            </div>

                            <div class="flex gap-5 bottom-0 mt-2 mb-1.5">
                                <button type="button">
                                    <i class="fas fa-heart text-[#1BD760] text-3xl"></i>
                                </button>
                                <button type="button">
                                    <i class="fas fa-ellipsis text-[#1BD760] text-3xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-gray-300 mt-6 leading-8">
                        {{ album.wiki.summary }}
                    </div>

                    <div class="mt-6"></div>
                    <div>
                        <div class="text-2xl mt-8 mb-6 text-gray-400 font-bold">Songs</div>
                    </div>
                    <div class="flex items-center justify-between px-5 pt-2">
                        <div class="flex items-center justify-between text-gray-400">
                            <div class="mr-8">Rank</div>
                            <div>Title</div>
                        </div>
                        <div><i class="fa fa-clock text-white"></i></div>
                    </div>
                    <div class="border-b border-b-[#2A2A2A] mt-2"></div>
                    <div class="mb-4"></div>
                    <ul class="w-full" v-for="track in album.tracks.track">
                        <SongRow :track="track"/>
                    </ul>

                    <!-- <div class="mt-6"></div>
                    <div>
                        <div class="text-2xl mt-12 mb-6 text-gray-400 font-bold">Popular Albums</div>
                    </div>
                    <div class="pr-8 pl-8 pt-6">
                        <div class="flex items-center">
                            <div v-for="album in topAlbums">
                                <HomeCard :image="getImage(album)" :title="album.name" :subTitle="album.artist.name" icon="eye" type="album"/>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="flex items-center">
                        <div v-for="album in topAlbums">
                            <HomeCard :image="getImage(album)" :title="album.name" :subTitle="album.artist.name" icon="eye" type="album"/>
                        </div>
                    </div> -->
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
