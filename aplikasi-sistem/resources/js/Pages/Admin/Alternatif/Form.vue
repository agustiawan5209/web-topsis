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
    ikan:{
        type: Object,
        default: ()=>({}),
    },
    alternatif:{
        type: [Array,Object],
        default: ()=>({}),
    },
})
const Form = useForm({
    nama: '',
    penilaian: [],
});

const JmlAlternatif = ref(1);


const Kriteria = ref(props.kriteria);
const BobotPenilaian = ref([])

onMounted(() => {
    for (let i = 0; i < Kriteria.value.length; i++) {
        const element = Kriteria.value[i];
        BobotPenilaian.value[i] = {
            kriteria: element.id,
            nama: null,
            nilai: null,
        };
    }
})

const NamaIkan = ref(null)

watch(NamaIkan, (value)=>{
    Form.nama = value;
    let Alternatif = [...props.alternatif];
    const data = Alternatif.filter((item, index)=>{
        return item.nama == value;
    })
    const Alternatives = data[0].penilaians;

    for (let i = 0; i < Kriteria.value.length; i++) {
        const element = Kriteria.value[i];
        const namaAl = Alternatives.filter((item, index)=>{
            return item.kriteria_id == element.id;
        })
        BobotPenilaian.value[i] = {
            kriteria: element.id,
            nama: namaAl[0].nama,
            nilai: namaAl[0].nilai,
        };
    }
})


// Submit
function submit() {
    Form.penilaian = BobotPenilaian.value;
    Form.post(route('Alternatif.store.form'), {
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
                    <!-- Alternatif -->
                    <div class="w-full">
                        <InputLabel for="nama" :value="'Nama Jenis Ikan '" class="text-xs sm:text-[15px]" />
                        <select name="ikan" id="ikan" class="w-full border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base placeholder:text-xs" v-model="NamaIkan">
                            <option value="">--Pilih---</option>
                            <option v-for="col in ikan" :value="col"> {{ col }} </option>
                        </select>
                    </div>
                    <!-- Subalternatif -->
                    <div class="grid grid-cols-2 gap-2 bg-gray-100 p-2 border-b border-spacing-12">
                        <div class="col-span-1 " v-for="(item, index) in kriteria" :key="item.id">
                            <InputLabel for="penilaian" :value="item.nama"
                                class="text-xs sm:text-sm leading-4 tracking-wider" />
                            <select name="penilaian"  id="penilaian" class="w-full border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base placeholder:text-xs" v-model="BobotPenilaian[index]">
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
