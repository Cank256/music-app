<script setup>
import Checkbox from '../../Components/Form/Checkbox.vue';
import GuestAuthLayout from '../../Layouts/AuthLayout.vue';
import InputError from '../../Components/Form/InputError.vue';
import InputLabel from '../../Components/Form/InputLabel.vue';
import PrimaryButton from '../../Components/Buttons/PrimaryButton.vue';
import SecondaryButton from '../../Components/Buttons/SecondaryButton.vue';
import TextInput from '../../Components/Form/TextInput.vue';
import GoogleLogo from '../../Components/Logos/GoogleLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <GuestAuthLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="flex justify-center mt-8 mb-10">
            <a href="/auth/google">
                <SecondaryButton class="focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800">
                    <span><GoogleLogo class="w-8 h-8" /></span>
                    <span class="ml-6 font-extrabold">Continue With Google</span>
                </SecondaryButton>
            </a>
        </div>

        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

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

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>

            <div class="flex justify-center mt-8 mb-8">
                <PrimaryButton class="block w-full h-11 justify-center text-white bg-green-600 dark:bg-green-600 text-xl" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                </PrimaryButton>
            </div>

            <div class="flex justify-center mb-6">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
                >
                    Forgot your password?
                </Link>
            </div>
        </form>
    </GuestAuthLayout>
</template>
