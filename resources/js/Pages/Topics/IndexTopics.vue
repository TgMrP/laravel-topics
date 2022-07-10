<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex w-full justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Topics
                </h2>
                <div class="">
                    <Link href="/topics/create" class="primary-btn">
                        Create
                    </Link>
                </div>
            </div>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div
                            class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                        >
                            <div
                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                            >
                                <table
                                    class="min-w-full divide-y divide-gray-300"
                                >
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">User</th>
                                            <th scope="col">
                                                <span class="sr-only">
                                                    Edit
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="divide-y divide-gray-200 bg-white"
                                    >
                                        <tr
                                            v-for="topic in topics"
                                            :key="topic.id"
                                        >
                                            <td>
                                                <img
                                                    :src="topic.image"
                                                    :alt="topic.name"
                                                    class="w-24 h-24 rounded object-cover"
                                                />
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6"
                                            >
                                                {{ topic.name }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6"
                                            >
                                                {{ topic?.user?.name }}
                                            </td>
                                            <td
                                                class="flex items-center h-24 justify-end text-sm font-medium sm:pr-6 gap-8"
                                            >
                                                <Link
                                                    v-if="
                                                        $page.props.auth.user
                                                            .id ===
                                                        topic.user.id
                                                    "
                                                    :href="`/topics/${topic.id}/edit`"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                >
                                                    Edit
                                                </Link>
                                                <Link
                                                    v-if="
                                                        $page.props.auth.user
                                                            .id ===
                                                        topic.user.id
                                                    "
                                                    :href="`/topics/${topic.id}`"
                                                    method="delete"
                                                    as="button"
                                                    type="button"
                                                    class="text-red-600 hover:text-red-900"
                                                >
                                                    Delete
                                                </Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    topics: Array,
});
</script>

<style lang="scss" scoped>
th {
    @apply px-3 py-3.5 text-left text-sm font-semibold text-gray-900;
}
</style>
