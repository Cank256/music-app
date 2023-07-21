<script setup>
import BrowseCard from '../Cards/BrowseCard.vue';
import LoadingBrowseCard from '../Cards/LoadingBrowseCard.vue';

</script>
<template>

    <div class="w-[calc(100%-360px)] h-[91vh] overflow-x-hidden rounded-b-xl fixed mt-11 right-2 items-center justify-between bg-white dark:bg-gray-800">
        <div class="pr-8 pl-8 pt-12">
            <!-- <div class="mt-6 mb-12">
                <span class="pl-2 text-white text-3xl font-semibold">
                    Search
                </span>
            </div> -->

            <span class="pl-2 text-white text-2xl font-semibold">
                Artists
            </span>

            <div class="py-1.5"></div>

            <div class="flex flex-wrap items-center gap-1">
                <div v-for="n in 6">
                    <LoadingBrowseCard image="heart" title="Your Favorites" tag="favorites" />
                </div>
            </div>

            <!-- <div class="flex flex-wrap items-center gap-1">
                <BrowseCard image="heart" title="Your Favorites" tag="favorites" />
                <BrowseCard image="star" title="Made For You" tag="recommend" />
                <BrowseCard image="circle-play" title="New Releases" tag="new" />
                <BrowseCard image="lightbulb" title="Discover" tag="discover" />
                <BrowseCard image="bolt" title="Live Events" tag="seen live" />
                <BrowseCard image="earth-africa" title="Afro" tag="afro" />
            </div> -->

            <div class="py-1.5 mt-12 mb-12">
                <hr>
            </div>

            <span class="pl-2 text-white text-2xl font-semibold">
                Albums
            </span>

            <div class="py-1.5"></div>

            <div class="flex flex-wrap items-center gap-1">
                <div v-for="n in 6">
                    <LoadingBrowseCard image="heart" title="Your Favorites" tag="favorites" />
                </div>
            </div>

            <!-- <div class="flex flex-wrap items-center gap-1">
                <BrowseCard image="heart" title="Your Favorites" tag="favorites" />
                <BrowseCard image="star" title="Made For You" tag="recommend" />
                <BrowseCard image="circle-play" title="New Releases" tag="new" />
                <BrowseCard image="lightbulb" title="Discover" tag="discover" />
                <BrowseCard image="bolt" title="Live Events" tag="seen live" />
                <BrowseCard image="earth-africa" title="Afro" tag="afro" />
            </div> -->
        </div>
    </div>

</template>
