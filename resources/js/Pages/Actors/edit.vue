<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";

const props = defineProps({
    actor: Object,
});

const delteForm = useForm({});
const editForm = useForm({
    name: props.actor.name,
    email: props.actor.email,
    contact: props.actor.contact,
});

const handleActorDelete = async () => {
    try {
        await delteForm.delete(`/actors/${props.actor.id}`);
    } catch (error) {
        console.error(error);
    }
};
</script>

<template>
    <Head name="actors" />
    <AuthenticatedLayout>
        <div>
            <Head name="Edit actor" />
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="mb-8 text-3xl font-bold">
                    <span class="text-indigo-400 font-medium">actors/</span>
                    {{ editForm.name }}
                </h1>
                <div class="border p-5">
                    <form
                        action="post"
                        class="flex-col"
                        @submit.prevent="editForm.put(`/actors/${actor.id}`)"
                    >
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="editForm.name"
                                type="text"
                                placeholder="name"
                                class="w-1/2"
                                required
                            />
                            <input
                                v-model="editForm.email"
                                type="text"
                                placeholder="email"
                                class="w-1/2"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="editForm.contact"
                                type="text"
                                placeholder="contact"
                                class="w-full"
                                required
                            />
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
                                @click="handleActorDelete"
                            >
                                DELETE
                            </button>
                        </div>
                    </form>
                </div>
                <!-- display movies of the actor  -->
                <div
                    v-if="props.actor.movies.length > 0"
                    class="max-w-7xl mt-8 mx-auto sm:px-6 lg:px-8 pb-8"
                >
                    <hr class="my-6" />
                    <p class="text-2xl font-bold underline pb-2">
                        Actor's Movies
                    </p>
                    <table class="w-full whitespace-nowrap border-2">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">Title</th>
                                <th class="pb-4 pt-6 px-6">Genre</th>
                                <th class="pb-4 pt-6 px-6">Runtime</th>
                                <th class="pb-4 pt-6 px-6">Released In</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="movie in props.actor.movies"
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
                                            v-if="actor.deleted_at"
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
                                        {{ movie.runtime }} Mins.
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/movies/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ movie.released_in }} Mins.
                                    </Link>
                                </td>
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
                            <tr v-if="actor && actor.length === 0">
                                <td class="px-6 py-4 border-t" colspan="4">
                                    No Movies found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
