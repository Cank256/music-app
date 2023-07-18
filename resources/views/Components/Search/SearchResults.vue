<script setup>
    import { ref, watch } from 'vue';
    import { usePage, useRememberedState } from '@inertiajs/inertia-vue3';

    const { data: user } = useRememberedState('user');
    const { props, visit } = usePage();

    const searchQuery = ref('');
    const showResults = ref(false);
    const searchResults = ref({ artists: [], albums: [] });

    watch(searchQuery, async (newValue) => {
        if (newValue.trim() !== '') {
            showResults.value = true;
            const response = await visit('/api/search', {
            method: 'get',
            data: { query: newValue },
            });

            searchResults.value = response.artists && response.albums ? response : { artists: [], albums: [] };
        } else {
            showResults.value = false;
            searchResults.value = { artists: [], albums: [] };
        }
    });

    return { user, searchQuery, showResults, searchResults, handleSearch };
</script>
<template>
    <div>
        <input v-model="searchQuery" @keydown.enter="handleSearch" placeholder="Search artists and albums..." />
        <div v-if="showResults">
            <div v-if="searchResults.artists.length > 0">
                <h2>Artists</h2>
                <ul>
                    <li v-for="artist in searchResults.artists" :key="artist.name">
                        <img :src="artist.image" alt="Artist" />
                        {{ artist.name }}
                    </li>
                </ul>
            </div>
            <div v-if="searchResults.albums.length > 0">
                <h2>Albums</h2>
                <ul>
                    <li v-for="album in searchResults.albums" :key="album.name">
                    <img :src="album.image" alt="Album" />
                    {{ album.name }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
