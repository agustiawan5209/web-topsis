<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import { ref, watch, defineProps, inject, defineExpose, onMounted } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';

const swal = inject('$swal')
const props = defineProps({
    search: {
        type: String,
        default: '',
    },
    order: {
        type: String,
        default: '',
    },
    data: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
    ikan: {
        type: Object,
        default: () => ({}),
    },
    kriteria: {
        type: Object,
        default: () => ({}),
    },
})
const crud = ref({
    tambah: props.can.add,
    edit: props.can.edit,
    show: props.can.show,
    delete: props.can.delete,

})

function cekAksi() {
    if (crud.value.tambah || crud.value.edit || crud.value.show || crud.value.delete) {
        return true;
    } else {
        return false;
    }
}
const page = usePage()

onMounted(() => {
    if (page.props.message !== null) {
        swal({
            icon: "success",
            title: 'Berhasil',
            text: page.props.message,
            showConfirmButton: true,
            timer: 2000
        }).then(() => {
            page.props.message = null;
        });
    }
})

const search = ref('')
const order = ref('')

const Form = useForm({
    search: search.value,
    order: order.value,
})

watch(search, (value) => {
    Form.search = value;
    Form.get(route('Alternatif.index'), {
        preserveState: true,
        preserveScroll: true,
    })
    // ColumData.value = ref(props.TableData.data);
})
watch(order, (value) => {
    Form.order = value;
    Form.get(route('Alternatif.index', {}), {
        preserveState: true,
        preserveScroll: true,
    })
    // ColumData.value = ref(props.TableData.data);
})


// Modal Delete
const VarDeleteModal = ref(false);
const DeleteForm = useForm({
    slug: null,
    title: null,
})

function showDeleteModal(item) {

    DeleteForm.slug = item.id;
    DeleteForm.title = item.nama ?? item.name;
    VarDeleteModal.value = true;
}

function deleteItem() {
    DeleteForm.delete(route('Alternatif.destroy'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            VarDeleteModal.value = false;
            DeleteForm.reset('slug');
            swal({
                icon: "success",
                title: 'Berhasil',
                text: page.props.message,
                showConfirmButton: true,
                timer: 2000
            });
        }
    })
}


function truncateText(text) {
    var paragraphs = text
    var text = '';
    var paragraph = ''
    for (var i = 0; i < paragraphs.length; i++) {
        if (i < 100) {
            text += paragraphs[i]
        }
    }
    text += '........'
    return text;
}
</script>

