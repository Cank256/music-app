<script setup>
import GuestLayout from '../Layouts/GuestLayout.vue';
import HomeCard from '../Components/HomeCard.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps(['topArtists', 'topAlbums']);

// Function to get the image URL of the artist from the "image" array.
const getArtistImage = (artist) => {
    return artist.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
};

// Function to get the image URL of the artist from the "image" array.
const getAlbumImage = (album) => {
    return album.image.find((img) => img.size === 'extralarge')?.['#text'] || '';
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
                        <HomeCard :image="getArtistImage(artist)" :title="artist.name" subTitle="Subtitle is here" icon="eye" />
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
                        <HomeCard :image="getAlbumImage(album)" :title="album.name" :subTitle="album.artist.name" icon="eye" />
                    </div>
                </div>
            </div>

            <div class="pr-8 pl-8 pt-6">
                <button type="button" class="pl-2 text-white text-2xl font-semibold hover:underline cursor-pointer">
                    Recommended Songs
                </button>

                <div class="py-1.5"></div>

                <div class="flex items-center">
                    <HomeCard image="https://picsum.photos/id/30/300/300" title="Title is here" subTitle="Subtitle is here" icon="circle-play" />
                    <HomeCard image="https://picsum.photos/id/45/300/300" title="Title is here" subTitle="Subtitle is here" icon="circle-play" />
                    <HomeCard class="md:block hidden" image="https://picsum.photos/id/65/300/300" title="Title is here" subTitle="Subtitle is here" icon="circle-play" />
                    <HomeCard class="lg:block hidden" image="https://picsum.photos/id/67/300/300" title="Title is here" subTitle="Subtitle is here" icon="circle-play" />
                    <HomeCard class="xl:block hidden" image="https://picsum.photos/id/100/300/300" title="Title is here" subTitle="Subtitle is here" icon="circle-play" />
                </div>
            </div>
        </div>

    </GuestLayout>
</template>
