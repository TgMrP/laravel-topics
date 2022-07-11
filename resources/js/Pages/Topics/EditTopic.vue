<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex w-full justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Topic
                </h2>
                <div class="">
                    <Link href="/topics" class="primary-btn"> Back </Link>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid place-content-center mt-10">
                <form
                    enctype="multipart/form-data"
                    class="bg-white shadow-md m-2 p-2 rounded"
                    @submit.prevent="updateTopic"
                >
                    <div class="sm:col-span-6">
                        <label for="name" class="">Name</label>
                        <div class="mt-1">
                            <input
                                type="text"
                                id="name"
                                name="name"
                                v-model="form.name"
                            />
                        </div>
                        <div
                            class="mt-1 text-red-600 text-sm"
                            v-if="errors?.name"
                        >
                            {{ errors.name }}
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="image" class="">Image</label>
                        <div class="m-2 p-2">
                            <img
                                :src="image"
                                :alt="topic.name"
                                class="w-32 h-32 rounded object-cover"
                            />
                        </div>
                        <div class="mt-1">
                            <input
                                type="file"
                                id="image"
                                name="image"
                                @input="form.image = $event.target.files[0]"
                            />
                        </div>
                        <div
                            class="mt-1 text-red-600 text-sm"
                            v-if="errors?.image"
                        >
                            {{ errors.image }}
                        </div>
                    </div>
                    <div class="my-2">
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="px-4 py-2 bg-green-400 hover:bg-green-600 rounded-lg text-white"
                        >
                            Update Topic
                        </button>
                    </div>
                    <progress
                        v-if="form.progress"
                        :value="form.progress.percentage"
                        max="100"
                    >
                        {{ form.progress.percentage }}%
                    </progress>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    topic: Object,
    image: String,
    errors: Object,
});

const form = useForm({
    name: props.topic.name,
    image: null,
});

function updateTopic() {
    Inertia.post(`/topics/${props.topic.id}`, {
        _method: "put",
        name: form.name,
        image: form.image,
    });
}
</script>

<style lang="scss" scoped>
label {
    @apply block text-sm font-medium text-gray-700;
}
input {
    @apply block w-full appearance-none bg-white;
    @apply border border-gray-400 rounded-md;
    @apply py-2 px-3;
    @apply text-base leading-normal;
    @apply transition duration-150 ease-in-out;
    @apply sm:text-sm sm:leading-5;
}
</style>
