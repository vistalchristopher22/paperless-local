<script>
import Layout from "@pages/Layout.vue";
import { Link, useForm, router } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AllFields from "@components/AllFields.vue";
import vSelect from "vue-select";
import axios from "axios";
import moment from "moment";

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
    const model = ref("Edit your content here!");
    const config = ref({
      heightMin: 200,
      placeholderText: "Edit Your Content Here!",
      events: {
        initialized: function () {
          this.html.set(model.value);
        },
        contentChanged: function () {
          model.value = this.html.get();
        },
      },
    });

    const form = ref({
      title: "OB - " + moment().format("YYYY-MM-DD"),
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
          router.visit("/board-sessions");
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
          <label for="title" class="form-label required">Order Business Title</label>
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

        <div class="p-3">
          <label for="file_path" class="form-label">Order Business Content</label>
          <input
            type="file"
            class="form-control"
            @change="onFileAttached"
            :class="{ 'is-invalid': errors.hasOwnProperty('file_path') }"
          />
          <div class="invalid-feedback" v-if="errors.hasOwnProperty('file_path')">
            <span v-for="error in errors.file_path" v-text="error" :key="error"></span>
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
