<script>
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link, router } from "@inertiajs/vue3";
import { reactive, ref, watch, watchEffect } from "vue";
import AllFields from "@components/AllFields.vue";
import vSelect from "vue-select";
import { Notyf } from "notyf";

export default {
  components: {
    vSelect,
    Link,
    FullScreenLoader,
    AllFields,
  },
  layout: Layout,
  props: {
    agendas: {
      required: true,
    },
    existingCommittee: {
      required: true,
    },
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
      guests: [],
    });

    const setExistingCommittee = () => {
      committee.name = props.existingCommittee.name;

      if (props.existingCommittee.lead_committee) {
        committee.lead_committee = parseInt(props.existingCommittee.lead_committee);
      }

      if (
        props.existingCommittee.expanded_committee ||
        props.existingCommittee.expanded_committee_2
      ) {
        committee.expanded_committee = [
          ...(props.existingCommittee.expanded_committee
            ? [parseInt(props.existingCommittee.expanded_committee)]
            : []),
          ...(props.existingCommittee.expanded_committee_2
            ? [parseInt(props.existingCommittee.expanded_committee_2)]
            : []),
        ];
      } else {
        committee.expanded_committee = [];
      }
    };

    const submitCommitteeForm = () => {
      let formData = new FormData();
      formData.append("name", committee.name);
      formData.append("lead_committee", committee.lead_committee);
      formData.append("expanded_committee", JSON.stringify(committee.expanded_committee));
      formData.append("file", committee.file);
      formData.append("_method", "put");
      formData.append("guests", JSON.stringify(committee.guests));

      processing.value = true;

      axios
        .post(`/committee/${props.existingCommittee.id}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.status === 200) {
            errors.value = {};
            processing.value = false;
            notyf.success(response.data.message);
            router.visit("/committee", {
              preserveScroll: true,
              preserveState: true,
            });
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

    watchEffect(() => {
      if (props.existingCommittee.id) {
        setExistingCommittee();
        committee.guests = [];
        if (props.existingCommittee?.committee_invited_guests?.length > 0) {
          props.existingCommittee.committee_invited_guests.forEach((guest) => {
            committee.guests.push({
              fullname: guest.fullname,
            });
          });
        }
      }
    });

    const addNewGuestField = () => {
      committee.guests.push({
        fullname: "",
      });
    };

    return {
      processing,
      committee,
      errors,
      submitCommitteeForm,
      onFileAttached,
      addNewGuestField,
    };
  },
};
</script>
<template>
  <FullScreenLoader :processing="processing" />
  <AllFields />

  <form @submit.prevent="submitCommitteeForm" method="POST" enctype="multipart/form-data">
    <div class="form-group" v-auto-animate>
      <label for="name" class="form-label required text-uppercase fw-bold text-dark"
        >Name</label
      >
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
      <label
        for="lead_committee"
        class="form-label required text-uppercase fw-bold text-dark"
        >Lead Committee</label
      >
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
      <label for="expanded_committee" class="form-label text-uppercase fw-bold text-dark"
        >Expanded Committee</label
      >
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
      </div>
    </div>

    <div class="form-group mt-3">
      <label for="file" class="form-label text-uppercase fw-bold text-dark">File</label>
      <input
        type="file"
        name="file"
        id="file"
        class="form-control"
        @change="onFileAttached"
      />
    </div>

    <div class="d-flex mt-2 mb-1 justify-content-between align-items-center">
      <div>
        <h6 class="letter-spacing-1 text-dark text-uppercase fw-bold mt-3">
          INVITED GUESTS
        </h6>
      </div>
      <div>
        <button class="btn btn-sm btn-primary" @click="addNewGuestField" type="button">
          <i class="mdi mdi-plus-circle-outline mdi-18px"></i>
        </button>
      </div>
    </div>
    <div v-auto-animate>
      <div
        class="form-group mb-2"
        v-for="(guest, index) in committee.guests"
        :key="guest"
      >
        <input
          type="text"
          class="form-control text-uppercase"
          :placeholder="`${index + 1}. Guest Information`"
          v-model="guest.fullname"
        />
      </div>
    </div>
    <hr />

    <div class="d-flex justify-content-end align-items-center mt-3">
      <div>
        <button type="submit" class="btn btn-success letter-spacing-1 text-uppercase">
          <i class="mdi mdi-send me-2"></i>
          update
        </button>
      </div>
    </div>
  </form>
</template>
