<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    productions: Array,
});
</script>

<template>
    <Head title="Productions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productions
            </h2>
        </template>

        <div>
            <Head title="productions" />
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
                <div class="text-right my-4">
                    <Link
                        href="/productions/create"
                        as="button"
                        type="button"
                        class="py-2 px-4 bg-indigo-400 rounded"
                        >create production</Link
                    >
                </div>
                <div class="bg-white rounded-md shadow overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="text-left font-bold">
                                <th class="pb-4 pt-6 px-6">Name</th>
                                <th class="pb-4 pt-6 px-6">City</th>
                                <th class="pb-4 pt-6 px-6">Email</th>
                                <th class="pb-4 pt-6 px-6">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="production in productions"
                                :key="production.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        :href="`/productions/${production.id}/edit`"
                                    >
                                        {{ production.name }}
                                        <icon
                                            v-if="production.deleted_at"
                                            name="trash"
                                            class="shrink-0 ml-2 w-3 h-3 fill-gray-400"
                                        />
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/productions/${production.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ production.city }}
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/productions/${production.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ production.phone }}
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/productions/${production.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ production.email }}
                                    </Link>
                                </td>
                                <td class="w-px border-t">
                                    <Link
                                        class="flex items-center px-4"
                                        :href="`/productions/${production.id}/edit`"
                                        tabindex="-1"
                                    >
                                        ▶
                                    </Link>
                                </td>
                            </tr>
                            <tr
                                v-if="
                                    productions.data && productions.length === 0
                                "
                            >
                                <td class="px-6 py-4 border-t" colspan="4">
                                    No productions found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <pagination class="mt-6" :links="productions.links" /> -->
        </div>
    </AuthenticatedLayout>
</template>