<template>

    <Head title="Alternatif " />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Alternatif</h2>
        </template>

        <div class="py-4 relative box-content">

            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border rounded-lg divide-y divide-gray-200">
                        <div class="py-3 px-4" v-if="crud.tambah && data.data.length < ikan.length">
                            <div class="relative max-w-xs">
                                <Link :href="route('Alternatif.create')">
                                <PrimaryButton type="button">Tambah Data</PrimaryButton>
                                </Link>
                            </div>
                        </div>
                        <div class="py-3 px-4 flex justify-between">
                            <div class="relative max-w-xs">
                                <label class="sr-only">Search</label>
                                <input type="search" name="hs-table-with-pagination-search"
                                    id="hs-table-with-pagination-search" v-model="search"
                                    class="pl-2 py-1 md:pl-8 md:py-2 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Cari Data.........">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                    <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="relative max-w-xs flex items-center gap-2">
                                <label class="capitalize text-xs md:text-sm">Urutkan</label>

                                <select id="order" v-model="order"
                                    class="px-2 py-1 md:px-3 md:py-2 placeholder-gray-400 border focus:outline-none sm:w-40 sm:text-sm border-gray-200 shadow-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none ">
                                    <option value="">-----</option>
                                    <option value="desc">Terbaru</option>
                                    <option value="asc">Terlama</option>
                                </select>
                                <div class="absolute inset-y-0 end-3 flex items-center pointer-events-none ps-3">
                                    <font-awesome-icon :icon="['fas', 'filter']" class="text-gray-400" />
                                </div>
                            </div>
                        </div>
                        <div class=" w-full overflow-x-auto ">
                            <table class="w-full divide-y divide-gray-200">
                                <colgroup>
                                    <col>
                                    <col class="w-32">
                                </colgroup>
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-500 uppercase">
                                            <span>
                                                No.
                                            </span>
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-500 uppercase">
                                            <span>
                                               Jenis Ikan
                                            </span>
                                        </th>
                                        <th scope="col" v-for="col in kriteria"
                                            class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start text-xs font-medium text-gray-500 uppercase">
                                            <span>
                                               {{ col.nama }}
                                            </span>
                                        </th>

                                        <th scope="col" v-if="cekAksi()"
                                            class=" px-2 py-1 md:px-6 md:py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="data.data.length > 0">
                                    <tr v-for="(item, index) in data.data" :key="item.id"
                                        :class="{ 'opacity-75 blur-sm': Form.processing }">
                                        <td class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800">
                                            {{ (data.current_page - 1) * data.per_page + index + 1 }}

                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800">
                                            {{ item.nama }}

                                        </td>
                                        <td class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800" v-for="col in item.penilaians">
                                            {{ col.nama }}

                                        </td>

                                        <td class="px-2 py-1 md:px-6 md:py-3 whitespace-nowrap text-end text-sm font-medium"
                                            v-if="cekAksi()">
                                            <!-- Settings Dropdown -->
                                            <div class="ml-3">
                                                <Dropdown align="top" width="48">
                                                    <template #trigger>
                                                        <span class="inline-flex rounded-md">
                                                            <button type="button"
                                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                                Aksi

                                                                <font-awesome-icon :icon="['fas', 'ellipsis-vertical']"
                                                                    class="ml-2 -mr-0.5 h-4 w-4" />

                                                            </button>
                                                        </span>
                                                    </template>

                                                    <template #content>
                                                        <DropdownLink v-if="crud.edit"
                                                            :href="route('Alternatif.edit', { slug: item.id })"
                                                            class="flex justify-start gap-3">
                                                            <font-awesome-icon
                                                                class="text-orange-500 hover:text-orange-700"
                                                                :icon="['fas', 'pen-to-square']" />
                                                            Edit
                                                        </DropdownLink>
                                                        <DropdownLink v-if="crud.show"
                                                            :href="route('Alternatif.show', { slug: item.id })"
                                                            class="flex justify-start gap-3">
                                                            <font-awesome-icon class="text-blue-500 hover:text-blue-700"
                                                                :icon="['fas', 'eye']" />
                                                            Detail
                                                        </DropdownLink>
                                                        <button type="button" v-if="crud.delete"
                                                            @click="showDeleteModal(item)"
                                                            class="flex justify-start gap-3 w-full px-4 py-1 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                            <font-awesome-icon class="text-red-500 hover:text-red-700"
                                                                :icon="['fas', 'trash-can']" />
                                                            hapus
                                                        </button>


                                                        <DropdownLink v-if="crud.reset_password"
                                                            :href="route('Alternatif.reset.password', { slug: item.user.id })"
                                                            class="flex justify-start gap-3">
                                                            <font-awesome-icon class="text-blue-500 hover:text-blue-700"
                                                                :icon="['fas', 'key']" />
                                                            Reset Password
                                                        </DropdownLink>
                                                    </template>
                                                </Dropdown>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td :colspan="4" class="p-5 text-gray-400 text-center">Data Kosong</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="py-1 px-4 ">
                            <div class="flex flex-wrap">
                                <template v-for="(link, key) in data.links">
                                    <div v-if="link.url === null" :key="key"
                                        class="mb-1 mr-1 px-4 py-3  text-gray-400 text-sm leading-4 border rounded"
                                        v-html="link.label" />
                                    <Link v-else :key="`link-${key}`"
                                        class="mb-1 mr-1 px-4 py-3 focus:text-primary text-sm leading-4 active:border-primary hover:bg-red-200 border focus:border-primary rounded"
                                        :class="{ 'bg-white border-secondary text-black': link.active }" preserve-state
                                        preserve-scroll :data="{ search, order }" :href="link.url"
                                        v-html="link.label" />
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="VarDeleteModal">
            <div class="flex flex-col max-w-full gap-2 p-6 rounded-md shadow-md bg-gray-50 text-gray-800">
                <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="w-6 h-6 fill-current shrink-0 text-orange-600">
                        <path
                            d="M451.671,348.569,408,267.945V184c0-83.813-68.187-152-152-152S104,100.187,104,184v83.945L60.329,348.568A24,24,0,0,0,81.432,384h86.944c-.241,2.636-.376,5.3-.376,8a88,88,0,0,0,176,0c0-2.7-.135-5.364-.376-8h86.944a24,24,0,0,0,21.1-35.431ZM312,392a56,56,0,1,1-111.418-8H311.418A55.85,55.85,0,0,1,312,392ZM94.863,352,136,276.055V184a120,120,0,0,1,240,0v92.055L417.137,352Z">
                        </path>
                        <rect width="32" height="136" x="240" y="112"></rect>
                        <rect width="32" height="32" x="240" y="280"></rect>
                    </svg>
                    <span>Apakah anda yakin ingin menghapus {{ DeleteForm.title }}</span>
                </h2>
                <!-- <p class="flex-1 text-gray-600">Mauris et lorem at elit tristique dignissim et ullamcorper elit. In sed feugiat mi. Etiam ut lacinia dui.</p> -->
                <div class="flex flex-col justify-end gap-3 mt-6 sm:flex-row">
                    <button class="px-6 py-2 rounded-sm" @click="VarDeleteModal = false">Tidak</button>
                    <button class="px-6 py-2 rounded-sm shadow-sm bg-orange-600 text-gray-50"
                        @click="deleteItem()">Ya</button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
