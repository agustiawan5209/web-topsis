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
    }
})
const Form = useForm({
    slug : props.kriteria.id,
    namakriteria: props.kriteria.nama,
    bobot: props.kriteria.bobot,
    namasubkriteria: [],
    bobotsubkriteria: [],
});

const JmlKriteria = ref(props.kriteria.sub_kriteria.length);

function addJmlKriteria() {
    if (JmlKriteria.value < 5) {
        JmlKriteria.value++;
    }
}


const NamaSubKriteria = ref([])
const BobotSubKriteria = ref([])

const SubKriteria = ref(props.kriteria.sub_kriteria);

onMounted(() => {
    for (let i = 0; i < SubKriteria.value.length; i++) {
        const element = SubKriteria.value[i];
        NamaSubKriteria.value[i] = element.nama;
        BobotSubKriteria.value[i] = element.bobot;

    }
})

function sliceObject(item) {
    JmlKriteria.value -= 1;

    NamaSubKriteria.value.splice(item, 1);
    BobotSubKriteria.value.splice(item, 1);
}


// Submit
function submit() {
    Form.namasubkriteria = NamaSubKriteria.value;
    Form.bobotsubkriteria = BobotSubKriteria.value;
    Form.put(route('Kriteria.update'), {
        preserveScroll: true,
        preserveState: true,
        onError: err => console.log(err),
    })
}
</script>

<template>

    <Head title="Edit Kriteria" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Kriteria</h2>
        </template>

        <div class="py-4 relative box-content flex justify-center">
            <form @submit.prevent="submit()" class="max-w-full p-2 sm:p-5 shadow-sm border border-primary rounded-lg">
                <PrimaryButton type="button" class="mb-4" @click="addJmlKriteria()">Tambah Sub Kriteria++
                </PrimaryButton>
                <template v-if="Form.hasErrors">
                    <ul v-for="item in Form.errors" class="mb-3">
                        <li class="flex items-center gap-4 text-sm pb-2 border-b text-red-500"> <font-awesome-icon
                                :icon="['fas', 'bug']" /> <span>{{ item }}</span> </li>
                    </ul>
                </template>
                <div class="grid grid-cols-4 gap-2 space-y-2">
                    <!-- Kriteria -->
                    <div class="col-span-2">
                        <InputLabel for="namakriteria" :value="'Nama Kriteria '"
                            class="text-xs sm:text-[15px]" />
                        <input id="namakriteria" name="namakriteria" type="text" placeholder="namakriteria Kriteria"
                            class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base"
                            v-model="Form.namakriteria" />
                    </div>
                    <div class="col-span-2">
                        <InputLabel for="bobot" :value="'Bobot Kriteria '"
                            class="text-xs sm:text-[15px]" />
                        <input id="bobot" name="bobot" type="number" placeholder="bobot Kriteria"
                            class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base"
                            v-model="Form.bobot" />
                    </div>
                    <!-- Subkriteria -->
                    <div class="col-span-full bg-gray-100 p-2 border-b border-spacing-12"
                        v-for="(index, item) in JmlKriteria" :key="item">
                        <div class="">
                            <h3 class="col-span-full mb-2">Sub Kriteria {{ index }} </h3>
                            <!-- Nama Sub Kriteria -->
                            <div class="grid grid-cols-7 place-content-center items-center gap-5 ">
                                <div class="col-span-3">
                                    <InputLabel for="namasubkriteria" :value="'Nama sub kriteria'"
                                        class="text-xs sm:text-sm leading-4 tracking-wider" />
                                    <input id="namasubkriteria" name="namasubkriteria" type="text"
                                        placeholder="Nama sub kriteria"
                                        class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base placeholder:text-xs"
                                        v-model="NamaSubKriteria[item]" />
                                </div>
                                <!-- Bobot Sub Kriteria -->
                                <div class="col-span-3">
                                    <InputLabel for="bobotsubkriteria" :value="'Bobot Sub Kriteria'"
                                        class="text-xs sm:text-sm leading-4 tracking-wider" />
                                    <input id="bobotsubkriteria" name="bobotsubkriteria" type="number"
                                        placeholder="Jumlah Bobot Sub Kriteria"
                                        class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base placeholder:text-xs"
                                        v-model="BobotSubKriteria[item]" />
                                </div>
                                <div class="col-span-1">
                                    <PrimaryButton type="button" @click="sliceObject(item)">
                                        <font-awesome-icon :icon="['fas', 'xmark']" class="text-white" />
                                    </PrimaryButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-2 mt-10 mb-2 border-orange-300">
                <PrimaryButton class="block w-full">Simpan</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
