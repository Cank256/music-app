<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import HomeCard from '../Components/Cards/HomeCard.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps(['topArtists', 'topAlbums', 'topSongs']);

// Function to get the image URL of the artist from the "image" array.
const getImage = (data) => {
    return data.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
};

</script>

<template>
    <Head title="Welcome" />
    <MainLayout>

        <div class="w-[calc(100%-360px)] h-[91vh] overflow-x-hidden rounded-b-xl fixed mt-11 right-2 items-center justify-between bg-white dark:bg-gray-700">
            <div class="pr-8 pl-8 pt-6">
                <span class="pl-2 text-white text-2xl font-semibold">
                    Recommended Artists
                </span>

                <div class="py-1.5"></div>

                <div class="flex items-center">
                    <div v-for="artist in topArtists">
                        <HomeCard :image="getImage(artist)" :title="artist.name" :listeners="artist.listeners" icon="eye" type="artist" :mbid="artist.mbid" />
                    </div>
                </div>
            </div>

            <div class="pr-8 pl-8 pt-6">
                <span class="pl-2 text-white text-2xl font-semibold">
                    Recommended Albums
                </span>

                <div class="py-1.5"></div>

                <div class="flex items-center">
                    <div v-for="album in topAlbums">
                        <HomeCard :image="getImage(album)" :title="album.name" :subTitle="album.artist.name" icon="eye" type="album"/>
                    </div>
                </div>
            </div>

            <div class="pr-8 pl-8 pt-6">
                <span class="pl-2 text-white text-2xl font-semibold">
                    Recommended Songs
                </span>

                <div class="py-1.5"></div>

                <div class="flex items-center">
                    <div v-for="song in topSongs">
                        <HomeCard :image="getImage(song)" :title="song.name" :subTitle="song.artist.name" icon="eye" type="song" :mbid="song.mbid" />
                    </div>
                </div>
            </div>
        </div>

    </MainLayout>
</template>
