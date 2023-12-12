<script>
import Layout from "@pages/Layout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AllFields from "@components/AllFields.vue";
import vSelect from "vue-select";

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
    vSelect,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });

    const processing = ref(false);

    const form = useForm({
      title: null,
      chairman: null,
      vice_chairman: null,
      sanggunian: null,
      members: [],
    });

    const createAgenda = () => {
      processing.value = true;
      form.post("/agendas", {
        onSuccess: () => {
          processing.value = false;
          notyf.success("Agenda created successfully.");
        },
        onError: () => {
          processing.value = false;
          notyf.error("Agenda creation failed.");
        },
      });
    };

    return {
      processing,
      form,
      createAgenda,
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
      <h6 class="card-title h6 fw-medium text-white">Create new Chairmanship</h6>
    </div>
    <div class="card-body">
      <form @submit.prevent="createAgenda">
        <div class="form-group">
          <label for="title" class="form-label required">Title</label>
          <input
            type="text"
            name="title"
            id="title"
            class="form-control"
            :class="{ 'is-invalid': form.errors.title }"
            v-model="form.title"
            autocomplete="title"
            autofocus
          />
          <div class="invalid-feedback" v-if="form.errors.title">
            <span v-for="error in form.errors.title" v-text="error" />
          </div>
        </div>

        <div class="form-group mt-3">
          <label for="chairman" class="form-label required">Chairman</label>
          <select
            name="chairman"
            id="chairman"
            class="form-select"
            :class="{ 'is-invalid': form.errors.chairman }"
            v-model="form.chairman"
          >
            <option value="" selected disabled>Select Chairman</option>
            <option
              v-for="member in members"
              :key="member.id"
              :value="member.id"
              v-text="member.fullname"
            />
          </select>
          <div class="invalid-feedback" v-if="form.errors.chairman">
            <span v-for="error in form.errors.chairman" v-text="error" />
          </div>
        </div>

        <div class="form-group mt-3">
          <label for="vice_chairman" class="form-label required">Vice Chairman</label>
          <select
            name="vice_chairman"
            id="vice_chairman"
            class="form-select"
            :class="{ 'is-invalid': form.errors.vice_chairman }"
            v-model="form.vice_chairman"
          >
            <option value="" selected disabled>Select Vice Chairman</option>
            <option
              v-for="member in members"
              :key="member.id"
              :value="member.id"
              v-text="member.fullname"
            />
          </select>
          <div class="invalid-feedback" v-if="form.errors.vice_chairman">
            <span v-for="error in form.errors.vice_chairman" v-text="error" />
          </div>
        </div>

        <!-- sanggunian text input -->
        <div class="form-group mt-3">
          <label for="sanggunian" class="form-label">Sanggunian</label>
          <input
            type="text"
            name="sanggunian"
            id="sanggunian"
            class="form-control"
            :class="{ 'is-invalid': form.errors.sanggunian }"
            v-model="form.sanggunian"
            autocomplete="sanggunian"
            autofocus
          />
          <div class="invalid-feedback" v-if="form.errors.sanggunian">
            <span v-for="error in form.errors.sanggunian" v-text="error" />
          </div>
        </div>

        <div class="form-group mt-3">
          <label class="form-label required" for="members">Members</label>
          <v-select
            class="border rounded"
            :class="{ 'border-danger': form.errors.members }"
            v-model="form.members"
            multiple
            :options="members"
            label="fullname"
            :reduce="(members) => members.id"
          ></v-select>
          <div class="text-danger text-xs" v-if="form.errors.members">
            <span v-for="error in form.errors.members" v-text="error" />
          </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            <Link href="/agendas" class="text-decoration-underline fw-bold text-primary"
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
