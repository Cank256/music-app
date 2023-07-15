<script setup>
import Checkbox from '../../Components/Checkbox.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import InputError from '../../Components/InputError.vue';
import InputLabel from '../../Components/InputLabel.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import TextInput from '../../Components/TextInput.vue';
import GoogleLogo from '../../Components/GoogleLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    notifications: false,
});

const submit = () => {
    form.post(route('signup'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Signup" />

        <div class="flex justify-center mt-8 mb-10">
            <a href="/auth/google">
                <SecondaryButton class="focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800">
                    <span><GoogleLogo class="w-8 h-8" /></span>
                    <span class="ml-6 font-extrabold">Sign up With Google</span>
                </SecondaryButton>
            </a>
        </div>

        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="block mt-4">
                <label class="flex items-start">
                    <Checkbox class="mt-1" name="remember" v-model:checked="form.notifications" />
                    <span class="ml-4 text-sm text-gray-600 dark:text-gray-400">I would prefer not to receive marketing messages from Music App</span>
                </label>
            </div>

            <div class="mt-4">
                <span class="text-gray-400 text-xs">
                    By clicking on sign-up, you agree to the <a href="#" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-gray-100">Music App Terms and Conditions</a> and <a href="#" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-gray-100">Privacy Policy</a>.
                </span>
            </div>

            <div class="flex justify-center mt-8 mb-8">
                <PrimaryButton class="block w-full h-11 justify-center text-white bg-green-600 dark:bg-green-600 text-xl" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Sign Up
                </PrimaryButton>
            </div>

            <div class="flex justify-center mb-6">
                <span class="text-sm text-white mr-1">Have an Account?</span>
                <Link
                    :href="route('login')"
                    class="underline text-sm text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Log In
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
