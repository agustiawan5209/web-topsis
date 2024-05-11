<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ref, watch, defineProps } from 'vue';
const props = defineProps({
    search: {
        type: String,
        default: '',
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})


</script>

<template>

    <Head title="Topsis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hasil Metode Topsis</h2>
        </template>

        <div class="py-4 relative box-content">

        </div>
    </AuthenticatedLayout>
</template>
