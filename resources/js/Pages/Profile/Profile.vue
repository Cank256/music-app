<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import ProfileCard from '@/Components/Cards/ProfileCard.vue'
import { Head, usePage } from '@inertiajs/vue3';
import FavoriteAlbums from '@/Components/Cards/FavoriteAlbums.vue';
import FavoriteArtists from '@/Components/Cards/FavoriteArtists.vue';

const user = usePage().props.auth.user;

const props = defineProps(['favoriteAlbums', 'favoriteArtists']);

</script>

<template>
    <Head title="Profile" />
    <MainLayout>
        <div class="max-w-7xl mx-auto lg:px-8 space-y-6 max-lg:mt-[-43px]">
            <div class="w-[80.5vw] h-[91vh] max-sm:w-[97.5vw] md:max-lg:w-[98.8vw] overflow-x-hidden mt-12 ml-[7.5rem] max-sm:ml-[.7rem] md:max-lg:ml-[.7rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-900">
                <div class="pr-8 max-sm:pr-3 flex max-sm:flex-wrap md:max-lg:flex-wrap max-sm:flex-col md:max-lg:flex-col">
                    <div class="mt-2 max-sm:mb-2 flex-1 max-w-[40vh] h-[50vh] max-sm:h-[80vh] max-sm:max-w-[100vw] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <ProfileCard :name="user.name" :email="user.email" :joined="user.created_at" type="Subscriber" class="max-w-xl" />
                    </div>
                    <div class="mt-2 max-sm:mb-2 ml-4 max-sm:ml-0 md:max-lg:ml-[0] flex-1 max-w-[55vh] h-[70vh] max-sm:h-[60vh] max-sm:max-w-[100vw] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <FavoriteAlbums class="max-w-xl" :albums="favoriteAlbums"/>
                    </div>
                    <div class="mt-2 max-sm:mb-2 ml-4 max-sm:ml-0 md:max-lg:ml-0 flex-1 max-w-[55vw] h-[70vh] max-sm:h-[60vh] max-sm:max-w-[100vw] md:max-lg:max-w-[55vh] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <FavoriteArtists class="max-w-xl" :artists="favoriteArtists"/>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
