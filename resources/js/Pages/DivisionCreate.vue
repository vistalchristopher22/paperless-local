<script>
import Layout from "@pages/Layout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AllFields from "@components/AllFields.vue";

export default {
  props: {
    members: {
      type: Array,
      required: true,
    },
  },
  layout: Layout,
  components: {
    Link,
    AllFields,
    FullScreenLoader,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const processing = ref(false);

    const form = useForm({
      name: "",
      description: "",
      board: "",
    });

    const createDivision = () => {
      processing.value = true;
      form.post("/division", {
        onSuccess: () => {
          notyf.success("Division created successfully");
          processing.value = false;
        },
        onError: () => {
          notyf.error("There was an error creating the division");
          processing.value = false;
        },
      });
    };

    return {
      processing,
      form,
      createDivision,
    };
  },
};
</script>

<template>
  <FullScreenLoader :processing="processing" />
  <AllFields />
  <div class="card">
    <div
      class="card-header bg-dark justify-content-between p-3 align-items-center d-flex bg-light"
    >
      <h6 class="card-title h6 fw-medium text-white">New Division Form</h6>
    </div>
    <div class="card-body">
      <form @submit.prevent="createDivision">
        <!-- division name -->
        <div class="mb-3" v-auto-animate>
          <label for="name" class="form-label required">Division Name</label>
          <input
            type="text"
            class="form-control"
            id="name"
            v-model="form.name"
            :class="{ 'is-invalid': form.errors.name }"
          />
          <small class="text-danger" v-if="form.errors.name">{{
            form.errors.name
          }}</small>
        </div>

        <!-- division description -->
        <div class="mb-3" v-auto-animate>
          <label for="description" class="form-label required"
            >Division Description</label
          >
          <textarea
            class="form-control"
            :class="{ 'is-invalid': form.errors.description }"
            id="description"
            rows="3"
            v-model="form.description"
          ></textarea>
          <small class="text-danger" v-if="form.errors.description">{{
            form.errors.description
          }}</small>
        </div>

        <!-- division chief -->
        <div class="mb-3" v-auto-animate>
          <label for="chief" class="form-label required"
            >Division Board Member/Chief</label
          >
          <select
            class="form-select"
            id="chief"
            aria-label="Select Division Board Member / Chief"
            :class="{ 'is-invalid': form.errors.board }"
            v-model="form.board"
          >
            <option v-for="member in members" :key="member.id" :value="member.id">
              {{ member.fullname }}
            </option>
          </select>
          <small class="text-danger" v-if="form.errors.board">{{
            form.errors.board
          }}</small>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            <Link href="/division" class="text-decoration-underline fw-bold text-primary"
              >Back</Link
            >
          </div>

          <div>
            <button type="submit" class="btn btn-dark shadow">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<style scoped></style>
