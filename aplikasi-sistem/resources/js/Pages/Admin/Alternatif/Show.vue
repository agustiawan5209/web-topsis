<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CardTable from '@/Components/Card/CardTable.vue';

import { ref, watch, defineProps } from 'vue';
const props = defineProps({
    alternatif: {
        type: Object,
        default: () => ({}),
    },
})

</script>

<template>

    <Head title="Detail alternatif" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data alternatif</h2>
        </template>

        <div class="md:py-4 relative box-content">
            <section class=" py-2 px-0 md:px-6  md:py-6 bg-gray-100 text-gray-900">
                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-3">
                    <div class="space-y-2 col-span-full lg:col-span-1 px-3 md:px-0">
                        <p class="font-medium">Detail Informasi alternatif</p>
                        <p class="text-xs">Detail data alternatif</p>
                    </div>
                    <fieldset class="m-0 pb-6 px-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full  ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail</span>
                                    </li>
                                </ul>

                                <table class="w-full table">
                                    <colgroup>
                                    <col class="w-96">
                                    <col class="w-3">
                                    <col>
                                    </colgroup>
                                    <tr class="" >
                                        <td class="text-sm border-b py-2 font-bold capitalize">Nama Jenis Ikan</td>
                                        <td>:</td>
                                        <td class="text-base border-b text-gray-600"> {{ alternatif.nama }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-b-2 pt-10">Data Sub alternatif Nama Dan Bobot</td>
                                    </tr>
                                    <tr class="" v-for="(item, key) in alternatif.penilaians">
                                        <td class="text-sm border-b py-2 font-bold capitalize whitespace-nowrap">{{ item.kriteria.nama }}</td>
                                        <td>=</td>
                                        <td class="text-sm border-b text-gray-600">
                                            {{ item.nama }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
