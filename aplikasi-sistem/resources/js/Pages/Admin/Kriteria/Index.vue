<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CardTable from '@/Components/Card/CardTable.vue';

import { ref, watch, defineProps } from 'vue';
const props = defineProps({
    search: {
        type: String,
        default: '',
    },
    order: {
        type: String,
        default: '',
    },
    data: {
        type: Object,
        default: () => ({}),
    },
    table_colums: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})
const crud = ref({
    tambah: props.can.add,
    edit: props.can.edit,
    show: props.can.show,
    delete: props.can.delete,
    reset_password: false,

})

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Kriteria</h2>
        </template>

        <div class="py-4 relative box-content">
            <CardTable @update:search="search = $event" @update:order="order" :slug="null" path="Kriteria" :TableData="data" :tableColums="table_colums" :crud="crud" />
        </div>
    </AuthenticatedLayout>
</template>
