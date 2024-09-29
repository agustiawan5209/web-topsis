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
    alternatif: {
        type: Object,
        default: () => ({})
    }
})
const Form = useForm({
    slug: props.alternatif.id,
    nama: props.alternatif.nama,
    penilaian: [],
});

const JmlAlternatif = ref(1);


const Kriteria = ref(props.kriteria);
const BobotPenilaian = ref([])

onMounted(() => {
    for (let i = 0; i < Kriteria.value.length; i++) {
        const element = Kriteria.value[i];
        const penilaian = props.alternatif.penilaians;

        BobotPenilaian.value[i] = {
            kriteria: element.id,
            nama: penilaian[i].nama,
            nilai: penilaian[i].nilai,
        };
    }
})



// Submit
function submit() {
    Form.penilaian = BobotPenilaian.value;
    Form.put(route('Alternatif.update'), {
        preserveScroll: true,
        preserveState: true,
        onError: err => console.log(err),
    })
}
</script>

<template>

    <Head title="Edit Alternatif" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Alternatif</h2>
        </template>

        <div class="py-4 relative box-content flex justify-center">
            <form @submit.prevent="submit()" class="max-w-full p-2 sm:p-5 shadow-sm border border-primary rounded-lg">
                <template v-if="Form.hasErrors">
                    <ul v-for="item in Form.errors" class="mb-3">
                        <li class="flex items-center gap-4 text-sm pb-2 border-b text-red-500"> <font-awesome-icon
                                :icon="['fas', 'bug']" /> <span>{{ item }}</span> </li>
                    </ul>
                </template>
                <div class="flex flex-col w-full gap-2 space-y-2">
                    <!-- Alternatif -->
                    <div class="w-full">
                        <InputLabel for="nama" :value="'Nama Jenis Ikan '" class="text-xs sm:text-[15px]" />
                        <select name="nama" id="nama" v-model="Form.nama" class="w-full border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base">
                            <option value="">--------</option>
                            <option value="Ikan Lele">Ikan Lele</option>
                            <option value="Ikan Gurame">Ikan Gurame</option>
                            <option value="Ikan Patin">Ikan Patin</option>
                            <option value="Ikan Mujair">Ikan Mujair</option>
                        </select>
                    </div>
                    <!-- Subalternatif -->
                    <div class="grid grid-cols-2 gap-2 bg-gray-100 p-2 border-b border-spacing-12">
                        <div class="col-span-1 " v-for="(item, index) in kriteria" :key="item.id">
                            <InputLabel for="penilaian" :value="item.nama"
                                class="text-xs sm:text-sm leading-4 tracking-wider" />
                            <select name="penilaian" id="penilaian" class="w-full border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base placeholder:text-xs" v-model="BobotPenilaian[index]">
                                <option value="">--Pilih---</option>
                                <option v-for="col in item.sub_kriteria" :value="{kriteria: item.id, nama:col.nama, nilai: col.bobot}"> {{ col.nama }} </option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="border-2 mt-10 mb-2 border-orange-300">

                <PrimaryButton class="block w-full">Simpan</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
