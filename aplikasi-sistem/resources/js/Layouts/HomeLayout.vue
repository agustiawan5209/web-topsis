<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Hero from '@/Components/Header/Hero.vue';
import Layanan from '@/Components/Header/Layanan.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, defineProps, onMounted } from 'vue';
import axios from 'axios';


const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
const Year = new Date().getFullYear()
const Navigate = ref(false);
</script>

<template>

    <nav class="flex items-center justify-between flex-wrap bg-white  z-[1000] shadow-md">
        <div class="flex items-center flex-shrink-0 text-gray-700 mr-6 p-6">
            <span class="font-semibold text-xl tracking-tight">Web-TOPSIS</span>
        </div>
        <div class="block lg:hidden p-6" @click="Navigate = !Navigate">
            <button
                class="flex items-center px-3 py-2 border rounded text-primary border-orange-400 hover:text-gray-700 hover:border-primary">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
        </div>
        <div class="w-full hidden md:block flex-grow lg:flex lg:items-center lg:w-auto">
            <div class="text-sm lg:flex-grow">
                <Link :href="route('home')" :class="route().current('home') ? 'bg-primary text-white hover:text-gray-200' : 'text-primary hover:text-gray-700 border-transparent'"
                    class="p-3 block mt-4 lg:inline-block font-medium lg:mt-0 border  rounded-lg ">
                    <font-awesome-icon :icon="['fas','home']"/>
                Beranda
                </Link>
            </div>
            <div class="flex flex-wrap justify-between gap-4 p-6">
                <Link :href="route('login')"
                    class="inline-block text-sm px-4 py-2 leading-none border rounded text-gray-700 border-primary hover:border-transparent hover:text-white hover:bg-primary mt-4 lg:mt-0">
                Masuk</Link>
                <Link :href="route('register')"
                    class="inline-block text-sm px-4 py-2 leading-none border rounded text-gray-700 border-primary hover:border-transparent hover:text-white hover:bg-primary mt-4 lg:mt-0">
                Daftar</Link>
            </div>
        </div>
        <transition name="fade-left">
            <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto shadow-md border-b" v-if="Navigate">
                <div class="text-sm lg:flex-grow">
                    <Link :href="route('home')" :class="route().current('home') ? 'bg-primary text-white hover:text-gray-200' : 'text-primary hover:text-gray-700 border-transparent'"
                    class="p-3 block mt-4 lg:inline-block font-medium lg:mt-0 border  rounded-lg ">
                    <font-awesome-icon :icon="['fas','home']"/>
                Beranda
                </Link>
                </div>
                <div class="flex flex-wrap justify-between gap-4 p-6 border-t">
                    <Link :href="route('login')"
                        class="inline-block text-sm px-4 py-2 leading-none border rounded text-gray-700 border-primary hover:border-transparent hover:text-primary hover:bg-primary mt-4 lg:mt-0">
                    Masuk</Link>
                    <Link :href="route('register')"
                        class="inline-block text-sm px-4 py-2 leading-none border rounded text-gray-700 border-primary hover:border-transparent hover:text-primary hover:bg-primary mt-4 lg:mt-0">
                    Daftar</Link>
                </div>
            </div>
        </transition>
    </nav>

    <main class="">
        <slot />
    </main>

    <footer class=" divide-y bg-white border-t shadow-2xl">
        <div class="py-6 text-sm text-center bg-gradient-to-tr from-primary to-orange-400">Web-TOPSIS© {{ Year }}. All rights reserved.</div>
    </footer>

</template>

<style scoped>
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.fade-left-enter-active {
    transition: all 0.3s ease-out;
}

.fade-left-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.fade-left-enter-from {
    transform: translateX(-100%);
    opacity: 0;
}

.fade-left-leave-to {
    transform: translateX(100%);
    opacity: 0;
}
</style>
