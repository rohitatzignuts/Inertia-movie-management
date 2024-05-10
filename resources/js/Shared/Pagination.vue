<script setup lang="ts">
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";

defineProps<{
    links: Array;
}>();
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap">
            <!-- Loop through each link in the 'links' array -->
            <template v-for="(link, k) in links" :key="k">
                <!-- If the link URL is null, display a non-clickable link -->
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />

                <!-- If the link URL is not null, display a clickable link -->
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-indigo-500 text-white': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
