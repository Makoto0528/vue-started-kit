<script setup>
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    policy: String,
})
</script>

<template>
    <Head title="Privacy Policy" />

    <div class="font-sans text-gray-900 antialiased dark:text-gray-100">
        <div class="bg-gray-100 pt-4 dark:bg-gray-900">
            <div class="flex min-h-screen flex-col items-center pt-6 sm:pt-0">
                <div>
                    <AuthenticationCardLogo />
                </div>

                <div
                    class="prose dark:prose-invert mt-6 w-full overflow-hidden bg-white p-6 shadow-md sm:max-w-2xl sm:rounded-lg dark:bg-gray-800"
                    v-html="policy"
                />
            </div>
        </div>
    </div>
</template>
