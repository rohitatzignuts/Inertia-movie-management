<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";
import SelectActorsDropdown from "./Partials/SelectActorsDropdown.vue";

const productions = ref([]);
const actors = ref([]);
const newActor = ref<string>("");

const movieCreateForm = useForm({
    title: null,
    plot: null,
    genre: "genre",
    releasedIn: null,
    runtime: null,
    actors: [],
    production: "production",
});

const productionNames = () => {
    axios.get("/productions/all").then((res) => {
        productions.value = res.data;
    });
};

const actorsNames = () => {
    axios.get("/actors/all").then((res) => {
        actors.value = res.data;
    });
};

const addItem = () => {
    if (newActor.value && !movieCreateForm.actors.includes(newActor.value)) {
        movieCreateForm.actors.push(newActor.value);
        newActor.value = "";
    }
};

const removeChip = (index: number) => {
    movieCreateForm.actors.splice(index, 1);
};

onMounted(() => {
    productionNames();
    actorsNames();
});
</script>

<template>
    <Head title="Movies" />

    <AuthenticatedLayout>
        <div>
            <Head title="Create Movie" />
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="mb-8 text-3xl font-bold">
                    <span class="text-indigo-400 font-medium">Movies/</span>
                    Create
                </h1>
                <div class="border p-5">
                    <form
                        action="post"
                        class="flex-col"
                        @submit.prevent="movieCreateForm.post('/movies')"
                    >
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="movieCreateForm.title"
                                type="text"
                                placeholder="title"
                                class="w-full"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <select
                                v-model="movieCreateForm.genre"
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

                            <input
                                v-model="movieCreateForm.releasedIn"
                                type="number"
                                placeholder="releasedIn year"
                                class="w-1/2"
                                required
                            />
                        </div>

                        <!-- selected actors  -->
                        <div class="flex gap-5 my-4">
                            <div>
                                <div
                                    v-for="(
                                        item, index
                                    ) in movieCreateForm.actors"
                                    :key="index"
                                    class="chip"
                                >
                                    {{ item }}
                                    <span
                                        @click="removeChip(index)"
                                        class="close"
                                        >&times;</span
                                    >
                                </div>
                                <select @change="addItem" v-model="newActor">
                                    <option disabled value="">
                                        Select Item
                                    </option>
                                    <option
                                        v-for="actor in actors"
                                        :key="actor"
                                        :value="actor"
                                    >
                                        {{ actor }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-5 my-4">
                            <input
                                v-model="movieCreateForm.plot"
                                type="text"
                                placeholder="plot"
                                class="w-full"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <input
                                v-model="movieCreateForm.runtime"
                                type="number"
                                min="30"
                                max="350"
                                placeholder="runtime"
                                class="w-1/2"
                                required
                            />
                            <select
                                class="w-1/2"
                                v-model="movieCreateForm.production"
                                required
                            >
                                <option value="production" selected disabled>
                                    select production
                                </option>
                                <option
                                    v-for="production in productions"
                                    :value="production"
                                >
                                    {{ production }}
                                </option>
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
<style scoped>
.chip {
    display: inline-block;
    padding: 0.3rem 0.6rem;
    margin: 0.2rem;
    background-color: #f1f1f1;
    border-radius: 0.2rem;
}

.close {
    margin-left: 0.3rem;
    color: #888;
    font-weight: bold;
    cursor: pointer;
}
</style>
