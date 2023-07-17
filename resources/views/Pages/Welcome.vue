<script setup>
import GuestLayout from '../Layouts/GuestLayout.vue';
import HomeCard from '../Components/HomeCard.vue';
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
    <GuestLayout>

        <div class="w-[calc(100%-360px)] h-[91vh] overflow-x-hidden rounded-b-xl fixed mt-11 right-2 items-center justify-between bg-white dark:bg-gray-700">
            <div class="pr-8 pl-8 pt-6">
                <button type="button" class="pl-2 text-white text-2xl font-semibold hover:underline cursor-pointer">
                    Recommended Artists
                </button>

                <div class="py-1.5"></div>

                <div class="flex items-center">
                    <div v-for="artist in topArtists">
                        <HomeCard :image="getImage(artist)" :title="artist.name" subTitle="Subtitle is here" icon="eye" />
                    </div>
                </div>
            </div>

            <div class="pr-8 pl-8 pt-6">
                <button type="button" class="pl-2 text-white text-2xl font-semibold hover:underline cursor-pointer">
                    Recommended Albums
                </button>

                <div class="py-1.5"></div>

                <div class="flex items-center">
                    <div v-for="album in topAlbums">
                        <HomeCard :image="getImage(album)" :title="album.name" :subTitle="album.artist.name" icon="eye" />
                    </div>
                </div>
            </div>

            <div class="pr-8 pl-8 pt-6">
                <button type="button" class="pl-2 text-white text-2xl font-semibold hover:underline cursor-pointer">
                    Recommended Songs
                </button>

                <div class="py-1.5"></div>

                <div class="flex items-center">
                    <div v-for="song in topSongs">
                        <HomeCard :image="getImage(song)" :title="song.name" :subTitle="song.artist.name" icon="eye" />
                    </div>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>
