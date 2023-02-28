<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { formatPrice } from '@/helpers';
import { useForm } from '@inertiajs/vue3';

defineProps({
    product: Object,
});

const form = useForm({});
const addToCart = (product) => {
    form.post(route('cart_items.store', { product }), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            console.log('error');
            // if (form.errors.name) {
            //     nameInput.value.focus();
            // }
            // if (form.errors.price) {
            //     priceInput.value.focus();
            // }
        },
    });
}
</script>

<template>
    <div class="block w-full m-3 p-6 bg-white border border-gray-200 rounded-lg shadow">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ product.name }}</h5>
        <p class="font-normal text-gray-700 mb-4">{{ formatPrice(product.price) }}</p>
        <div class="flex items-center gap-4">
            <SecondaryButton :disabled="form.processing" @click="addToCart(product.id)">Add to Cart</SecondaryButton>
            <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Added.</p>
            </Transition>
        </div>
    </div>
</template>
