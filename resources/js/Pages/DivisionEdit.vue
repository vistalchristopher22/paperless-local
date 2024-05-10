<script>
import Layout from "@pages/Layout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { onMounted, reactive, ref } from "vue";
import { Notyf } from "notyf";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AllFields from "@components/AllFields.vue";
import axios from "axios";

export default {
  props: {
    division: {
      type: Object,
      required: true,
    },
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
    const errors = ref({});
    const form = reactive({
      name: props.division.name,
      description: props.division.description,
      board: props.division.board,
    });

    const updateDivision = () => {
      processing.value = true;
      let divisionFormData = new FormData();
      divisionFormData.append("name", form.name);
      divisionFormData.append("description", form.description);
      divisionFormData.append("board", form.board);
      divisionFormData.append("_method", "PUT");

      axios
        .post(`/division/${props.division.id}`, divisionFormData)
        .then((response) => {
          notyf.success("Division updated successfully");
          processing.value = false;
          errors.value = {};
        })
        .catch((error) => {
          if (error.response.status === 422) {
            processing.value = false;

            errors.value = error.response.data.errors || {};
          }
          notyf.error("There was an error updating the division");
        });
      // form.put(`/division/${props.division.id}`, {
      //   onSuccess: () => {
      //     notyf.success("Division updated successfully");
      //   },
      //   onError: () => {
      //     notyf.error("There was an error updating the division");
      //   },
      // });
    };

    return {
      processing,
      form,
      updateDivision,
      errors,
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
      <h6 class="card-title h6 fw-medium text-white">
        Edit Division [ {{ division.name }} ]
      </h6>
    </div>
    <div class="card-body">
      <form @submit.prevent="updateDivision">
        <!-- division name -->
        <div class="mb-3" v-auto-animate>
          <label for="name" class="form-label required">Division Name</label>
          <input
            type="text"
            class="form-control"
            id="name"
            v-model="form.name"
            :class="{ 'is-invalid': errors.name }"
          />
          <small class="text-danger" v-if="errors.hasOwnProperty('name')">{{
            errors.name[0]
          }}</small>
        </div>

        <!-- division description -->
        <div class="mb-3" v-auto-animate>
          <label for="description" class="form-label required"
            >Division Description</label
          >
          <textarea
            class="form-control"
            :class="{ 'is-invalid': errors.description }"
            id="description"
            rows="3"
            v-model="form.description"
          ></textarea>
          <small class="text-danger" v-if="errors.hasOwnProperty('description')">{{
            errors.description[0]
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
            :class="{ 'is-invalid': errors.board }"
            v-model="form.board"
          >
            <option v-for="member in members" :key="member.id" :value="member.id">
              {{ member.fullname }}
            </option>
          </select>
          <small class="text-danger" v-if="errors.board">{{ errors.board }}</small>
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
