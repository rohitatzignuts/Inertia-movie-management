<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
const productionCreateForm = useForm({
    name: null,
    email: null,
    phone: null,
    address: null,
    city: null,
    country: null,
});
</script>

<template>
    <Head title="Productions" />

    <AuthenticatedLayout>
        <div>
            <Head title="Create Production" />
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="mb-8 text-3xl font-bold">
                    <span class="text-indigo-400 font-medium"
                        >Productions/</span
                    >
                    Create
                </h1>
                <div class="border p-5">
                    <form
                        action="post"
                        class="flex-col"
                        @submit.prevent="
                            productionCreateForm.post('/productions')
                        "
                    >
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="productionCreateForm.name"
                                type="text"
                                placeholder="Name"
                                class="w-1/2"
                                required
                            />
                            <input
                                v-model="productionCreateForm.email"
                                type="email"
                                placeholder="Email"
                                class="w-1/2"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="productionCreateForm.phone"
                                type="text"
                                placeholder="phone"
                                class="w-1/2"
                                required
                            />
                            <input
                                v-model="productionCreateForm.address"
                                type="text"
                                placeholder="address"
                                class="w-1/2"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="productionCreateForm.city"
                                type="text"
                                placeholder="city"
                                class="w-1/2"
                                required
                            />
                            <select
                                class="w-1/2"
                                v-model="productionCreateForm.country"
                                required
                            >
                                <option selected disabled>Country</option>
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
