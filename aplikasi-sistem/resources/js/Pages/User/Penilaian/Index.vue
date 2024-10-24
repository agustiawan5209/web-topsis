<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
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
    console.log(SumKriteria.value)
    sum(props.topsis.alternative_square)
}

const Form = useForm({
    hasil: props.topsis.rank,
})


const ModalShow = ref(false);

function showModal() {
    ModalShow.value = true;
}

function closeModal() {
    ModalShow.value = false
}
function submit() {
    Form.post(route('Datauji.store'), {
        onError: (err) => {
            console.log(err)
        }
    })
}
function ikanKeys() {
    if(props.topsis.rank != null){
        return Object.keys(props.topsis.rank);
    }else{
        return []
    }
}
const ikanRank = ikanKeys()
</script>

<template>

    <Head title="Topsis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hasil Metode Topsis</h2>
        </template>

        <div class="py-4 relative box-content" v-if="alternatif.length > 2">

            <!-- Ranking -->
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
                                            Keterangan
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
                                            item.nilai }}
                                        </td>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            item.teks }}
                                        </td>
                                        <td class="px-2 py-1 text-sm border text-center font-medium text-gray-800">{{
                                            n + 1 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            class="px-2 py-2 bg-secondary text-sm border text-center font-medium text-gray-50">
                                            Berdasarkan Hasil Dari Perankingan
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            class="px-2 py-2 bg-white text-sm border text-center font-medium text-gray-800">
                                            Jenis Ikan Terbaik Yang Dapat Dibudidayakan berdasaran kriteria
                                        </td>
                                        <td class="px-2 py-2 bg-white text-sm border text-center font-medium text-gray-800">
                                            {{ ikanRank[0] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            class="px-2 py-2 bg-white text-sm border text-center font-medium text-gray-800">
                                            Dan Jenis Ikan Yang Kurang Layak untuk Dibudidayakan berdasaran kriteria
                                        </td>
                                        <td class="px-2 py-2 bg-white text-sm border text-center font-medium text-gray-800">
                                            {{ ikanRank.slice(-1)[0] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="my-4 text-center w-full">
                                <PrimaryButton type="button" @click="showModal()">Simpan</PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        <Modal :show="ModalShow">
            <!-- Modal content -->
            <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
                <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" @click="closeModal()">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <p class="mb-4 text-gray-500 ">Simpan Data Penilaian Saat Ini?</p>
                <div class="flex justify-center items-center space-x-4">
                    <button @click="closeModal()" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10">
                        Batalkan
                    </button>
                    <button type="button" @click="submit()" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 ">
                        Simpan
                    </button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
