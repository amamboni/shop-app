<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import { useForm } from '@inertiajs/vue3';
import { formatPrice } from '@/helpers';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed } from 'vue';

const props = defineProps({
    cartItems: Array,
});

const deleteForm = useForm({});
const checkoutForm = useForm({});

const total = computed(() => props.cartItems.reduce((prev, curr) => {
    return prev + curr.quantity * curr.product.price;
}, 0));

const deleteCartItem = (id) => {
    deleteForm.delete(route('cart_items.destroy', { id }), {
        preserveScroll: true,
        // onSuccess: () => form.reset(),
        // onError: () => {
        //     if (form.errors.name) {
        //         nameInput.value.focus();
        //     }
        //     if (form.errors.price) {
        //         priceInput.value.focus();
        //     }
        // },
    });
};

const checkout = () => {
    checkoutForm.post(route('orders.store'), {
        preserveScroll: true,
        // onSuccess: () => form.reset(),
        // onError: () => {
        //     if (form.errors.name) {
        //         nameInput.value.focus();
        //     }
        //     if (form.errors.price) {
        //         priceInput.value.focus();
        //     }
        // },
    });
}

</script>

<template>
    <Head title="Cart" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cart Items</h2>
        </template>

        <table class="min-w-full text-left text-sm font-light">
          <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                    <!-- <th scope="col" class="px-6 py-4">ID</th> -->
                    <th scope="col" class="px-6 py-4">Name</th>
                    <th scope="col" class="px-6 py-4">Price</th>
                    <th scope="col" class="px-6 py-4">Quantity</th>
                    <th scope="col" class="px-6 py-4">Total</th>
                    <th scope="col" class="px-6 py-4">Remove</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="cartItems.length === 0">
                    <td colspan="4" class="whitespace-nowrap px-6 py-4">No items.</td>
                </tr>
                <tr v-for="cartItem in cartItems" :key="cartItem.id" class="border-b dark:border-neutral-500">
                    <td class="whitespace-nowrap px-6 py-4">{{ cartItem.product.name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ formatPrice(cartItem.product.price) }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ cartItem.quantity }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ formatPrice(cartItem.quantity * cartItem.product.price) }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <DangerButton :disabled="deleteForm.processing" @click="deleteCartItem(cartItem.id)">Remove</DangerButton>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" scope="col" class="px-6 py-4">Total</th>
                    <th scope="col" class="px-6 py-4">{{ formatPrice(total) }}</th>
                    <th scope="col" class="px-6 py-4"></th>
                </tr>
            </tfoot>
        </table>
        <div v-if="cartItems.length > 0" class="flex items-center gap-4 mt-5">
            <PrimaryButton :disabled="checkoutForm.processing" @click="checkout">Checkout</PrimaryButton>
            <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                <p v-if="checkoutForm.recentlySuccessful" class="text-sm text-gray-600">Checked Out.</p>
            </Transition>
        </div>
    </AuthenticatedLayout>
</template>
