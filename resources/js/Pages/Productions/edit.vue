<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    production: Object,
});

const editForm = useForm({
    name: props.production.name,
    email: props.production.email,
    city: props.production.city,
    phone: props.production.phone,
    country: props.production.country,
    address: props.production.address,
});

const handleProductionDelete = async () => {
    if (confirm("Are you sure you want to delete this production?")) {
        try {
            router.visit(`/productions/${props.production.id}`, {
                method: "delete",
            });
        } catch (error) {
            console.error(error);
        }
    }
};
</script>

<template>
    <Head title="Productions" />
    <AuthenticatedLayout>
        <div>
            <Head title="Create Organization" />
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="mb-8 text-3xl font-bold">
                    <span class="text-indigo-400 font-medium"
                        >Productions/</span
                    >
                    {{ editForm.name }}
                </h1>
                <div class="border p-5">
                    <form
                        action="post"
                        class="flex-col"
                        @submit.prevent="
                            editForm.put(`/productions/${production.id}`)
                        "
                    >
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="editForm.name"
                                type="text"
                                placeholder="Name"
                                class="w-1/2"
                                required
                            />
                            <input
                                v-model="editForm.email"
                                type="email"
                                placeholder="Email"
                                class="w-1/2"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="editForm.phone"
                                type="text"
                                placeholder="phone"
                                class="w-1/2"
                                required
                            />
                            <input
                                v-model="editForm.address"
                                type="text"
                                placeholder="address"
                                class="w-1/2"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="editForm.city"
                                type="text"
                                placeholder="city"
                                class="w-1/2"
                                required
                            />
                            <select
                                class="w-1/2"
                                v-model="editForm.country"
                                required
                            >
                                <option disabled>Country</option>
                                <option value="USA">USA</option>
                                <option value="UK">UK</option>
                                <option value="AUS">AUS</option>
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
                                @click="handleProductionDelete"
                            >
                                Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- display movie of the production  -->
            <div
                v-if="props.production.movies.length > 0"
                class="max-w-7xl mt-8 mx-auto sm:px-6 lg:px-8 pb-8"
            >
                <hr class="my-6" />
                <p class="text-2xl font-bold">Movies</p>
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
                            v-for="movie in props.production.movies"
                            :key="movie.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100"
                        >
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4 focus:text-indigo-500"
                                    :href="`/productions/${movie.id}/edit`"
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
                                    :href="`/productions/${movie.id}/edit`"
                                    tabindex="-1"
                                >
                                    {{ movie.genre }}
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    :href="`/productions/${movie.id}/edit`"
                                    tabindex="-1"
                                >
                                    {{ movie.runtime }} Mins.
                                </Link>
                            </td>
                            <td class="border-t">
                                <Link
                                    class="flex items-center px-6 py-4"
                                    :href="`/productions/${production.id}/edit`"
                                    tabindex="-1"
                                >
                                    {{ movie.released_in }}
                                </Link>
                            </td>
                            <td class="w-px border-t">
                                <Link
                                    class="flex items-center px-4"
                                    :href="`/productions/${movie.id}/edit`"
                                    tabindex="-1"
                                >
                                    ▶
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="movie && movie.length === 0">
                            <td class="px-6 py-4 border-t" colspan="4">
                                No movies found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>