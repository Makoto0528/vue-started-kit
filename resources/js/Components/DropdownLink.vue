<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    href: String,
    as: String,
})
</script>

<template>
    <div>
        <button
            v-if="as == 'button'"
            class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-hidden dark:text-gray-300 dark:hover:bg-gray-800 dark:focus:bg-gray-800"
            type="submit"
        >
            <slot />
        </button>

        <a
            v-else-if="as == 'a'"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-hidden dark:text-gray-300 dark:hover:bg-gray-800 dark:focus:bg-gray-800"
            :href="href"
        >
            <slot />
        </a>

        <Link
            v-else
            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-hidden dark:text-gray-300 dark:hover:bg-gray-800 dark:focus:bg-gray-800"
            :href="href"
        >
            <slot />
        </Link>
    </div>
</template>
