<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import axios from "axios";

const props = defineProps({
  venues: Array,
});
const errors = ref([]);
const form = useForm({
  name: "",
});

const submitNewVenue = () => {
  let formData = new FormData();
  formData.append("name", form.data().name);
  axios
    .post("/venue", formData)
    .then((response) => {
      if (response.data.success) {
        errors.value = {};
        form.reset();
        new Notyf().success("Venue created successfully.");
        response.data.data.new_created = true;
        props.venues.push(response.data.data);
      }
    })
    .catch((error) => {
      if (error.response.status === 422) {
        errors.value = error.response.data.errors;
      } else {
        new Notyf().error("Something went wrong.");
      }
    });
};
</script>
<template>
  <div>
    <div
      class="modal fade"
      id="addVenueModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addVenueModalTitle"
      aria-modal="true"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <form @submit.prevent="submitNewVenue" method="POST">
          <div class="modal-content">
            <div class="modal-header bg-dark">
              <h6 class="modal-title m-0" id="addVenueModalTitle">Create New Venue</h6>
              <button
                type="button"
                class="btn-close text-white"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group" v-auto-animate>
                    <label class="form-label text-uppercase fw-bold text-dark"
                      >Name</label
                    >
                    <input
                      type="text"
                      class="form-control form-control-lg"
                      v-model="form.name"
                      :class="{ 'is-invalid': errors?.hasOwnProperty('name') }"
                    />
                    <span
                      class="text-danger tex-xs"
                      v-if="errors.hasOwnProperty('name')"
                      >{{ errors?.name[0] }}</span
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary me-1">Submit</button>
              <button
                type="button"
                class="btn btn-soft-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
