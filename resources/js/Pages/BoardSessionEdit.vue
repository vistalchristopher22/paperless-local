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
  props: {
    boardSession: {
      required: true,
    },
  },
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
    });

    form.value.title = props.boardSession.title;
    form.value.file_path = props.boardSession.file_path;

    const onFileAttached = (event) => {
      const file = event.target.files[0];
      form.value.file_path = file;
    };

    const submitBoardSession = () => {
      const formData = new FormData();
      formData.append("title", form.value.title);
      formData.append("file_path", form.value.file_path);
      formData.append("_method", "put");

      processing.value = true;
      axios
        .post(`/board-sessions/${props.boardSession.id}`, formData)
        .then((response) => {
          processing.value = false;
          errors.value = {};
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

  <form
    id="orderBusinessForm"
    class="p-0"
    method="POST"
    @submit.prevent="submitBoardSession"
  >
    <div class="form-group">
      <label for="title" class="form-label required text-uppercase fw-bold text-dark"
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

    <div class="form-group mt-3">
      <label for="file_path" class="form-label text-uppercase fw-bold text-dark"
        >File Path</label
      >
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

    <div class="float-end">
      <button type="submit" class="btn btn-success letter-spacing-1 text-uppercase">
        <i class="mdi mdi-send me-2"></i>
        update
      </button>
    </div>
  </form>
</template>
<style scoped></style>
