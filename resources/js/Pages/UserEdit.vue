<script setup>
import Layout from "@pages/Layout.vue";
import { Link, router } from "@inertiajs/vue3";
import { updateUser } from "@services/UserApi";
import { initializeUserFromProps } from "@services/UserService";
import { defineComponent, defineProps, ref } from "vue";
import { Notyf } from "notyf";
defineComponent({
  Layout,
});
const props = defineProps({
  account: {
    type: Object,
    required: true,
  },
  divisions: {
    type: Array,
    required: true,
  },
  types: {
    type: Array,
    required: true,
  },
});

const user = ref(initializeUserFromProps(props.account));

const errors = ref([]);

const editUser = () => {
  return updateUser(user.value, props.account.id)
    .then((response) => {
      if (response.status === 200) {
        errors.value = [];
        return new Notyf().success("User updated successfully");
      }
    })
    .catch((error) => {
      if (error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
    });
};
</script>

<template>
  <layout>
    <div>
      <div class="card">
        <div
          class="card-header bg-dark justify-content-between align-items-center d-flex"
        >
          <h6 class="card-title py-2 text-white h6 fw-medium">User Details</h6>
        </div>
        <div class="card-body">
          <form method="POST" @submit.prevent="editUser">
            <!-- First Name -->
            <div class="form-group mt-2">
              <label for="first_name" class="form-label required">Firstname</label>
              <input
                type="text"
                class="form-control"
                v-model="user.first_name"
                :class="{ 'is-invalid': errors.hasOwnProperty('first_name') }"
              />
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('first_name')">
                  <span
                    class="text-danger"
                    v-for="error in errors.first_name"
                    :key="error"
                    >{{ error }}</span
                  >
                </div>
              </div>
            </div>

            <!-- Middle Name -->
            <div class="form-group mt-2">
              <label for="middle_name" class="form-label">Middlename</label>
              <input
                type="text"
                class="form-control"
                v-model="user.middle_name"
                :class="{ 'is-invalid': errors.hasOwnProperty('middle_name') }"
              />
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('middle_name')">
                  <span
                    class="text-danger"
                    v-for="error in errors.middle_name"
                    :key="error"
                    >{{ error }}</span
                  >
                </div>
              </div>
            </div>

            <!-- Last Name -->
            <div class="form-group mt-2">
              <label for="last_name" class="form-label required">Lastname</label>
              <input
                type="text"
                class="form-control"
                v-model="user.last_name"
                :class="{ 'is-invalid': errors.hasOwnProperty('last_name') }"
              />
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('last_name')">
                  <span
                    class="text-danger"
                    v-for="error in errors.last_name"
                    :key="error"
                    >{{ error }}</span
                  >
                </div>
              </div>
            </div>

            <!-- Suffix -->
            <div class="form-group mt-2">
              <label for="suffix">Suffix</label>
              <input
                type="text"
                v-model="user.suffix"
                class="form-control"
                :class="{ 'is-invalid': errors.hasOwnProperty('suffix') }"
              />
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('suffix')">
                  <span class="text-danger" v-for="error in errors.suffix" :key="error">{{
                    error
                  }}</span>
                </div>
              </div>
            </div>

            <!-- Username -->
            <div class="form-group mt-2">
              <label for="username" class="form-label required">Username</label>
              <input
                type="text"
                v-model="user.username"
                class="form-control"
                :class="{ 'is-invalid': errors.hasOwnProperty('username') }"
              />
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('username')">
                  <span
                    class="text-danger"
                    v-for="error in errors.username"
                    :key="error"
                    >{{ error }}</span
                  >
                </div>
              </div>
            </div>

            <!-- Password -->
            <div class="form-group mt-2">
              <label for="password" class="form-label">Password</label>
              <input
                type="password"
                class="form-control"
                v-model="user.password"
                :class="{ 'is-invalid': errors.hasOwnProperty('password') }"
              />
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('password')">
                  <span
                    class="text-danger"
                    v-for="error in errors.password"
                    :key="error"
                    >{{ error }}</span
                  >
                </div>
              </div>
            </div>

            <div class="form-group mt-2">
              <!-- Account Type -->
              <label for="account_type" class="form-label required">Account type</label>
              <select
                v-model="user.account_type"
                class="form-control"
                :class="{ 'is-invalid': errors.hasOwnProperty('account_type') }"
              >
                <option :value="type" v-for="type in types" :key="type">
                  {{ type }}
                </option>
              </select>
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('account_type')">
                  <span
                    class="text-danger"
                    v-for="error in errors.account_type"
                    :key="error"
                    >{{ error }}</span
                  >
                </div>
              </div>
            </div>

            <!-- Status -->
            <div class="form-group mt-2">
              <label for="status" class="form-label">Status</label>
              <select
                name="status"
                v-model="user.status"
                :class="{ 'is-invalid': errors.hasOwnProperty('status') }"
                id="status"
                class="form-control"
              >
                <option value="1">Active</option>
                <option value="2">In-active</option>
              </select>
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('status')">
                  <span class="text-danger" v-for="error in errors.status" :key="error">{{
                    error
                  }}</span>
                </div>
              </div>
            </div>

            <!-- Division -->
            <div class="form-group mt-2">
              <label for="division" class="form-label required">Division</label>
              <select
                class="form-control"
                :class="{ 'is-invalid': errors.hasOwnProperty('division') }"
                name="division"
                id="division"
                v-model="user.division"
              >
                <option
                  :value="division.id"
                  v-for="division in divisions"
                  :key="division"
                >
                  {{ division.name }}
                </option>
              </select>
              <div v-auto-animate>
                <div v-if="errors.hasOwnProperty('division')">
                  <span
                    class="text-danger"
                    v-for="error in errors.division"
                    :key="error"
                    >{{ error }}</span
                  >
                </div>
              </div>
            </div>

            <!-- Image File -->
            <p>
              <img
                class="img-thumbnail mt-2"
                :src="`/storage/user-images/${account.profile_picture}`"
                width="200px"
              />
            </p>

            <!-- Submit Button -->
            <div class="d-flex justify-content-between align-items-center mt-4">
              <div>
                <Link
                  href="/account"
                  class="text-decoration-underline text-primary fw-bold"
                  >Back</Link
                >
              </div>
              <div>
                <button
                  type="submit"
                  class="btn btn-success shadow shadow-lg float-end mt-3"
                >
                  Update
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </layout>
</template>
