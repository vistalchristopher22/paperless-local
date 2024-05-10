<script setup>
import Layout from "@pages/Layout.vue";
import { Link, router } from "@inertiajs/vue3";

import { defineComponent, defineProps } from "vue";
defineComponent({
  Layout,
});
const props = defineProps({
  users: {
    type: Object,
    required: true,
  },
  divisions: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <layout>
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div>
        <h5 class="fw-bolder text-uppercase">no. of users [ {{ users.total }} ]</h5>
      </div>
      <div class="">
        <Link href="/account/create" class="btn btn-dark shadow">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-plus-circle me-1"
            viewBox="0 0 16 16"
          >
            <path
              d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
            />
            <path
              d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
            />
          </svg>
          <span class="text-uppercase"> Add New User </span>
        </Link>
      </div>
    </div>
    <table class="table table-hover border" id="users-table">
      <thead>
        <tr class="bg-light">
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Name
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Username
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center text-truncate"
          >
            Role
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Division
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Created At
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Status
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center text-truncate"
          >
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users.data" :key="user">
          <td class="text-start">{{ user.fullname }}</td>
          <td class="text-center">{{ user.username }}</td>
          <td class="text-center">{{ user.account_type }}</td>
          <td class="text-center">{{ user.division_information?.name }}</td>
          <td class="text-center">{{ user.created_at }}</td>
          <td class="text-center">
            <span v-if="user.status === 1" class="badge bg-success text-white"
              >Active</span
            >
            <span v-else class="badge bg-danger text-white">Inactive</span>
          </td>
          <td class="text-center">
            <Link
              class="btn btn-soft-success mx-2"
              title="Edit User"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              data-bs-original-title="Edit User"
              :href="`/account/${user.id}/edit`"
            >
              <i class="mdi mdi-pencil-outline"></i>
            </Link>
            <button
              class="btn btn-soft-danger"
              data-id="{{ $user->id }}"
              title="Remove User"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              data-bs-original-title="Remove User"
            >
              <i class="mdi mdi-account-off-outline"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </layout>
</template>
