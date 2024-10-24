<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch, defineProps, onMounted } from 'vue';

const props = defineProps({
    kriteria: {
        type: Object,
        default: () => ({})
    },
    ikan: {
        type: [Array, Object],
        default: () => ({})
    }
})
const Form = useForm({
    nama: '',
    penilaian: [],
});

const JmlAlternatif = ref(1);


const Kriteria = ref(props.kriteria);
const BobotPenilaian = ref([])

for (let col = 0; col < props.ikan.length; col++) {
    const item = props.ikan[col];
    BobotPenilaian.value[col] = []
    for (let i = 0; i < Kriteria.value.length; i++) {
        const element = Kriteria.value[i];
        BobotPenilaian.value[col][i] = {
            kriteria: element.id,
            nama: null,
            nilai: null,
        };
    }
}



// Submit
function submit() {
    console.log(BobotPenilaian.value)
    Form.penilaian = BobotPenilaian.value;
    Form.post(route('Alternatif.store'), {
        preserveScroll: true,
        preserveState: true,
        onError: err => console.log(err),
    })
}
</script>

<template>

    <Head title="Tambah Alternatif" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Data Alternatif</h2>
        </template>

        <div class="py-4 relative box-content flex justify-center">
            <form @submit.prevent="submit()" class="w-full p-2 lg:p-5 shadow-sm border border-primary rounded-lg">
                <template v-if="Form.hasErrors">
                    <ul v-for="item in Form.errors" class="mb-3">
                        <li class="flex items-center gap-4 text-sm pb-2 border-b text-red-500"> <font-awesome-icon
                                :icon="['fas', 'bug']" /> <span>{{ item }}</span> </li>
                    </ul>
                </template>
                <div class="flex flex-col w-full gap-2 space-y-2">
                    <table>
                        <thead>
                            <tr>
                                <th class="px-2 py-1 border border-gray-600">Jenis Ikan</th>
                                <th class="px-2 py-1 border border-gray-600" v-for="(item, index) in kriteria"
                                    :key="item.id">{{
                                        item.nama }}</th>
                            </tr>
                        </thead>
                        <tbody v-if="BobotPenilaian">
                            <tr v-for="(col, idx) in ikan" :key="col" :index="idx">
                                <td class="border border-gray-500 p-2"> {{ col }} </td>
                                <td class="border border-gray-500 p-2" v-for="(item, index) in kriteria" :key="item.id">
                                    <select name="penilaian" id="penilaian" required
                                        class="w-full border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base placeholder:text-xs"
                                        v-model="BobotPenilaian[idx][index]">
                                        <option value="">--Pilih---</option>
                                        <option v-for="col in item.sub_kriteria"
                                            :value="{ kriteria: item.id, nama: col.nama, nilai: col.bobot }"> {{ col.nama
                                            }}
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr class="border-2 mt-10 mb-2 border-orange-300">

                <PrimaryButton class="block w-full">Simpan</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
