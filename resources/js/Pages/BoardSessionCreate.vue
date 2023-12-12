<script>
import Layout from "@pages/Layout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AllFields from "@components/AllFields.vue";
import vSelect from "vue-select";
import axios from "axios";

export default {
  props: {},
  layout: Layout,
  components: {
    Link,
    AllFields,
    FullScreenLoader,
    vSelect,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const processing = ref(false);
    const errors = ref({});

    const form = ref({
      title: "",
      file_path: "",
      unassigned_title: "",
      unassigned_business_content: "",
      announcement_title: "",
      announcement_content: "",
    });

    const resetForm = () => {
      form.value.title = "";
      form.value.file_path = "";
      form.value.unassigned_title = "";
      form.value.unassigned_business_content = "";
      form.value.announcement_title = "";
      form.value.announcement_content = "";
    };

    const onFileAttached = (event) => {
      const file = event.target.files[0];
      form.value.file_path = file;
    };

    const submitBoardSession = () => {
      const formData = new FormData();
      formData.append("title", form.value.title);
      formData.append("file_path", form.value.file_path);
      formData.append("unassigned_title", form.value.unassigned_title);
      formData.append(
        "unassigned_business_content",
        form.value.unassigned_business_content
      );
      formData.append("announcement_title", form.value.announcement_title);
      formData.append("announcement_content", form.value.announcement_content);

      processing.value = true;
      axios
        .post("/board-sessions", formData)
        .then((response) => {
          processing.value = false;
          errors.value = {};
          resetForm();
          notyf.success(response.data.message);
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
  <AllFields />
  <div class="card">
    <div
      class="card-header bg-dark justify-content-between p-3 align-items-center d-flex bg-light"
    >
      <h6 class="card-title h6 fw-medium text-white">New Ordered Business</h6>
    </div>
    <div class="card-body p-0">
      <form
        id="orderBusinessForm"
        class="p-0"
        method="POST"
        @submit.prevent="submitBoardSession"
      >
        <div class="px-3 pt-3">
          <label for="title" class="form-label">Order Business Title</label>
          <input
            type="text"
            class="form-control"
            v-model="form.title"
            :class="{ 'is-invalid': errors.hasOwnProperty('title') }"
          />
          <div class="invalid-feedback" v-if="errors.hasOwnProperty('title')">
            <span v-for="error in errors.title" v-text="error"></span>
          </div>
        </div>

        <div class="p-3">
          <label for="file_path" class="form-label">Order Business Content</label>
          <input
            type="file"
            class="form-control"
            @change="onFileAttached"
            :class="{ 'is-invalid': errors.hasOwnProperty('file_path') }"
          />
          <div class="invalid-feedback" v-if="errors.hasOwnProperty('file_path')">
            <span v-for="error in errors.file_path" v-text="error"></span>
          </div>
        </div>

        <div class="p-3 border border-start-0 border-end-0 bg-light">
          <div class="card-title">Unassigned Business</div>
        </div>
        <div class="p-3">
          <div class="d-none mb-3">
            <label for="unassigned_title" class="form-label"
              >Unassigned Business Title</label
            >
            <input
              type="text"
              class="form-control"
              v-model="form.unassigned_title"
              :class="{ 'is-invalid': errors.hasOwnProperty('unassigned_title') }"
            />
            <div
              class="invalid-feedback"
              v-if="errors.hasOwnProperty('unassigned_title')"
            >
              <span v-for="error in errors.unassigned_title" v-text="error"></span>
            </div>
          </div>

          <div class="mb-3">
            <label for="unassigned_business_content" class="form-label"
              >Unassigned Business Content</label
            >
            <textarea
              class="form-control"
              id="unassigned_business_content"
              name="unassigned_business_content"
              rows="8"
              v-model="form.unassigned_business_content"
              :class="{
                'is-invalid': errors.hasOwnProperty('unassigned_business_content'),
              }"
            ></textarea>

            <div
              class="invalid-feedback"
              v-if="errors.hasOwnProperty('unassigned_business_content')"
            >
              <span
                v-for="error in errors.unassigned_business_content"
                v-text="error"
              ></span>
            </div>
          </div>
        </div>

        <div class="p-3 border border-start-0 border-end-0 bg-light">
          <div class="card-title">Announcements</div>
        </div>

        <div class="p-3">
          <div class="d-none mb-3">
            <label for="announcement_title" class="form-label">Announcement Title</label>
            <input
              type="text"
              class="form-control"
              v-model="form.announcement_title"
              :class="{
                'is-invalid': errors.hasOwnProperty('announcement_title'),
              }"
            />
            <div
              class="invalid-feedback"
              v-if="errors.hasOwnProperty('announcement_title')"
            >
              <span v-for="error in errors.announcement_title" v-text="error"></span>
            </div>
          </div>
          <div class="mb-3">
            <label for="announcement_content" class="form-label"
              >Announcement Content</label
            >
            <textarea
              class="form-control"
              id="announcement_content"
              name="announcement_content"
              rows="3"
              v-model="form.announcement_content"
              :class="{
                'is-invalid': errors.hasOwnProperty('announcement_content'),
              }"
            ></textarea>

            <div
              class="invalid-feedback"
              v-if="errors.hasOwnProperty('announcement_content')"
            >
              <span v-for="error in errors.announcement_content" v-text="error"></span>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <Link
            href="/board-sessions"
            class="btn btn-default text-primary text-decoration-underline fw-bold"
            >Back</Link
          >
          <button
            type="submit"
            id="btnSubmit"
            class="btn btn-dark fw-medium float-end mb-2"
          >
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<style scoped></style>
