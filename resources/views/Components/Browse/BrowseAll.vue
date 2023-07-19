<script setup>
import BrowseCard from '../Cards/BrowseCard.vue';

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
                <BrowseCard image="bolt" title="Live Events" tag="seen live" />
                <BrowseCard image="earth-africa" title="Afro" tag="afro" />

                <BrowseCard image="hand-spock" title="Rock" tag="rock" />
                <BrowseCard image="guitar" title="Pop" tag="pop" />
                <BrowseCard image="meteor" title="Hip-Hop" tag="Hip-Hop" />
                <BrowseCard image="dice" title="RnB" tag="rnb" />
                <BrowseCard image="cross" title="Christian" tag="christian" />
                <BrowseCard image="atom" title="Electronic" tag="electronic" />

                <BrowseCard image="hat-cowboy" title="Country" tag="country" />
                <BrowseCard image="music" title="Jazz" tag="jazz" />
                <BrowseCard image="microphone-lines" title="Classic" tag="classic" />
                <BrowseCard image="drum" title="Funk" tag="funk" />
                <BrowseCard image="glasses" title="Blues" tag="blues" />
                <BrowseCard image="headphones" title="K-Pop" tag="k-pop" />

                <!-- <BrowseCard image="getImage(artist)" title="Indie" tag="indie" />
                <BrowseCard image="getImage(artist)" title="Metal" tag="metal" /> -->
                <!-- <BrowseCard image="getImage(artist)" title="Folk" tag="folk" />
                <BrowseCard image="getImage(artist)" title="Ambient" tag="ambient" />
                <BrowseCard image="getImage(artist)" title="Punk" tag="punk" />
                <BrowseCard image="getImage(artist)" title="Dance" tag="dance" /> -->
            </div>
        </div>
    </div>

</template>
