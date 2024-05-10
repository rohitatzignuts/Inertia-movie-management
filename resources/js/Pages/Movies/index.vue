<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import Pagination from "@/Shared/Pagination.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

defineProps({
    movies: Object,
});
const searchValue = ref(null);

// get movies listing on the movie title
const handleProductionSearch = () => {
    setTimeout(() => {
        router.visit("/movies", {
            method: "get",
            data: { searchValue: searchValue.value },
            preserveState: true,
        });
    }, 150);
};
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
            <!-- main content  -->
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 pb-8">
                <div class="flex justify-between my-4">
                    <!-- search input  -->
                    <div>
                        <input
                            v-model="searchValue"
                            id="searchForm"
                            name="searchForm"
                            type="search"
                            class="rounded-sm border-indigo-400 border-l-8"
                            placeholder="search..."
                            @input="handleProductionSearch"
                        />
                    </div>
                    <!-- create movie button  -->
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
                        <!-- table headig  -->
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">Title</th>
                                <th class="pb-4 pt-6 px-6">Genre</th>
                                <th class="pb-4 pt-6 px-6">Released In</th>
                                <th class="pb-4 pt-6 px-6">Runtime</th>
                            </tr>
                        </thead>
                        <!-- table body  -->
                        <tbody>
                            <tr
                                v-for="movie in movies.data"
                                :key="movie.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <!-- movie title  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        :href="`/movies/${movie.id}/edit`"
                                    >
                                        {{ movie.title }}
                                        <!-- <icon
                                            v-if="movie.deleted_at"
                                            name="trash"
                                            class="shrink-0 ml-2 w-3 h-3 fill-gray-400"
                                        /> -->
                                    </Link>
                                </td>
                                <!-- movie genre  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/movies/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ movie.genre }}
                                    </Link>
                                </td>
                                <!-- movie release year -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/movies/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ movie.released_in }}
                                    </Link>
                                </td>
                                <!-- movie runtime  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/movies/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ movie.runtime }} Mins.
                                    </Link>
                                </td>
                                <!-- movie edit/view link  -->
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
                <!-- padination  -->
                <pagination class="mt-6" :links="movies.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
