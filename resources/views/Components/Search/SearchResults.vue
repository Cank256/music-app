<script setup>
import BrowseCard from '../Cards/BrowseCard.vue';
import LoadingBrowseCard from '../Cards/LoadingBrowseCard.vue';

</script>
<template>

    <div class="w-[calc(100%-360px)] h-[91vh] overflow-x-hidden rounded-b-xl fixed mt-11 right-2 items-center justify-between bg-white dark:bg-gray-800">
        <div class="pr-8 pl-8 pt-12">

            <span class="pl-2 text-white text-2xl font-semibold">
                Artists
            </span>

            <div class="py-1.5"></div>

            <div class="flex flex-wrap items-center gap-1">
                <div v-for="n in 5">
                    <LoadingBrowseCard image="heart" title="Your Favorites" tag="favorites" />
                </div>
            </div>

            <div class="py-1.5 mt-12 mb-12">
                <hr>
            </div>

            <span class="pl-2 text-white text-2xl font-semibold">
                Albums
            </span>

            <div class="py-1.5"></div>

            <div class="flex flex-wrap items-center gap-1">
                <div v-for="n in 5">
                    <LoadingBrowseCard image="heart" title="Your Favorites" tag="favorites" />
                </div>
            </div>
        </div>
    </div>

</template>
