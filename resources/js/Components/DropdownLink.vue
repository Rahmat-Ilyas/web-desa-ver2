<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    as: String,
});
</script>

<template>
    <div class="px-1 py-1">
        <button v-if="as == 'button'" type="submit"
            class="group flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition-all duration-200 ease-in-out hover:bg-blue-50/80 hover:text-blue-600 focus:bg-blue-50 focus:outline-none">
            <slot />
        </button>

        <a v-else-if="as == 'a'" :href="href"
            class="group flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition-all duration-200 ease-in-out hover:bg-blue-50/80 hover:text-blue-600 focus:bg-blue-50 focus:outline-none">
            <slot />
        </a>

        <Link v-else :href="href" class="group flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition-all duration-200 ease-in-out hover:bg-white hover:text-blue-600 hover:shadow-md hover:-translate-y-0.5 focus:bg-blue-50 focus:outline-none">
            <slot />
        </Link>
    </div>
</template>
