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
        <div class="max-w-7xl mx-auto lg:px-8 space-y-6">
            <div class="w-[80.5vw] h-[91vh] overflow-x-hidden mt-12 ml-[7.5rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-900">
                <div class="pr-8 flex">
                    <div class="user-details mt-2 flex-1 max-w-[40vh] h-[50vh] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <ProfileCard :name="user.name" :email="user.email" :joined="user.created_at" type="Subscriber" class="max-w-xl" />
                    </div>
                    <div class="favorite-artists mt-2 ml-4 flex-1 max-w-[55vh] h-[70vh] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <FavoriteAlbums class="max-w-xl" :albums="favoriteAlbums"/>
                    </div>
                    <div class="favorite-album mt-2 ml-4  flex-1 max-w-[55vh] h-[70vh] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <FavoriteArtists class="max-w-xl" :artists="favoriteArtists"/>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
