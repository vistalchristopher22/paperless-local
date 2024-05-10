<script setup>
import Layout from "@pages/Layout.vue";
import { defineComponent, ref, watch } from "vue";
import moment from "moment";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import Pagination from "@components/Pagination.vue";
import vSelect from "vue-select";

import AgendaMembers from "@components/AgendaMembers.vue";

defineComponent({
  Layout,
  AgendaMembers,
  Pagination,
  vSelect,
});

const props = defineProps({
  committeeInvitedGuests: {
    type: Object,
    required: true,
  },
  search: {
    type: String,
    default: "",
  },
  agendas: {
    type: Array,
    required: true,
  },
  schedules: {
    type: Array,
    required: true,
  },
  venues: {
    type: Array,
    required: true,
  },
  venue: {
    type: String,
    default: "",
  },
  agenda: {
    type: String,
    default: "",
  },
  schedule: {
    type: String,
    default: "",
  },
});

const fetchedMembers = ref([]);
const displayMembers = ref(false);
const search = ref(props.search || "");
const selectedVenue = ref(parseInt(props.venue) || "");
const selectedAgenda = ref(parseInt(props.agenda) || "");
const selectedSchedule = ref(props.schedule || "");

const showMembers = async (committee, type) => {
  if (committee) {
    try {
      const response = await axios.get(`/api/agenda-members/${committee[type]}`);
      if (response.status === 200) {
        displayMembers.value = true;
        fetchedMembers.value = response.data.agenda;
      }
    } catch (error) {
      console.error(error);
    }
  }
};

watch(
  search,
  debounce(() => {
    router.visit(`/invited-guests?search=${search.value}`);
  }, 500)
);

watch([selectedAgenda, selectedSchedule, selectedVenue], () => {
  selectedAgenda.value = selectedAgenda.value || "";
  selectedSchedule.value = selectedSchedule.value || "";
  selectedVenue.value = selectedVenue.value || "";
  router.visit(
    `/invited-guests?search=${search.value}&agenda=${selectedAgenda.value}&schedule=${selectedSchedule.value}&venue=${selectedVenue.value}`
  );
});
</script>

<template>
  <div>
    <layout>
      <AgendaMembers :displayMembers="displayMembers" :fetchedMembers="fetchedMembers" />

      <div class="card">
        <div
          class="card-header bg-dark p-3 justify-content-between align-items-center d-flex"
        >
          <h6 class="h6 card-title text-white">Invited Guests</h6>
        </div>

        <div class="card-body p-4">
          <div class="row">
            <div class="col-lg-4">
              <label class="form-label text-dark text-uppercase fw-bold"
                >lead committee</label
              >
              <v-select
                :options="agendas"
                label="title"
                v-model="selectedAgenda"
                :reduce="(agenda) => agenda.id"
              />
            </div>

            <div class="col-lg-4">
              <label class="form-label text-dark text-uppercase fw-bold">Schedules</label>
              <v-select
                :options="schedules"
                v-model="selectedSchedule"
                :get-option-label="
                  (option) => option.reference_session + ' - ' + option.type
                "
                :reduce="(schedule) => schedule.reference_session + ' - ' + schedule.type"
              />
            </div>
            <div class="col-lg-4">
              <label class="form-label text-dark text-uppercase fw-bold">Venues</label>
              <v-select
                v-model="selectedVenue"
                :options="venues"
                label="name"
                :reduce="(venue) => venue.id"
              />
            </div>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <div>
              <h5 class="fw-bolder text-uppercase">
                total records [ {{ committeeInvitedGuests.total }} Entry / Entries ]
              </h5>
            </div>
            <div>
              <input
                type="text"
                v-model="search"
                class="form-control border border-dark"
                autofocus
                placeholder="Search..."
              />
            </div>
          </div>
          <table class="table table-striped border">
            <thead>
              <tr class="bg-light">
                <th class="text-uppercase text-center bg-dark text-white">Fullname</th>
                <th class="text-uppercase text-center bg-dark text-white">Session</th>
                <th class="text-uppercase text-center bg-dark text-white">Venue</th>
                <th class="text-uppercase text-center bg-dark text-white">
                  Date <span class="fw-bold">(YyYY-MM-DD)</span>
                </th>
                <th class="text-uppercase text-center bg-dark text-white">
                  ORDER OF BUSINESS / Lead Committee
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="bg-light"
                v-for="committeeInvited in committeeInvitedGuests.data"
                :key="committeeInvited"
              >
                <td class="text-uppercase fw-bold">
                  <span class="mx-3"></span>{{ committeeInvited.fullname }}
                </td>
                <td class="text-start fw-medium text-uppercase fw-bold">
                  {{
                    committeeInvited?.committee?.schedule_information?.reference_session
                  }}
                  -
                  {{ committeeInvited?.committee?.schedule_information?.type }}
                </td>
                <td class="text-center text-uppercase fw-bold">
                  {{
                    committeeInvited?.committee?.schedule_information?.schedule_venue.name
                  }}
                </td>
                <td class="text-center fw-bold">
                  {{
                    moment(
                      committeeInvited?.committee?.schedule_information?.date_and_time
                    ).format("YYYY-MM-DD")
                  }}
                </td>

                <td class="text-uppercase text-center">
                  <span
                    class="text-dark fw-bold cursor-pointer text-decoration-underline"
                    @click="showMembers(committeeInvited.committee, 'lead_committee')"
                  >
                    {{ committeeInvited?.committee.name }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
          <pagination
            :records="committeeInvitedGuests"
            :link="committeeInvitedGuests.path"
          />
        </div>
      </div>
    </layout>
  </div>
</template>

<style scoped>
.letter-spacing-1 {
  letter-spacing: 0.8px;
}

.cursor-pointer {
  cursor: pointer;
}
</style>
