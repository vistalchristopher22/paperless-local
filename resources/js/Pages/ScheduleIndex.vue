<script>
import { ref, reactive, computed, watch } from "vue";
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import axios from "axios";
export default {
  layout: Layout,
  components: {
    FullScreenLoader,
    Link,
  },
  props: {
    venues: {
      required: true,
    },
    upcomingSessions: {
      required: true,
    },
    regularSessions: {
      required: true,
    },
    scheduleTypes: {
      required: true,
    },
    ScheduleType: {
      required: true,
    },
  },
  setup(props) {
    const form = useForm({
      name: "",
    });
    const errors = ref({});
    const processing = ref(false);

    const submitNewVenue = () => {
      processing.value = true;

      let formData = new FormData();
      formData.append("name", form.data().name);

      axios
        .post("/venue", formData)
        .then((response) => {
          processing.value = false;
          if (response.data.success) {
            errors.value = {};
            form.reset();
            new Notyf().success("Venue created successfully.");
          }
        })
        .catch((error) => {
          processing.value = false;
          errors.value = error.response.data.errors;
          new Notyf().error("Something went wrong.");
        });
    };

    return {
      submitNewVenue,
      form,
      errors,
      processing,
    };
  },
};
</script>
<template>
  <div>
    <FullScreenLoader :processing="processing" />
    <div
      class="modal fade"
      id="addVenueModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addVenueModalTitle"
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
            <!--end modal-header-->
            <div class="modal-body">
              <div class="row">
                <!--end col-->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-label required">Name</label>
                    <input
                      type="text"
                      class="form-control"
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
                <!--end col-->

                <div class="col-lg-12">
                  {{ venues }}
                </div>
              </div>
              <!--end row-->
            </div>
            <!--end modal-body-->
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
            <!--end modal-footer-->
          </div>
        </form>

        <!--end modal-content-->
      </div>
      <!--end modal-dialog-->
    </div>

    <div class="card mt-3">
      <div
        class="card-header bg-dark d-flex flex-row justify-content-between align-items-center"
      >
        <div class="card-title text-white fw-medium">Schedules</div>
        <div>
          <button
            class="btn btn-light fw-medium"
            data-bs-toggle="modal"
            data-bs-target="#addVenueModal"
          >
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
            Add New Venue
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="p-2">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</template>
<style></style>
