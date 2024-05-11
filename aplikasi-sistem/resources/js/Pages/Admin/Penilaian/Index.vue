<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ref, watch, defineProps } from 'vue';
const props = defineProps({
    search: {
        type: String,
        default: '',
    },
    kriteria: {
        type: Object,
        default: () => ({}),
    },
    alternatif: {
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
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">

                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-500 uppercase">
                                            -
                                        </th>
                                        <th scope="col" v-for="item in kriteria"
                                            class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-500 uppercase">
                                        {{ item.nama }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="alternatif.length > 0">
                                    <tr v-for="(item, index) in alternatif" :key="item.id" :class="{ 'opacity-75 blur-sm': Form.processing }">
                                        <td class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800"
                                            v-for="col in alternatif">

                                        </td>
                                    </tr>

                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td :colspan="alternatif.length" class="p-5 text-gray-400 text-center" >Data Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
