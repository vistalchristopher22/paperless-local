<script setup>
import Layout from './Layout.vue';

import {defineComponent, reactive, ref} from "vue";
import {Link, router} from "@inertiajs/vue3";
import moment from "moment";
import {Notyf} from "notyf";

defineComponent({
    components: {
        Layout
    }
});
defineProps({
    types: {
        type: Object,
        required: true
    }
});

const notyf = new Notyf({
    duration: 4000,
    position: {
        x: 'right',
        y: 'bottom',
    }
});


const formVisible = ref(false);

const type = reactive({
    name: '',
});

const errors = ref([]);

const closeForm = () => {
    formVisible.value = false;
    errors.value = [];
}

const submitType = () => {
    type.processing = true;
    const data = new FormData();
    data.append('name', type.name);
    data.append('id', type.id);
    if (type.id) {
        const record = new FormData();
        record.append('name', type.name);
        record.append('id', type.id);
        record.append('_method', 'PUT');
        axios.post(`/types/${type.id}`, record).then((_) => {
            errors.value = [];
            type.processing = false;
            notyf.success('Legislation Type Updated Successfully');
            router.visit('/types', {
                preserveScroll: true,
                preserveState: true
            });
        }).catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
                type.processing = false;
            }
        });
    } else {
        axios.post(`/types`, data).then((_) => {
            type.name = '';
            errors.value = [];
            type.processing = false;
            notyf.success('Legislation Type Added Successfully');
            router.visit('/types', {
                preserveScroll: true,
                preserveState: true
            });
        }).catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
                type.processing = false;
            }
        });
    }
}

const editType = (data) => {
    formVisible.value = true;
    type.id = data.id;
    type.name = data.name;
}

const deleteType = (data) => {
    alertify.confirm('Delete Legislation Type', 'Are you sure you want to delete this record?', function () {
            axios.delete(`/types/${data.id}`).then((_) => {
                notyf.success('Legislation Type Deleted Successfully');
                router.visit('/types', {
                    preserveScroll: true,
                    preserveState: true
                });
            });
        }
        , function () {
        });
}
</script>

<template>
    <layout>
        <div class="row">

            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-header p-0 d-flex justify-content-between align-items-center">
                        <div class="">
                            <h5 class="fw-bolder text-uppercase">
                                Legislation Types [ {{ types.total }} ]
                            </h5>
                        </div>
                        <div>
                            <button @click="formVisible = true" class="btn btn-dark fw-medium text-uppercase">
                                <i class="mdi mdi-plus-circle-outline"></i>
                                Add New
                                Legislation Type
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-12" v-if="formVisible">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h6 class="text-uppercase text-white">Legislation Type Form</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" @submit.prevent="submitType">
                                    <div class="form-group
                            ">
                                        <label for="name">Name</label>
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            autofocus
                                            id="name"
                                            v-model="type.name"
                                            :class="{ 'is-invalid': errors.name }"
                                            placeholder="Enter new Legislation Name"
                                        />
                                        <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                                        <div class="form-group float-end mt-2">
                                            <button class="btn btn-warning me-1" @click="closeForm">Close</button>

                                            <input type="submit" class="btn btn-dark" :disabled="type.processing"
                                                   value="Submit">

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table border">
                            <thead>
                            <tr class="bg-dark">
                                <th
                                    class=" text-white bg-dark border border-dark text-uppercase text-center"
                                >
                                    Name
                                </th>
                                <th class="border text-white bg-dark  border-dark text-uppercase text-center">
                                    Created At
                                </th>
                                <th class="border text-white bg-dark  border-dark text-uppercase text-center">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="type in types.data" :key="type">
                                <td class="text-start text-uppercase w-25">
                                    <span class="me-5">{{ type.name }}</span>
                                </td>
                                <td class="text-center">{{ moment(type.updated_at).format('MM/DD/YYYY hh:mm A') }}</td>
                                <td class="text-center">
                                    <a
                                        @click="editType(type)"
                                        class="btn btn-soft-success mx-1"
                                        title="Edit Agenda"
                                    >
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    <a
                                        @click="deleteType(type)"
                                        class="btn btn-soft-danger"
                                        title="Edit Agenda"
                                    >
                                        <i class="mdi mdi-trash-can-outline"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="float-end">
                            <ul class="pagination">
                                <li class="page-item" v-for="(link, k) in types.links" :key="k">
                                    <div v-if="link.url === null" class="page-link">...</div>
                                    <Link
                                        v-else
                                        class="page-link"
                                        :class="{ 'bg-primary text-white': link.active }"
                                        :href="`${link.url}`"
                                        preserve-scroll
                                        v-html="link.label"
                                    >
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </layout>
</template>
