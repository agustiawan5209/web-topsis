<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch, defineProps } from 'vue';

const Form = useForm({
    namakriteria: '',
    namasubkriteria: [],
    bobotsubkriteria: [],
});

const JmlKriteria = ref(1);

function addJmlKriteria() {
    if (JmlKriteria.value < 5) {
        JmlKriteria.value++;
    }
}

function submit() {
    Form.post(route('Kriteria.store'), {
        preserveScroll: true,
        preserveState: true,
        onError: err => console.log(err),
    })
}
</script>

<template>

    <Head title="Tambah Kriteria" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Data Kriteria</h2>
        </template>

        <div class="py-4 relative box-content flex justify-center">
            <form @submit.prevent="submit()" class="max-w-full p-2 sm:p-5 shadow-sm border border-primary rounded-lg">
                <PrimaryButton type="button" class="mb-4" @click="addJmlKriteria()">Tambah Sub Kriteria++</PrimaryButton>
                <template v-if="Form.hasErrors">
                    <ul v-for="item in Form.errors" class="mb-3">
                        <li class="flex items-center gap-4 text-sm pb-2 border-b text-red-500"> <font-awesome-icon
                                :icon="['fas', 'bug']" /> <span>{{ item }}</span> </li>
                    </ul>
                </template>
                <div class="grid grid-cols-4 gap-2 space-y-2">
                    <!-- Kriteria -->
                    <div class="col-span-full">
                        <InputLabel for="namakriteria" :value="'Nama Kriteria '"
                            class="text-xs sm:text-[15px]" />
                        <input id="namakriteria" name="namakriteria" type="text" placeholder="namakriteria Kriteria"
                            class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base"
                            v-model="Form.namakriteria" />
                    </div>
                    <!-- Subkriteria -->
                    <div class="col-span-full bg-gray-100 p-2 border-b border-spacing-12"
                        v-for="(index, item) in JmlKriteria" :key="item">
                        <div class="">
                            <h3 class="col-span-full mb-2">Sub Kriteria {{ index }} </h3>
                            <!-- Nama Sub Kriteria -->
                            <div class="grid grid-cols-2 gap-5 ">
                                <div class="">
                                    <InputLabel for="namasubkriteria" :value="'Nama sub kriteria'"
                                        class="text-xs sm:text-sm leading-4 tracking-wider" />
                                    <input id="namasubkriteria" name="namasubkriteria" type="text"
                                        placeholder="Nama sub kriteria"
                                        class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base placeholder:text-xs"
                                        v-model="Form.namasubkriteria[item]" />
                                </div>
                                <!-- Bobot Sub Kriteria -->
                                <div>
                                    <InputLabel for="bobotsubkriteria" :value="'Bobot Sub Kriteria'"
                                        class="text-xs sm:text-sm leading-4 tracking-wider" />
                                    <input id="bobotsubkriteria" name="bobotsubkriteria" type="number" placeholder="Jumlah Bobot Sub Kriteria"
                                        class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-xs sm:text-base placeholder:text-xs"
                                        v-model="Form.bobotsubkriteria[item]" />
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
