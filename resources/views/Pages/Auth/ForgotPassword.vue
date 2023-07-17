<script setup>
import GuestAuthLayout from '../../Layouts/GuestAuthLayout.vue';
import InputError from '../../Components/InputError.vue';
import InputLabel from '../..//Components/InputLabel.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import TextInput from '../../Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestAuthLayout>
        <Head title="Forgot Password" />

        <div class="mb-8 text-center text-base text-gray-600 dark:text-gray-400">
            Enter your Music App email address that you used to register. We'll send you an email with a link to reset your password.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel class="mb-3" for="email" value="Email Address" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex justify-center mt-6 mb-6">
                <PrimaryButton class="justify-center text-white bg-green-600 dark:bg-green-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>

        <div class="flex justify-center mt-8 mb-6">
            <span class="ml-2 text-white">If you still need help, check out</span>
            <span class="ml-2 text-green-600">
                <Link :href="route('home')" class="hover:text-white">Music App Support</Link>
            </span>
        </div>

        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

        <div class="flex justify-center mt-8 mb-10">
            <Link :href="route('login')">
                <SecondaryButton class="focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800">
                    <span class="font-extrabold">Back to Log In</span>
                </SecondaryButton>
            </Link>
        </div>
    </GuestAuthLayout>
</template>
