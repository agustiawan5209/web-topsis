<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { ref, watch, defineProps, onMounted } from 'vue';

</script>

<template>

    <Head title="Petunjuk Penggunaan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Petunjuk Penggunaan</h2>
        </template>

        <div class="bg-gray-100 min-h-screen p-6">
            <!-- Header -->
            <div class="bg-blue-600 text-white p-4 rounded-lg mb-6">
              <h1 class="text-xl font-bold text-center capitalize">SISTEM PENDUKUNG KEPUTUSAN PENENTUAN LAHAN UNTUK BUDIDAYA IKAN AIR TAWAR  MENGGUNAKAN METODE TOPSIS</h1>
            </div>

            <!-- Introduction Section -->
            <section class="bg-white p-6 rounded-lg shadow-lg mb-6">
              <h2 class="text-2xl font-semibold mb-4">Pendahuluan</h2>
              <p>
                Sistem ini menggunakan metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)
                untuk memberikan rekomendasi berdasarkan kriteria yang ditentukan. Berikut adalah petunjuk langkah-langkah
                dalam menggunakan sistem ini.
              </p>
            </section>

            <!-- Step 1: Input Data Section -->
            <section class="bg-white p-6 rounded-lg shadow-lg mb-6">
              <h2 class="text-2xl font-semibold mb-4">Langkah 1: Input Data Alternatif</h2>
              <p>
                Masukkan data alternatif yang ingin Anda gunakan dalam analisis TOPSIS. Seperti Pada Gambar Di Bawah ini:
              </p>
              <ul class="list-disc list-inside ml-4">
                <li> <img src="/images/petunjuk/alternatif-index-0.png" alt="alterntif" width="700"> </li>
                <li><img src="/images/petunjuk/alternatif-form.png" alt="alterntif" width="700"></li>
                <li><img src="/images/petunjuk/alternatif-index-1.png" alt="alterntif" width="700"></li>
              </ul>
            </section>

            <!-- Step 2: Hitung Bobot -->
            <section class="bg-white p-6 rounded-lg shadow-lg mb-6">
              <h2 class="text-2xl font-semibold mb-4">Langkah 2: Proses Penghitungan</h2>
              <p>
                Setelah memasukkan data, sistem akan melakukan penghitungan menggunakan metode TOPSIS untuk:
              </p>
              <ul class="list-decimal list-inside ml-4">
                <li> <img src="/images/petunjuk/rekomendasi-0.png" alt="alterntif" width="700"> </li>

              </ul>
            </section>

            <!-- Step 3: Hasil dan Rekomendasi -->
            <section class="bg-white p-6 rounded-lg shadow-lg mb-6">
              <h2 class="text-2xl font-semibold mb-4">Langkah 3:Menyimpan Hasil dan Rekomendasi</h2>
              <p>
                Sistem akan menampilkan hasil perhitungan dan memberikan peringkat dari alternatif terbaik hingga terburuk.
                Anda dapat menggunakan hasil ini sebagai rekomendasi untuk keputusan yang diinginkan.
              </p>
              <ul class="list-decimal list-inside ml-4">
                <li> <span>Simpan Data Hasil Rekomendasi</span> <br> <img src="/images/petunjuk/rekomendasi-2.png" alt="alterntif" width="700"></li>
                <li> <img src="/images/petunjuk/riwayat-1.png" alt="alterntif" width="700"></li>
                <li> <span>pada kotak merah anda dapat mencari data berdasarkan tanggal</span> <br> <img src="/images/petunjuk/riwayat-0.png" alt="alterntif" width="700"></li>
              </ul>
            </section>

            <!-- Footer -->
            <footer class="text-center mt-10">
              <p class="text-gray-600">© 2024 Sistem Rekomendasi TOPSIS. All rights reserved.</p>
            </footer>
          </div>

    </AuthenticatedLayout>
</template>
