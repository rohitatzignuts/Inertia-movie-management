<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";

const props = defineProps({
    movie: Object,
});

const editForm = useForm({
    title: props.movie.title,
    plot: props.movie.plot,
    released_in: props.movie.released_in,
    runtime: props.movie.runtime,
    genre: JSON.parse(props.movie.genre).toString(),
});

const handlemovieDelete = async () => {
    if (confirm("Are you sure you want to delete this movie?")) {
        try {
            router.visit(`/movies/${props.movie.id}`, {
                method: "delete",
            });
        } catch (error) {
            console.error(error);
        }
    }
};
</script>

<template>
    <Head title="movies" />
    <AuthenticatedLayout>
        <div>
            <Head title="Edit Movie" />
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="mb-8 text-3xl font-bold">
                    <span class="text-indigo-400 font-medium">movies/</span>
                    {{ editForm.title }}
                </h1>
                <div class="border p-5">
                    <form
                        action="post"
                        class="flex-col"
                        @submit.prevent="editForm.put(`/movies/${movie.id}`)"
                    >
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="editForm.title"
                                type="text"
                                placeholder="title"
                                class="w-1/2"
                                required
                            />
                            <input
                                v-model="editForm.runtime"
                                type="number"
                                placeholder="runtime"
                                min="30"
                                max="350"
                                class="w-1/2"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="editForm.plot"
                                type="text"
                                placeholder="plot"
                                class="w-full"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="editForm.released_in"
                                type="number"
                                placeholder="released_in year"
                                class="w-1/2"
                                required
                            />
                            <select
                                v-model="editForm.genre"
                                type="text"
                                placeholder="genre"
                                class="w-1/2"
                                required
                            >
                                <option value="genre" selected disabled>
                                    select genre
                                </option>
                                <option value="Action">Action</option>
                                <option value="Comedy">Comedy</option>
                                <option value="Thriller">Thriller</option>
                                <option value="Drama">Drama</option>
                            </select>
                        </div>
                        <div class="flex gap-5 my-4 bg-gray-200 py-4">
                            <button
                                class="w-1/2 bg-indigo-400 p-2"
                                type="submit"
                            >
                                EDIT
                            </button>
                            <button class="w-1/2 bg-red-200 p-2" type="reset">
                                RESET
                            </button>
                            <button
                                class="w-1/2 bg-red-400 p-2"
                                @click="handlemovieDelete"
                            >
                                DELETE
                            </button>
                        </div>
                    </form>
                </div>
                <!-- display actors of the movie  -->
                <div
                    v-if="props.movie.actors.length > 0"
                    class="max-w-7xl mt-8 mx-auto sm:px-6 lg:px-8 pb-8"
                >
                    <hr class="my-6" />
                    <p class="text-2xl font-bold underline pb-2">
                        Movie's Actors
                    </p>
                    <table class="w-full whitespace-nowrap border-2">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">Name</th>
                                <th class="pb-4 pt-6 px-6">Email</th>
                                <th class="pb-4 pt-6 px-6">Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="actor in props.movie.actors"
                                :key="actor.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        :href="`/actors/${actor.id}/edit`"
                                    >
                                        {{ actor.name }}
                                        <icon
                                            v-if="actor.deleted_at"
                                            name="trash"
                                            class="shrink-0 ml-2 w-3 h-3 fill-gray-400"
                                        />
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/actors/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ actor.email }}
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/actors/${actor.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ actor.contact }} Mins.
                                    </Link>
                                </td>
                                <td class="w-px border-t">
                                    <Link
                                        class="flex items-center px-4"
                                        :href="`/actors/${actor.id}/edit`"
                                        tabindex="-1"
                                    >
                                        ▶
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="actor && actor.length === 0">
                                <td class="px-6 py-4 border-t" colspan="4">
                                    No actors found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>