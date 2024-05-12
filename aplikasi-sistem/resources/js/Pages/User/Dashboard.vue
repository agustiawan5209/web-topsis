<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ChartPertumbuhanPengguna from '@/Components/Chart/ChartPertumbuhanPengguna.vue';
import CardCalendar from '@/Components/Card/CardCalendar.vue';
import ChartJumlah from '@/Components/Chart/ChartJumlah.vue';
import HeaderStats from '@/Components/Header/HeaderStats.vue';
import { defineProps } from "vue";

const props = defineProps({
    pengguna: Number,

});
</script>

<template>

    <Head title="Dashboard Orang Tua" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Orang Tua</h2>
        </template>

        <div class="py-4 relative box-content">
            <div class="max-w-7xl mx-auto sm:px-6">
                <!-- <HeaderStats :pengguna="pengguna" :balita="balita" /> -->
                <div class="bg-gradient-to-bl from-primary to-orange-300 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" p-3 flex justify-center items-center relative">
                        <div class="w-1/3 bg-center left-1/4 z-0 bg-white rounded-full p-4">
                            <img :src="'/svg/computer.svg'" alt="dashboard img" class="w-full object-contain" />

                        </div>
                        <h1
                            class="w-full mb-5 text-xs sm:text-sm md:text-base lg:text-4xl text-center font-bold !leading-[1.208] text-white z-10">
                            Selamat Datang Di
                            <span class="text-base-light">Sistem Pendukung Keputusan </span>
                            Web-TOPSIS.
                        </h1>


                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
