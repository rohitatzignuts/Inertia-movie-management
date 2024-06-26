<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import Pagination from "@/Shared/Pagination.vue";
import Filters from "@/Shared/Filters.vue";

defineProps({
    actors: Object,
});
</script>

<template>
    <Head title="actors" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Actors
            </h2>
        </template>

        <div>
            <Head title="actors" />
            <!-- main content  -->
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 pb-8">
                <!-- actions  -->
                <div class="flex justify-between my-4">
                    <!-- search input  -->
                    <Filters :url="`/actors`" />
                    <!-- create production link  -->
                    <Link
                        href="/actors/create"
                        as="button"
                        type="button"
                        class="py-2 px-4 bg-indigo-400 rounded"
                        >create actor</Link
                    >
                </div>
                <!-- actors tablular listing  -->
                <div class="bg-white rounded-md shadow overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <!-- table headings  -->
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">Name</th>
                                <th class="pb-4 pt-6 px-6">Email</th>
                                <th class="pb-4 pt-6 px-6">Contact</th>
                            </tr>
                        </thead>
                        <!-- table body  -->
                        <tbody>
                            <tr
                                v-for="actor in actors.data"
                                :key="actor.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <!-- actor name column  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        :href="`/actors/${actor.id}/edit`"
                                    >
                                        {{ actor.name }}
                                        <sup
                                            v-if="actor.deleted_at"
                                            class="ms-1 text-red-300"
                                            >✗</sup
                                        >
                                    </Link>
                                </td>
                                <!-- actor email column  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/actors/${actor.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ actor.email }}
                                    </Link>
                                </td>
                                <!-- actor contact column  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/actors/${actor.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ actor.contact }}
                                    </Link>
                                </td>
                                <!-- actor edit link column  -->
                                <td class="w-px border-t">
                                    <Link
                                        class="flex items-center px-4"
                                        :href="`/movies/${actor.id}/edit`"
                                        tabindex="-1"
                                    >
                                        ▶
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="actors.data && actors.length === 0">
                                <td class="px-6 py-4 border-t" colspan="4">
                                    No actors found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- pagination  -->
                <pagination class="mt-6" :links="actors.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
