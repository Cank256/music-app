<script setup>
import MenuItem from './MenuItem.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <nav class="h-[100%] inline-block align-baselin">
        <div class="h-[220px] pl-7 pt-3 w-[335px] fixed z-50 left-2 top-2 bg-white dark:bg-gray-800 rounded-xl">
            <ul>
                <MenuItem class="mt-[1px]" name="Home" iconString="house" pageUrl="home" />
                <MenuItem class="ml-[1px]" name="Search" iconString="magnifying-glass" pageUrl="search" />
                <MenuItem class="ml-[1px]" name="Library" iconString="book" pageUrl="browse" />
                <MenuItem class="ml-[1px]" name="Browse" iconString="dharmachakra" pageUrl="browse" />
            </ul>
        </div>

        <div class="h-[695px] w-[335px] fixed overflow-x-hidden top-[27%] left-2 bg-white dark:bg-gray-800 rounded-xl">

            <div class="p-5 mx-2 mt-5 bg-gray-600 rounded-xl shadow-lg flex items-center space-x-4">
                <div>
                    <div class="text-l text-bolder font-medium text-black dark:text-white">Create your first playlist</div>
                    <p class="mt-2 text-xs text-slate-500 text-black dark:text-white">Let's guide you through</p>
                    <Link :href="route('browse')" as="button" class="mt-5 rounded-full dark:bg-white py-1 px-4 text-sm font-medium">
                        Create Library
                    </Link>
                </div>
            </div>

            <div class="mt-6 p-5 mx-2 bg-gray-600 rounded-xl shadow-lg flex items-center space-x-4">
                <div>
                    <div class="text-l text-bolder font-medium text-black dark:text-white">Stars to brighten up your day</div>
                    <p class="mt-2 text-xs text-slate-500 text-black dark:text-white">We got you!</p>
                    <Link :href="route('browse')" as="button" class="mt-5 rounded-full dark:bg-white py-1 px-4 text-sm font-medium">
                        Browse Artists
                    </Link>
                </div>
            </div>

            <div class="mt-6 p-5 mx-2 bg-gray-600 rounded-xl shadow-lg flex items-center space-x-4">
                <div>
                    <div class="text-l text-bolder font-medium text-black dark:text-white">Let's find you great Albums</div>
                    <p class="mt-2 text-xs text-slate-500 text-black dark:text-white">We keep updating them just for you</p>
                    <Link :href="route('browse')" class="mt-5 rounded-full dark:bg-white py-1 px-4 text-sm font-medium">
                        Browse Albums
                    </Link>
                </div>
            </div>
        </div>


    </nav>
</template>
