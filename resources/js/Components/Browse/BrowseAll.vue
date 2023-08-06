<script setup>
import BrowseCard from '../Cards/BrowseCard.vue';

defineProps({
    tags: Object
});

</script>
<template>
    <div class="max-w-7xl mx-auto lg:px-8 space-y-6 max-sm:mt-[-43px]">
        <div class="w-[78.58vw] h-[91vh] max-sm:w-[97.5vw] overflow-x-hidden mt-12 ml-[7.5rem] max-sm:ml-[.3rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-800">
            <div class="pr-8 pl-8 pt-6 max-sm:pr-3 max-sm:pl-3">
                <span class="pl-2 text-white text-2xl max-sm:text-lg font-semibold">
                    Browse All
                </span>

                <div class="py-1.5"></div>

                <div class="flex flex-wrap items-center gap-1">
                <!-- <div class="grid xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-5"> -->
                    <BrowseCard image="heart" type="system" title="Your Favorites" tag="library" />
                    <BrowseCard image="star" type="system" title="Made For You" tag="home" />
                    <BrowseCard image="circle-play" title="New Releases" tag="new" />
                    <BrowseCard image="lightbulb" title="Discover" tag="discover" />

                    <div v-for="tag in tags">
                        <BrowseCard image="compact-disc" :title="tag.name" />
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>
