<script setup>
import { router } from "@inertiajs/vue3";
import { inject } from "vue";
const props = defineProps({
  schedule: {
    type: Object,
    required: true,
  },
});

const config = inject("$config");

const generateScreenDisplay = () => {
  // add alertify
  alertify.confirm(
    "Generate Screen Display",
    "Are you sure you want to generate screen display?",
    function () {
      axios
        .post(`/api/committee-meeting-generate-display/${props.schedule.id}`)
        .then((response) => {
          router.visit(location.href);
        });
    },
    function () {}
  );
};

const refreshScreen = () => {
  alertify.confirm(
    "Refresh Screen",
    "Are you sure you want to refresh screen display?",
    function () {
      config.socket.emit("TRIGGER_REFRESH");
    },
    function () {}
  );
};

const setAsNext = (id) => {
  axios.post(`/api/committee-meeting-screen-next/${id}`).then((response) => {
    router.visit(location.href);
  });
};

const setAsPending = (id) => {
  axios.post(`/api/committee-meeting-screen-pending/${id}`).then((response) => {
    router.visit(location.href);
  });
};

const setAsCurrent = (id) => {
  axios.post(`/api/committee-meeting-screen-current/${id}`).then((response) => {
    router.visit(location.href);
  });
};
</script>
<template>
  <div>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-dark">Complete listing of chairmanship</h5>
        <div class="float-end">
          <div class="btn-group">
            <button
              class="btn btn-primary text-uppercase fw-bold"
              @click="generateScreenDisplay"
            >
              Generate Screen Display
            </button>
            <button class="btn btn-danger text-uppercase fw-bold" @click="refreshScreen">
              REFRESH SCREEN
            </button>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="card-text">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th class="bg-light text-uppercase fw-bold letter-spacing-1">
                  Committee
                </th>
                <th class="bg-light text-uppercase fw-bold letter-spacing-1">Chairman</th>
                <th class="bg-light text-uppercase fw-bold letter-spacing-1">
                  Vice Chairman
                </th>
                <th class="bg-light text-uppercase fw-bold letter-spacing-1">Venue</th>
                <th class="bg-light text-uppercase fw-bold letter-spacing-1">order</th>
                <th class="bg-light text-uppercase fw-bold letter-spacing-1">status</th>
                <th class="bg-light text-uppercase fw-bold letter-spacing-1">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="committee in schedule.committees" :key="committee">
                <td class="text-uppercase fw-bold text-primary">
                  {{ committee.name }}
                </td>
                <td>
                  {{
                    committee.lead_committee_information?.chairman_information?.fullname
                  }}
                </td>
                <td>
                  {{
                    committee.lead_committee_information?.vice_chairman_information
                      ?.fullname
                  }}
                </td>
                <td>
                  {{ schedule?.schedule_venue?.name }}
                </td>
                <td>
                  {{ committee?.display?.index }}
                </td>
                <td class="text-uppercase">
                  <span
                    class="badge bg-success"
                    v-if="committee?.display?.status === 'on_going'"
                    >on-going</span
                  >

                  <span
                    class="badge bg-warning"
                    v-if="committee?.display?.status === 'pending'"
                    >pending</span
                  >

                  <span
                    class="badge bg-primary"
                    v-if="committee?.display?.status === 'next'"
                    >next</span
                  >
                </td>
                <td class="text-center">
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <button
                      class="btn btn-primary"
                      @click="setAsNext(committee?.display?.id)"
                    >
                      SET AS NEXT
                    </button>
                    <button
                      class="btn btn-warning"
                      @click="setAsPending(committee?.display?.id)"
                    >
                      SET AS PENDING
                    </button>
                    <button
                      class="btn btn-success"
                      @click="setAsCurrent(committee?.display?.id)"
                    >
                      SET AS CURRENT
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
