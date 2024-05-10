<script>
import Layout from "@pages/Layout.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { Notyf } from "notyf";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AllFields from "@components/AllFields.vue";
import axios from "axios";
import moment from "moment";

export default {
  props: {
    enableRedirect: {
      type: Boolean,
      default: true,
    },
  },
  layout: Layout,
  emits: ["success"],
  components: {
    Link,
    AllFields,
    FullScreenLoader,
  },
  setup(props, { emit }) {
    const notyf = new Notyf({
      duration: 4000,
    });

    const processing = ref(false);
    const errors = ref({});

    const form = ref({
      title: "ORDER OF BUSINESS - " + moment().format("YYYY-MM-DD"),
      file_path: "",
      unassigned_title: "",
      unassigned_business_content: "",
      announcement_title: "",
      announcement_content: "",
    });

    const resetForm = () => {
      form.value.title = "";
      form.value.file_path = "";
    };

    const onFileAttached = (event) => {
      const file = event.target.files[0];
      form.value.file_path = file;
    };

    const submitBoardSession = () => {
      const formData = new FormData();
      formData.append("title", form.value.title);
      formData.append("file_path", form.value.file_path);
      processing.value = true;
      axios
        .post("/board-sessions", formData)
        .then((response) => {
          processing.value = false;
          errors.value = {};
          resetForm();
          notyf.success(response.data.message);
          if (props.enableRedirect) {
            router.visit("/committee#order_of_business", {
              preserveScroll: true,
              preserveState: true,
            });
          }
          emit("success", true);
        })
        .catch((error) => {
          processing.value = false;
          if (error.response.status === 422) {
            errors.value = error.response.data.errors;
          }
          notyf.error(error.response.data.message);
        });
    };

    return {
      processing,
      form,
      errors,
      submitBoardSession,
      onFileAttached,
    };
  },
};
</script>

<template>
  <FullScreenLoader :processing="processing" />
  <div>
    <div
      class="modal fade"
      id="addBoardSessionModal"
      tabindex="-1"
      aria-labelledby="addBoardSessionModalTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5
              class="modal-title text-uppercase letter-spacing-1"
              id="addBoardSessionModalTitle"
            >
              Add New Order of Business
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form
              id="orderBusinessForm"
              class=""
              method="POST"
              @submit.prevent="submitBoardSession"
            >
              <AllFields />

              <div class="form-group">
                <label
                  for="title"
                  class="form-label required text-dark fw-bold text-uppercase"
                  >Order Business Title</label
                >
                <input
                  type="text"
                  class="form-control"
                  v-model="form.title"
                  :class="{ 'is-invalid': errors.hasOwnProperty('title') }"
                />
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('title')">
                  <span v-for="error in errors.title" v-text="error" :key="error"></span>
                </div>
              </div>

              <div class="mt-3">
                <label for="file_path" class="form-label fw-bold text-uppercase text-dark"
                  >File</label
                >
                <input
                  type="file"
                  class="form-control"
                  @change="onFileAttached"
                  :class="{ 'is-invalid': errors.hasOwnProperty('file_path') }"
                />
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('file_path')">
                  <span
                    v-for="error in errors.file_path"
                    v-text="error"
                    :key="error"
                  ></span>
                </div>
              </div>

              <hr />
              <div class="d-flex justify-content-end align-items-center mt-3">
                <div>
                  <button type="submit" class="btn btn-primary text-uppercase">
                    <i class="mdi mdi-send me-2"></i>
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
