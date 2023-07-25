<script setup>
import { ref } from 'vue';

const props = defineProps(['isSearching']);
const searchQuery = ref('');
const typing = ref(false);

const handleInput = () => {
    if (searchQuery.value.trim() !== '') {
        axios.get(`/searching?searchQuery=${searchQuery.value}`);
    } else {
        axios.get(`/not-searching`);
    }
};

</script>
<template>
    <div class="search-tab ml-8">
        <div class="search-input flex items-center border rounded-full px-3 focus-within:ring focus-within:ring-gray-400">
            <button @click="search" class="flex-1 bg-transparent border-0 cursor-pointer">
                <i class="fas fa-search text-gray-600"></i>
            </button>
            <input class="border-0 bg-transparent text-gray-400 focus:outline-none" type="text" v-model="searchQuery" @input="handleInput" placeholder="Search for Artists, Albums ..." style="width: 45vh;"/>
        </div>
    </div>
</template>

<style>
    /* Optional: Add some styling for the search tab */
    .search-tab {
        display: flex;
        align-items: center;
    }
</style>
