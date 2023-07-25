<script setup>
import BrowseCard from '../Cards/BrowseCard.vue';

defineProps({
    tags: Object
});

</script>
<template>

    <div class="w-[calc(100%-360px)] h-[91vh] overflow-x-hidden rounded-b-xl fixed mt-11 right-2 items-center justify-between bg-white dark:bg-gray-700">
        <div class="pr-8 pl-8 pt-6">
            <span class="pl-2 text-white text-2xl font-semibold">
                Browse All
            </span>

            <div class="py-1.5"></div>

            <div class="flex flex-wrap items-center gap-1">
            <!-- <div class="grid xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-5"> -->
                <BrowseCard image="heart" title="Your Favorites" tag="favorites" />
                <BrowseCard image="star" title="Made For You" tag="recommend" />
                <BrowseCard image="circle-play" title="New Releases" tag="new" />
                <BrowseCard image="lightbulb" title="Discover" tag="discover" />

                <div v-for="tag in tags">
                    <BrowseCard image="compact-disc" :title="tag.name" />
                </div>

            </div>
        </div>
    </div>

</template>
