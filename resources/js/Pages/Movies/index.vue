<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    movies: Array,
});
</script>

<template>
    <Head title="movies" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movies
            </h2>
        </template>

        <div>
            <Head title="movies" />
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 pb-8">
                <div class="text-right my-4">
                    <Link
                        href="/movies/create"
                        as="button"
                        type="button"
                        class="py-2 px-4 bg-indigo-400 rounded"
                        >create movie</Link
                    >
                </div>
                <div class="bg-white rounded-md shadow overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">Title</th>
                                <th class="pb-4 pt-6 px-6">Genre</th>
                                <th class="pb-4 pt-6 px-6">Released In</th>
                                <th class="pb-4 pt-6 px-6">Runtime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="movie in movies"
                                :key="movie.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        :href="`/movies/${movie.id}/edit`"
                                    >
                                        {{ movie.title }}
                                        <icon
                                            v-if="movie.deleted_at"
                                            name="trash"
                                            class="shrink-0 ml-2 w-3 h-3 fill-gray-400"
                                        />
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/movies/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ movie.genre }}
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/movies/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ movie.released_in }}
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/movies/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ movie.runtime }} Mins.
                                    </Link>
                                </td>
                                <td class="w-px border-t">
                                    <Link
                                        class="flex items-center px-4"
                                        :href="`/movies/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        ▶
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="movies.data && movies.length === 0">
                                <td class="px-6 py-4 border-t" colspan="4">
                                    No movies found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <pagination class="mt-6" :links="movies.links" /> -->
        </div>
    </AuthenticatedLayout>
</template>
