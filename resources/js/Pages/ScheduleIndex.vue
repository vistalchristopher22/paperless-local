<script setup>
import { defineComponent, ref } from "vue";
import { Notyf } from "notyf";
import { addNumberSuffix } from "@common/helpers";
import { Link, router } from "@inertiajs/vue3";
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import vSelect from "vue-select";
import AddBoardSessionModal from "@components/AddBoardSessionModal.vue";
import AddCommitteeModal from "@components/AddCommitteeModal.vue";
import AddVenueModal from "@components/AddVenueModal.vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import {
  newSchedule,
  updateSchedule,
  deleteSchedule,
  moveSchedule,
  getSchedule,
} from "@services/ScheduleApi.js";
import {
  initializeScheduleForEvent,
  initializeScheduleFromResponse,
} from "@services/ScheduleService.js";

defineComponent({
  FullScreenLoader,
  Link,
  FullCalendar,
  vSelect,
  AddBoardSessionModal,
  AddCommitteeModal,
  AddVenueModal,
});

const props = defineProps({
  venues: {
    required: true,
  },
  orderOfBusiness: {
    required: true,
  },
  scheduleTypes: {
    required: true,
  },
  ScheduleType: {
    required: true,
  },
  agendas: {
    required: true,
  },
});

const errors = ref({});
const processing = ref(false);
const displayEventForm = ref(false);
const selectedDate = ref("");
const sidebarOverlay = ref(false);
const schedule = ref({
  name: "",
  date: "",
  time: "",
  short_description: "",
  venue: "",
  type: "",
  reference_session: "",
  committees_count: 0,
  order_of_business: "",
});

const handleSuccess = (response) => {
  if (response.data.success) {
    new Notyf().success("Schedule saved successfully.");
    router.visit("/schedules", {
      preserveScroll: true,
    });
  }
};

const handleError = (error) => {
  if (error.response.status === 422) {
    errors.value = error.response.data.errors;
  } else {
    new Notyf().error("Something went wrong.");
  }
};

const createSchedule = () => {
  newSchedule(schedule, selectedDate).then(handleSuccess).catch(handleError);
};

const editSchedule = () => {
  updateSchedule(schedule).then(handleSuccess).catch(handleError);
};

const removeSchedule = (id) => {
  alertify.confirm(
    "Delete Record",
    "Are you sure you want to remove this schedule?",
    function () {
      deleteSchedule(id).then(handleSuccess).catch(handleError);
    },
    function () {}
  );
};

const loadNewOrderofBusiness = () => {
  router.visit("/schedules", {
    preserveScroll: true,
    preserveState: true,
    only: ["orderOfBusiness"],
  });
};

