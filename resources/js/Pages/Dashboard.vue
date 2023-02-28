<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Product from '@/Pages/Partials/Product.vue';

defineProps({
    products: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div v-if="products.length === 0">No products yet.</div>
            <Product v-for="product in products" :key="product.id" :product="product"></Product>
        </div>
    </AuthenticatedLayout>
</template>
