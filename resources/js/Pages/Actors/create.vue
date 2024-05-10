<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";

const actorCreateForm = useForm({
    name: null,
    email: null,
    contact: null,
});
</script>

<template>
    <Head name="Actors" />

    <AuthenticatedLayout>
        <div>
            <Head name="Create actor" />
            <!-- main content  -->
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="mb-8 text-3xl font-bold">
                    <span class="text-indigo-400 font-medium">actors/</span>
                    Create
                </h1>
                <!-- create new actor form  -->
                <div class="border p-5">
                    <form
                        action="post"
                        class="flex-col"
                        @submit.prevent="actorCreateForm.post('/actors')"
                    >
                        <div class="flex gap-5 my-4">
                            <!-- name feild  -->
                            <input
                                v-model="actorCreateForm.name"
                                type="text"
                                placeholder="name"
                                class="w-1/2"
                                required
                            />
                            <!-- email feild  -->
                            <input
                                v-model="actorCreateForm.email"
                                type="email"
                                placeholder="email"
                                class="w-1/2"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <!-- contact feild  -->
                            <input
                                v-model="actorCreateForm.contact"
                                type="text"
                                placeholder="contact"
                                class="w-full"
                                required
                            />
                        </div>
                        <!-- action button  -->
                        <div class="flex gap-5 my-4 bg-gray-200 py-4">
                            <button
                                class="w-1/2 bg-indigo-400 p-2"
                                type="submit"
                            >
                                SUBMIT
                            </button>
                            <button class="w-1/2 bg-red-200 p-2" type="reset">
                                RESET
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
