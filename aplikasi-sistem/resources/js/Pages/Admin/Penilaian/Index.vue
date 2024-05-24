<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ref, watch, defineProps, onMounted } from 'vue';
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
    topsis: {
        type: Object,
        default: () => ({}),
    },
})

const SumKriteria = ref([]);

function sum(array) {
    const Kriteria = Object.assign(props.kriteria).map((element) => {
        return element.nama;
    })
    const alternatif = Object.assign(array).map((element, key) => {
        const a = Object.values(element).filter((a) => {
            return Number.isInteger(a);
        })
        return a;
    });
    for (let col = 0; col < alternatif[0].length; col++) {
        let sum = 0;

        // Iterate through each row, adding the value at the current column index
        for (let row = 0; row < alternatif.length; row++) {
            sum += alternatif[row][col];
        }

        // Push the column sum to the columnSums array
        SumKriteria.value.push({
            total: sum,
            sqrt: Math.sqrt(sum),
        });
    }
}
if (props.alternatif.length > 2) {
    console.log(props.topsis)
    sum(props.topsis.alternative_square)
    console.log(SumKriteria.value)
}
onMounted(() => {
})
</script>

<template>

    <Head title="Topsis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hasil Metode Topsis</h2>
        </template>

        <div class="py-4 relative box-content" v-if="alternatif.length > 2">
            <div class=" overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">

                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Data Alternatif
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Alternatif
                                        </th>
                                        <th scope="col" v-for="item in kriteria"
                                            class="px-2 py-1 border md:py-3 text-wrap text-start text-xs font-medium text-gray-700 capitalize">
                                            {{ item.nama }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="alternatif.length > 2">
                                    <tr v-for="(item, index) in alternatif" :key="item.id">
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">
                                            {{ item.nama }}
                                        </td>

                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(col, idx) in item.penilaians" :key="col.id">
                                            {{ col.nama }}
                                        </td>

                                    </tr>

                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td :colspan="alternatif.length" class="p-5 text-gray-400 text-center">Data
                                            Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Matrix Alternatif -->
            <div class=" overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">

                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Matrix Alternatif
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Alternatif
                                        </th>
                                        <th scope="col" v-for="item in kriteria"
                                            class="px-2 py-1 border md:py-3 text-wrap text-start text-xs font-medium text-gray-700 capitalize">
                                            {{ item.nama }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="alternatif.length > 2">
                                    <tr v-for="(item, index) in alternatif" :key="item.id">
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">
                                            {{ item.nama }}
                                        </td>

                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(col, idx) in item.penilaians" :key="col.id">
                                            {{ col.nilai }}
                                        </td>

                                    </tr>

                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td :colspan="alternatif.length" class="p-5 text-gray-400 text-center">Data
                                            Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weight -->
            <div class="my-4 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">

                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Bobot Kriteria Alternatif
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th></th>
                                        <th scope="col" v-for="item in kriteria"
                                            class="px-2 py-1 border md:py-3 text-wrap text-start text-xs font-medium text-gray-700 capitalize">
                                            {{ item.nama }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="kriteria.length > 0">
                                    <tr>
                                        <th>Bobot</th>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(item, index) in kriteria" :key="item.id">
                                            {{ item.bobot }}
                                        </td>


                                    </tr>

                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td :colspan="alternatif.length" class="p-5 text-gray-400 text-center">Data
                                            Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Normalisasi -->
            <div class=" overflow-x-auto" v-if="alternatif.length > 2 && kriteria.length > 0">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">

                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Normalisasi Alternatif
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Alternatif
                                        </th>
                                        <th scope="col" v-for="item in kriteria"
                                            class="px-2 py-1 border md:py-3 text-wrap text-start text-xs font-medium text-gray-700 capitalize">
                                            {{ item.nama }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="topsis.alternative.length > 0">
                                    <tr v-for="(item, index) in topsis.alternative" :key="item.id">

                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(col, idx) in item" :key="col.id">
                                            <span v-if="idx == 'nama'">{{ col }}</span>
                                            <span v-else>{{ col }}^2 = {{ topsis.alternative_square[index][idx]
                                                }}</span>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Total
                                        </th>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(col, idx) in kriteria" :key="col" >
                                            <span v-if="SumKriteria[idx] != [] || SumKriteria[idx] != null">&#8730;  {{ SumKriteria[idx].total }} = {{ SumKriteria[idx].sqrt
                                            }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td :colspan="topsis.alternative.length" class="p-5 text-gray-400 text-center">
                                            Data
                                            Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Hasil Normalisasi Alternatif
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Alternatif
                                        </th>
                                        <th scope="col" v-for="item in kriteria"
                                            class="px-2 py-1 border md:py-3 text-wrap text-start text-xs font-medium text-gray-700 capitalize">
                                            {{ item.nama }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="topsis.normalizedMatrix.length > 0">
                                    <tr v-for="(item, index) in alternatif" :key="item.id">
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            item.nama
                                        }}
                                        </td>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(col, idx) in topsis.normalizedMatrix[index]" :key="col.id">
                                            <span> {{ item.penilaians[idx].nilai }} / {{ SumKriteria[idx].sqrt }} ={{
                                                col
                                                }}</span>
                                        </td>

                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td :colspan="topsis.normalizedMatrix.length"
                                            class="p-5 text-gray-400 text-center">
                                            Data
                                            Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Normalisasi Terbobot -->
            <div class="mt-10 overflow-x-auto" v-if="alternatif.length > 2 && kriteria.length > 0">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">
                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Normalisasi Terbobot
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Alternatif
                                        </th>
                                        <th scope="col" v-for="item in kriteria"
                                            class="px-2 py-1 border md:py-3 text-wrap text-start text-xs font-medium text-gray-700 capitalize">
                                            {{ item.nama }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="topsis.normalizedMatrix.length > 0">
                                    <tr v-for="(item, index) in alternatif" :key="item.id">
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            item.nama
                                        }}
                                        </td>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(col, idx) in topsis.normalizedMatrix[index]" :key="col.id">
                                            <span>{{ col }} / {{ topsis.weights[idx] }} = {{
                                                topsis.WeightedNormalizedMatrix[index][idx] }} </span>
                                        </td>

                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td :colspan="topsis.normalizedMatrix.length"
                                            class="p-5 text-gray-400 text-center">
                                            Data
                                            Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ideal Solution -->
            <div class="mt-10 overflow-x-auto" v-if="alternatif.length > 2 && kriteria.length > 0">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">
                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Matriks Solusi Ideal
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            -
                                        </th>
                                        <th scope="col" v-for="item in kriteria"
                                            class="px-2 py-1 border md:py-3 text-wrap text-start text-xs font-medium text-gray-700 capitalize">
                                            {{ item.nama }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="topsis.idealSolution.length > 0">
                                    <tr>

                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">MAX
                                        </td>

                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(item, index) in topsis.idealSolution" :key="item.id">{{ item }}
                                        </td>

                                    </tr>
                                    <tr>

                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">MIN
                                        </td>

                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800"
                                            v-for="(item, index) in topsis.antiIdealSolution" :key="item.id">{{ item }}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Range Solution -->
            <div class="mt-10 overflow-x-auto" v-if="alternatif.length > 2 && kriteria.length > 0">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">
                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Jarak Solusi
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            -
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            MIN
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            MAX
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="topsis.separationMeasures.length > 0">
                                    <tr v-for="(item, idx) in alternatif" :key="item.id">

                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            item.nama
                                            }}
                                        </td>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            topsis.separationMeasures[idx][1] }}
                                        </td>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            topsis.separationMeasures[idx][0] }}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ideal Solution -->
            <div class="mt-10 overflow-x-auto" v-if="alternatif.length > 2 && kriteria.length > 0">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">
                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <caption>
                                    Tabel Ranking
                                </caption>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Alternatif
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Nilai
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-1 border md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-700 uppercase">
                                            Ranking
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="(item, index, n) in topsis.rank" :key="item.id">
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            index }}
                                        </td>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            item }}
                                        </td>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            n + 1 }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-4 relative box-content" v-else>
            <div class="max-w-7xl mx-auto sm:px-6">
                <!-- <HeaderStats :pengguna="pengguna" :balita="balita" /> -->
                <div class="bg-gradient-to-bl from-orange-700 to-orange-300 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" p-3 flex flex-col justify-center items-center relative">

                        <h1
                            class="w-full mb-5 text-xs sm:text-sm md:text-base lg:text-4xl text-center font-bold !leading-[1.208] text-white z-10">
                            Maaf
                            <span class="text-base-light">Data Lahan Usaha atau Jenis Ikan harus lebih Dari 3 </span>
                        </h1>
                        <div class="w-1/3 bg-center left-1/4 z-0 bg-white rounded-full p-4">
                            <img :src="'/svg/error-page.svg'" alt="dashboard img" class="w-full object-contain" />

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
