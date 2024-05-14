<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted, watchEffect } from "vue";
import axios from "axios";
import TrashedMessage from "../../Shared/TrashedMessage.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
    movie: Object,
});

const newActor = ref("");
const actors = ref([]);
const deleteForm = useForm({});
const editedActors = ref(
    props.movie.actors.length === 0 ? [] : props.movie.actors
);

const editForm = useForm({
    title: props.movie.title,
    plot: props.movie.plot,
    released_in: props.movie.released_in,
    runtime: props.movie.runtime,
    genre: JSON.parse(props.movie.genre).toString(),
    actors: editedActors.value,
});

// Add a new actor to the editedActors array if it doesn't already exist
const addItem = () => {
    if (!editedActors.value.find((actor) => actor.id === newActor.value.id)) {
        editedActors.value.push(newActor.value);
        newActor.value = "";
    }
};

// Remove an actor from the editedActors array
const removeChip = (index) => {
    editedActors.value.splice(index, 1);
};

// handle movie model delete
const handlemovieDelete = () => {
    if (confirm("Are you sure you want to delete this Movie?")) {
        try {
            deleteForm.delete(`/movies/${props.movie.id}`);
        } catch (error) {
            console.log(error);
        }
    }
};

const handleMovieRestore = () => {
    if (confirm("Are you sure you want to restore this Movie?")) {
        try {
            deleteForm.put(`/movies/${props.movie.id}/restore`);
            toast("Item Restored!", {
                theme: "auto",
                type: "success",
                autoClose: 1000,
                dangerouslyHTMLString: true,
            });
        } catch (error) {
            console.log(error);
        }
    }
};

// fetch all the actor's name
const actorsNames = () => {
    axios.get("/actors/all").then((res) => {
        actors.value = res.data;
    });
};

// get productions and actors name asa component mounts
onMounted(() => {
    actorsNames();
});

watchEffect(() => {
    editForm.actors = editedActors.value;
});
</script>

<template>
    <Head title="movies" />
    <AuthenticatedLayout>
        <div>
            <Head title="Edit Movie" />
            <!-- main content  -->
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
                <h1 class="mb-8 text-3xl font-bold">
                    <span class="text-indigo-400 font-medium">movies/</span>
                    {{ editForm.title }}
                </h1>
                <!-- trashed message  -->
                <TrashedMessage
                    v-if="props.movie.deleted_at"
                    @restore="handleMovieRestore"
                    >This movie is deleted do you want to restore it ?
                </TrashedMessage>
                <!-- update movie model form  -->
                <div class="border p-5">
                    <form
                        action="post"
                        class="flex-col"
                        @submit.prevent="editForm.put(`/movies/${movie.id}`)"
                    >
                        <div class="flex gap-5 my-4">
                            <!-- edit title feild -->
                            <input
                                v-model="editForm.title"
                                type="text"
                                placeholder="title"
                                class="w-1/2"
                                required
                            />
                            <!-- edit runtime feild -->
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
                            <!-- edit plot feild -->
                            <input
                                v-model="editForm.plot"
                                type="text"
                                placeholder="plot"
                                class="w-full"
                                required
                            />
                        </div>
                        <div class="flex gap-5 my-4">
                            <!-- edit actors feild -->
                            <div>
                                <div
                                    v-for="(actor, index) in editedActors"
                                    :key="index"
                                    class="chip"
                                >
                                    {{ actor.name }}
                                    <span
                                        @click="removeChip(index)"
                                        class="close"
                                        >&times;</span
                                    >
                                </div>
                                <!-- movie actors select feild  -->
                                <select @change="addItem" v-model="newActor">
                                    <option disabled value="">
                                        Select Actors
                                    </option>
                                    <option
                                        v-for="actor in actors"
                                        :key="actor"
                                        :value="actor"
                                    >
                                        {{ actor.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-5 my-4">
                            <!-- edit release year feild -->
                            <input
                                v-model="editForm.released_in"
                                type="number"
                                placeholder="released_in year"
                                class="w-1/2"
                                required
                            />
                            <!-- edit/select genre feild -->
                            <select
                                v-model="editForm.genre"
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
                        <!-- action buttons  -->
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
                        </div>
                    </form>
                    <!-- delete movie button  -->
                    <button
                        v-if="!props.movie.deleted_at"
                        class="w-full bg-red-400 p-2"
                        @click="handlemovieDelete"
                    >
                        DELETE
                    </button>
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
                    <!-- actors tabluler listing  -->
                    <table class="w-full whitespace-nowrap border-2">
                        <!-- table head  -->
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
                                v-for="actor in props.movie.actors"
                                :key="actor.id"
                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                            >
                                <!-- actor name  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4 focus:text-indigo-500"
                                        :href="`/actors/${actor.id}/edit`"
                                    >
                                        {{ actor.name }}
                                        <!-- <icon
                                            v-if="actor.deleted_at"
                                            name="trash"
                                            class="shrink-0 ml-2 w-3 h-3 fill-gray-400"
                                        /> -->
                                    </Link>
                                </td>
                                <!-- actor email  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/actors/${movie.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ actor.email }}
                                    </Link>
                                </td>
                                <!-- actor contact  -->
                                <td class="border-t">
                                    <Link
                                        class="flex items-center px-6 py-4"
                                        :href="`/actors/${actor.id}/edit`"
                                        tabindex="-1"
                                    >
                                        {{ actor.contact }}
                                    </Link>
                                </td>
                                <!-- actor edit/view link  -->
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
                            <tr v-if="actors && actors.length === 0">
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
