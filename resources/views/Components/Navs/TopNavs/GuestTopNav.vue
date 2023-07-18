<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import ChevronRight from 'vue-material-design-icons/ChevronRight.vue';
import ChevronLeft from 'vue-material-design-icons/ChevronLeft.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav class="w-[calc(100%-360px)] bg-opacity-50 fixed top-2 right-2 items-center justify-between bg-white dark:bg-gray-800 rounded-t-xl">
        <!-- Primary Navigation Menu -->
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 mr-20">
            <div class="flex justify-between h-16">
                <div class="flex items-center ml-2">
                    <button type="button" class="rounded-full bg-gray-700 p-[1px] cursor-pointer">
                        <ChevronLeft fillColor="#FFF" :size="30" />
                    </button>
                    <button type="button" class="rounded-full bg-gray-700 p-[1px] hover:bg-[#] ml-4 cursor-pointer">
                        <ChevronRight fillColor="#FFF" :size="30" />
                    </button>
                </div>

                <div class="sm:flex sm:items-center sm:ml-6">
                    <div class="ml-3 relative">
                        <Link
                            :href="route('login')"
                            class="text-lg mr-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >Log In</Link
                        >
                        <Link
                            :href="route('signup')"
                            class="text-lg ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >Sign Up</Link
                        >
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
    </nav>
</template>
