<script setup>
import MainLayout from '../../Layouts/MainLayout.vue'
import ProfileCard from '../../Components/Cards/ProfileCard.vue'
import { Head, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

</script>

<template>
    <Head title="Profile" />
    <MainLayout>
        <div class="max-w-7xl mx-auto lg:px-8 space-y-6">
            <div class="w-[78.58vw] h-[91vh] overflow-x-hidden mt-12 ml-[7.5rem] shadow rounded-b-xl items-center justify-between bg-white dark:bg-gray-900">
                <div class="pr-8">
                    <div class="mt-2 w-[80vw] h-[90vh] p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <ProfileCard :name="user.name" :email="user.email" :joined="user.created_at" type="Subscriber" class="max-w-xl" />
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
