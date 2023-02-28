<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import LinkButton from '@/Components/LinkButton.vue';
import { formatPrice } from '@/helpers';

defineProps({
    products: Array,
});
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>

        <template #action>
            <LinkButton :href="route('products.create')">Create Product</LinkButton>
        </template>

        <table class="min-w-full text-left text-sm font-light">
          <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4">ID</th>
                    <th scope="col" class="px-6 py-4">Name</th>
                    <th scope="col" class="px-6 py-4">Price</th>
                    <th scope="col" class="px-6 py-4">Edit</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="products.length === 0">
                    <td colspan="4" class="whitespace-nowrap px-6 py-4">No items.</td>
                </tr>
                <tr v-for="product in products" :key="product.id" class="border-b dark:border-neutral-500">
                    <td class="whitespace-nowrap px-6 py-4">{{ product.id }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ product.name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ formatPrice(product.price) }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <LinkButton :href="route('products.edit', { id: product.id })">Edit</LinkButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </AuthenticatedLayout>
</template>
