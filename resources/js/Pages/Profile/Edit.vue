<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <MainLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 max-lg:mt-[-43px]">
                <div class="mt-2 p-4 sm:p-8 ml-[7.5rem] max-sm:ml-[.4rem] md:ml-[.4rem] max-sm:max-w-[96.5vw] bg-white dark:bg-gray-800 shadow rounded-lg max-sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 ml-[7.5rem] max-sm:ml-[.4rem] md:ml-[.4rem] max-sm:max-w-[96.5vw] bg-white dark:bg-gray-800 shadow sm:rounded-lg max-sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 ml-[7.5rem] max-sm:ml-[.4rem] md:ml-[.4rem] max-sm:mb-[3rem] max-sm:max-w-[96.5vw] bg-white dark:bg-gray-800 shadow sm:rounded-lg max-sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl max-sm:mb-[1rem]" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>
