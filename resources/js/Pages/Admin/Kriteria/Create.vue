<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch, defineProps } from 'vue';

const Form = useForm({
    nama: [],
    bobot: [],
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
            <form @submit.prevent="submit()" class="max-w-xl p-5 shadow-sm border border-primary rounded-lg">
                <PrimaryButton type="button" class="mb-4" @click="addJmlKriteria()">Tambah Kriteria++</PrimaryButton>
                <template v-if="Form.hasErrors">
                    <ul v-for="item in Form.errors" class="mb-3">
                        <li class="flex items-center gap-4 text-sm pb-2 border-b text-red-500"> <font-awesome-icon :icon="['fas', 'bug']"/> <span>{{ item }}</span> </li>
                    </ul>
                </template>
                <div class="grid grid-cols-2 gap-2 mb-8 border-b border-spacing-12" v-for="(index, item) in JmlKriteria"
                    :key="item">
                    <div class="">
                        <InputLabel for="nama" :value="'Nama Kriteria ' + (index)"
                            class="text-[15px] leading-4 tracking-wider" />
                        <input id="nama" name="nama" type="text" placeholder="Nama Kriteria"
                            class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm"
                            v-model="Form.nama[item]" />
                    </div>
                    <div>
                        <InputLabel for="bobot" :value="'Bobot Kriteria ' + (index)" class="text-[15px] leading-4 tracking-wider" />
                        <input id="bobot" name="bobot" type="number" placeholder="Jumlah Bobot Kriteria"
                            class="border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm"
                            v-model="Form.bobot[item]" />
                    </div>
                </div>
                <hr class="border-2 mt-10 mb-2 border-orange-300">
                <PrimaryButton class="block w-full">Simpan</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
