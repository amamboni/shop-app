<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { formatPrice } from '@/helpers';

defineProps({
    orders: Array,
});


</script>

<template>
    <Head title="Orders" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Orders</h2>
        </template>

        <table class="min-w-full text-left text-sm font-light">
          <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4">ID</th>
                    <th scope="col" class="px-6 py-4">User</th>
                    <th scope="col" class="px-6 py-4">Items</th>
                    <th scope="col" class="px-6 py-4">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="orders.length === 0">
                    <td colspan="4" class="whitespace-nowrap px-6 py-4">No items.</td>
                </tr>
                <tr v-for="order in orders" :key="order.id" class="border-b dark:border-neutral-500 align-top">
                    <td class="whitespace-nowrap px-6 py-4">{{ order.id }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="border-b font-medium dark:border-neutral-500 bg-gray-100">
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                            </thead>
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4">{{ order.user.id }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ order.user.first_name }} {{ order.user.last_name }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="border-b font-medium dark:border-neutral-500 bg-gray-100">
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Price</th>
                                <th scope="col" class="px-6 py-4">Quantity</th>
                                <th scope="col" class="px-6 py-4">Total</th>
                            </thead>
                            <tr v-for="item in order.items" :key="item.id">
                                <td class="whitespace-nowrap px-6 py-4">{{ item.product.id }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ item.product.name }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ formatPrice(item.product.price) }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ item.quantity }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ formatPrice(item.product.price * item.quantity) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 font-bold">{{ formatPrice(order.total) }}</td>
                </tr>
            </tbody>
        </table>
    </AuthenticatedLayout>
</template>
