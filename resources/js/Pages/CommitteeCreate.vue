<script>
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link } from "@inertiajs/vue3";
import { ref, watch, reactive } from "vue";
import AllFields from "@components/AllFields.vue";
import vSelect from "vue-select";
import { Notyf } from "notyf";

export default {
  props: {
    agendas: {
      required: true,
    },
  },
  layout: Layout,
  components: {
    vSelect,
    Link,
    FullScreenLoader,
    AllFields,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const processing = ref(false);
    const errors = ref({});
    const committee = reactive({
      name: "",
      lead_committee: "",
      expanded_committee: [],
      file: "",
    });

    const resetFormData = () => {
      committee.name = "";
      committee.lead_committee = "";
      committee.expanded_committee = [];
      committee.file = "";
    };

    const submitCommitteeForm = () => {
      let formData = new FormData();
      formData.append("name", committee.name);
      formData.append("lead_committee", committee.lead_committee);
      formData.append("expanded_committee", JSON.stringify(committee.expanded_committee));
      formData.append("file", committee.file);

      processing.value = true;

      axios
        .post("/committee", formData)
        .then((response) => {
          if (response.status === 200) {
            errors.value = {};
            processing.value = false;
            notyf.success(response.data.message);
            resetFormData();
          }
        })
        .catch((error) => {
          processing.value = false;
          errors.value = error.response.data.errors;
        });
    };

    const onFileAttached = (event) => (committee.file = event.target.files[0]);

    watch(committee, (value) => {
      let selectedLeadCommittee = props.agendas.find(
        (agenda) => agenda.id === value.lead_committee
      );
      if (selectedLeadCommittee) {
        committee.name = selectedLeadCommittee.title
          ?.toLowerCase()
          ?.replace("committee on", "")
          ?.trim();
      }
    });

    return {
      processing,
      committee,
      errors,
      submitCommitteeForm,
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
      <h6 class="card-title h6 fw-medium text-white">New Committee Form</h6>
    </div>
    <div class="card-body">
      <form
        @submit.prevent="submitCommitteeForm"
        method="POST"
        enctype="multipart/form-data"
      >
        <div class="form-group" v-auto-animate>
          <label for="name" class="form-label required">Name</label>
          <input
            id="name"
            type="text"
            class="form-control text-capitalize"
            :class="{ 'is-invalid': errors?.name }"
            name="name"
            v-model="committee.name"
          />

          <span class="text-danger text-xs" v-if="errors?.name">
            {{ errors?.name[0] }}
          </span>
        </div>

        <div class="form-group mt-3">
          <label for="lead_committee" class="form-label required">Lead Committee</label>
          <div>
            <v-select
              class="border text-uppercase"
              :options="agendas"
              v-model="committee.lead_committee"
              :class="{ 'outline-none border-danger rounded': errors?.lead_committee }"
              label="title"
              :reduce="(agendas) => agendas.id"
            >
              <template #option="{ title, chairman_information }">
                <div class="d-flex my-3 align-items-center justify-content-start">
                  <div>
                    <img
                      class="img-fluid rounded"
                      :src="`/storage/user-images/${chairman_information.profile_picture}`"
                      style="width: 3vw"
                    />
                  </div>
                  <div class="d-flex flex-column ms-2">
                    <strong>{{ title }}</strong>
                    <span>{{ chairman_information.fullname }}</span>
                  </div>
                </div>
              </template>
            </v-select>

            <span class="text-danger text-xs" v-if="errors?.lead_committee">
              {{ errors?.lead_committee[0] }}
            </span>
          </div>
        </div>

        <div class="form-group mt-3">
          <label for="expanded_committee" class="form-label">Expanded Committee</label>
          <div>
            <v-select
              class="border text-uppercase"
              :options="agendas"
              label="title"
              :multiple="true"
              v-model="committee.expanded_committee"
              :reduce="(agendas) => agendas.id"
            >
              <template #option="{ title, chairman_information }">
                <div class="d-flex my-3 align-items-center justify-content-start">
                  <div>
                    <img
                      class="img-fluid rounded"
                      :src="`http://localhost:8001/storage/user-images/${chairman_information.profile_picture}`"
                      style="width: 3vw"
                    />
                  </div>
                  <div class="d-flex flex-column ms-2">
                    <strong>{{ title }}</strong>
                    <span>{{ chairman_information.fullname }}</span>
                  </div>
                </div>
              </template>
            </v-select>
          </div>
        </div>

        <div class="form-group mt-3">
          <label for="file" class="form-label">File</label>
          <input
            type="file"
            name="file"
            id="file"
            class="form-control"
            @change="onFileAttached"
          />
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            <Link
              class="text-decoration-underline text-primary fw-bolder"
              href="/committee"
              >Back</Link
            >
          </div>
          <div>
            <button type="submit" class="btn btn-dark btn-md shadow-dark">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped></style>