const calendarOptions = {
  height: "800px",
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  headerToolbar: {
    left: "prev,next today",
    center: "title",
    right: "dayGridMonth,timeGridWeek,timeGridDay",
  },
  initialView: "dayGridMonth",
  editable: true,
  selectable: true,
  selectMirror: true,
  dayMaxEvents: true,
  weekends: true,
  events: "/api/schedules",
  select: (event) => {
    schedule.value = initializeScheduleForEvent(event);
    selectedDate.value = event.startStr;
    displayEventForm.value = true;
  },
  eventDrop: (event) => {
    moveSchedule(event).then(handleSuccess).catch(handleError);
  },
  eventClick: (event) => {
    sidebarOverlay.value = true;
    getSchedule(event).then((response) => {
      if (response.status === 200) {
        displayEventForm.value = true;
        schedule.value = initializeScheduleFromResponse(response, event);
        sidebarOverlay.value = false;
      }
    });
  },
};
</script>
<template>
  <layout>
    <div>
      <FullScreenLoader :processing="processing" />
      <AddBoardSessionModal :enable-redirect="false" @success="loadNewOrderofBusiness" />
      <AddCommitteeModal :agendas="agendas" />
      <AddVenueModal :venues="venues"></AddVenueModal>

      <div
        class="offcanvas offcanvas-end shadow"
        v-auto-animate
        :class="{ show: displayEventForm }"
        style="width: 380px"
        tabindex="-1"
        id="offCanvasEventDetail"
        aria-labelledby="offCanvasEventDetailTitle"
      >
        <div class="offcanvas-header position-relative py-1 mb-0">
          <div
            class="d-flex align-items-center justify-content-between w-100 border border-top-0 border-start-0 border-end-0"
          >
            <div class="">
              <h5 class="text-uppercase" id="offCanvasEventDetailTitle">
                <span class="text-dark fw-bold text-uppercase">schedule</span>
              </h5>
            </div>

            <div>
              <button
                class="btn btn-danger btn-sm shadow"
                @click="displayEventForm = false"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="12"
                  height="12"
                  fill="currentColor"
                  class="bi bi-x-lg"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
          <div class="overflow-auto">
            <div
              class="bg-dark"
              v-if="sidebarOverlay"
              style="
                position: absolute;
                top: 0%;
                left: 0%;
                right: 0%;
                bottom: 0%;
                z-index: 9999;
                opacity: 0.5;
              "
            >
              <!-- bootstrap 5 spinner -->
              <div
                class="spinner-border text-light"
                role="status"
                style="position: absolute; top: 50%; left: 50%"
              >
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
            <div class="d-flex flex-column justify-content-between">
              <div>
                <div class="form-group mb-3">
                  <div class="d-flex align-items-end justify-content-between">
                    <div>
                      <label
                        for="time"
                        class="form-label text-uppercase text-dark fw-bold"
                        >Date</label
                      >
                    </div>
                    <div>
                      <button
                        v-if="schedule.id != ''"
                        @click="removeSchedule(schedule.id)"
                        class="btn btn-sm btn-danger mb-2 fw-bold letter-spacing-1 d-flex justify-content-center align-items-center"
                      >
                        <i class="mdi mdi-trash-can mdi-18px me-1"></i>
                        DELETE
                      </button>
                    </div>
                  </div>
                  <input
                    id="date"
                    type="date"
                    disabled
                    class="form-control"
                    v-model="schedule.date"
                  />

                  <span class="text-danger" v-if="errors.hasOwnProperty('selected_date')">
                    {{ errors?.selected_date[0] }}
                  </span>
                </div>

                <div class="form-group mb-3">
                  <label for="time" class="form-label text-uppercase text-dark fw-bold"
                    >Time</label
                  >
                  <input
                    id="time"
                    type="time"
                    class="form-control"
                    v-model="schedule.time"
                  />
                </div>

                <div class="form-group mb-3">
                  <label
                    for="shortDescription"
                    class="form-label text-uppercase text-dark fw-bold"
                    >Description</label
                  >
                  <textarea
                    id="shortDescription"
                    class="form-control"
                    name=""
                    rows="2"
                    v-model="schedule.short_description"
                  ></textarea>
                </div>

                <div class="form-group mb-3">
                  <div class="d-flex justify-content-between align-items-center">
                    <label
                      for="order_of_business"
                      class="form-label text-uppercase text-dark fw-bold"
                      >Order of Business</label
                    >
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="fw-medium cursor-pointer"
                        data-bs-target="#addBoardSessionModal"
                        data-bs-toggle="modal"
                      >
                        <i class="mdi mdi-plus-circle-outline mdi-24px"></i>
                      </span>
                    </div>
                  </div>

                  <v-select
                    class="text-uppercase"
                    v-model="schedule.order_of_business"
                    :options="orderOfBusiness"
                    label="title"
                    :reduce="(option) => parseInt(option.id)"
                  >
                  </v-select>
                </div>

                <div class="form-group mb-3">
                  <div class="d-flex justify-content-between align-items-center">
                    <label
                      for="committee"
                      class="form-label text-uppercase text-dark fw-bold"
                      >No. of Committees</label
                    >
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="fw-medium cursor-pointer"
                        data-bs-toggle="modal"
                        data-bs-target="#addNewCommittee"
                      >
                        <i class="mdi mdi-plus-circle-outline mdi-24px"></i>
                      </span>
                    </div>
                  </div>
                  <input
                    type="text"
                    disabled
                    class="form-control"
                    v-model="schedule.committees_count"
                  />
                </div>

                <div class="form-group mb-3">
                  <div class="d-flex justify-content-between align-items-center">
                    <label for="venue" class="form-label text-uppercase text-dark fw-bold"
                      >Venue</label
                    >
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="fw-medium cursor-pointer"
                        data-bs-toggle="modal"
                        data-bs-target="#addVenueModal"
                      >
                        <i class="mdi mdi-plus-circle-outline mdi-24px"></i>
                      </span>
                    </div>
                  </div>

                  <select
                    id="venue"
                    name="venue"
                    class="form-control text-uppercase form-select"
                    :class="{ 'is-invalid': errors?.hasOwnProperty('venue') }"
                    v-model="schedule.venue"
                  >
                    <option :value="venue.id" v-for="venue in venues" :key="venue.id">
                      {{ venue.name }}
                    </option>
                  </select>
                  <span
                    class="text-danger"
                    v-for="venueError in errors.venue"
                    :key="venueError"
                  >
                    {{ venueError }}
                  </span>
                </div>

                <div class="form-group mb-3">
                  <label for="type" class="form-label text-uppercase text-dark fw-bold"
                    >Type</label
                  >
                  <select
                    id="type"
                    name="type"
                    class="form-select text-uppercase"
                    :class="{ 'is-invalid': errors?.hasOwnProperty('type') }"
                    v-model="schedule.type"
                  >
                    <option
                      :value="schedule"
                      v-for="(schedule, index) in scheduleTypes"
                      :key="index"
                    >
                      {{ schedule }}
                    </option>
                  </select>
                  <span
                    class="text-danger"
                    v-for="scheduleError in errors.type"
                    :key="scheduleError"
                  >
                    {{ scheduleError }}
                  </span>
                </div>

                <div class="form-group">
                  <label
                    for="reference_session"
                    class="form-label text-uppercase text-dark fw-bold"
                    >Session Number</label
                  >
                  <input
                    id="reference_session"
                    name="reference_session"
                    class="form-control text-uppercase"
                    v-model="schedule.reference_session"
                    :class="{ 'is-invalid': errors?.hasOwnProperty('reference_session') }"
                  />
                  <span
                    class="text-danger"
                    v-for="referenceSessionError in errors.reference_session"
                    :key="referenceSessionError"
                  >
                    {{ referenceSessionError }}
                  </span>
                </div>

                <div class="form-group mt-2" v-if="schedule.id != ''">
                  <div class="me-2">
                    <label
                      for="reference_session"
                      class="form-label text-uppercase text-dark fw-bold"
                      >No. of Board Members</label
                    >
                    <input
                      class="form-control text-uppercase text-end me-2 fw-bold"
                      v-model="schedule.attendance_logs_count"
                      readonly
                    />
                  </div>
                  <div class="input-group my-2">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text fw-bold text-uppercase bg-primary text-white rounded-0"
                        >Present</span
                      >
                    </div>
                    <input
                      class="form-control text-uppercase ms-1 me-2 text-end"
                      readonly
                      v-model="schedule.present_count"
                    />
                  </div>

                  <div class="input-group my-2">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text fw-bold text-uppercase bg-primary text-white rounded-0"
                        >Absent</span
                      >
                    </div>
                    <input
                      readonly
                      class="form-control text-uppercase ms-1 text-end me-2"
                      v-model="schedule.absent_count"
                    />
                  </div>

                  <div class="input-group my-2">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text fw-bold text-uppercase bg-primary text-white rounded-0"
                        >Late</span
                      >
                    </div>
                    <input
                      readonly
                      class="form-control text-uppercase ms-1 me-2 text-end"
                      v-model="schedule.late_count"
                    />
                  </div>

                  <div class="input-group my-2">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text fw-bold text-uppercase bg-primary text-white rounded-0"
                        >OB</span
                      >
                    </div>
                    <input
                      readonly
                      class="form-control text-uppercase ms-1 text-end me-2"
                      v-model="schedule.on_official_business_count"
                    />
                  </div>

                  <div class="input-group my-2">
                    <div class="input-group-prepend">
                      <span
                        class="input-group-text fw-bold text-uppercase bg-primary text-white rounded-0"
                        >SICK LEAVE</span
                      >
                    </div>
                    <input
                      readonly
                      class="form-control text-uppercase ms-1 text-end me-2"
                      v-model="schedule.sick_leave_count"
                    />
                  </div>
                </div>
              </div>

              <hr />

              <div>
                <div class="btn-group d-flex">
                  <a
                    v-if="schedule.id != ''"
                    class="btn btn-primary p-2 d-flex align-items-center justify-content-center"
                    :href="`/schedule/committees/${schedule.date}`"
                  >
                    <i class="mdi mdi-eye mdi-18px me-2"></i>
                    <span class="fw-bold letter-spacing-1">VIEW</span>
                  </a>
                  <button
                    class="btn btn-dark p-2 d-flex align-items-center justify-content-center"
                    v-if="schedule.id != ''"
                    @click="editSchedule"
                  >
                    <i class="mdi mdi-content-save mdi-18px me-1"></i>
                    <span class="fw-bold letter-spacing-1">SAVE</span>
                  </button>

                  <button
                    class="btn btn-dark p-2 d-flex align-items-center justify-content-center"
                    v-if="schedule.id == ''"
                    @click="createSchedule"
                  >
                    <i class="mdi mdi-content-save mdi-18px me-1"></i>
                    <span class="fw-bold letter-spacing-1">SAVE</span>
                  </button>
                </div>

                <div class="btn-group d-flex my-2">
                  <a
                    v-if="schedule.id != ''"
                    class="btn btn-primary p-2 d-flex align-items-center justify-content-center"
                    :href="`/generate/${schedule.id}`"
                  >
                    <i class="mdi mdi-eye mdi-18px me-2"></i>
                    <span class="fw-bold letter-spacing-1">CREATE MINUTES</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div
                class="card-header bg-dark d-flex flex-row justify-content-between align-items-center"
              >
                <div class="card-title text-white p-1 fw-medium">Schedules</div>
              </div>
              <div class="card-body">
                <FullCalendar :options="calendarOptions" ref="calendar"></FullCalendar>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<style scoped>
.letter-spacing-1 {
  letter-spacing: 1px;
}
</style>
