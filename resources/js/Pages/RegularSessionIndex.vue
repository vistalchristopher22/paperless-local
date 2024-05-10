<script setup>
import Layout from "@pages/Layout.vue";
import { Link, router } from "@inertiajs/vue3";
import { defineComponent, defineProps } from "vue";
import moment from "moment";

defineComponent({
  Layout,
});

const props = defineProps({
  schedules: {
    required: true,
    type: Array,
  },
});
</script>

<template>
  <layout>
    <div class="table-responsive">
      <table class="table table-hover border" id="members-table">
        <thead>
          <tr class="bg-light">
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Session
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Year
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Venue
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Session
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              Committees
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="schedule in schedules" :key="schedule">
            <td class="text-center text-uppercase fw-bold">
              {{ schedule.reference_session }} - {{ schedule.type }}
            </td>
            <td class="text-center text-uppercase fw-bold">
              {{ moment(schedule.date_and_time).format("YYYY") }}
            </td>
            <td class="text-center text-uppercase fw-bold">
              {{ schedule.schedule_venue.name }}
            </td>
            <td class="text-center text-uppercase fw-bold">
              {{ schedule.order_of_business_information.title }}
            </td>
            <td class="text-center text-uppercase fw-bold">
              <Link
                :href="`/schedule/committees/${moment(schedule.date_and_time).format(
                  'YYYY-MM-DD'
                )}`"
              >
                {{ schedule.committees_count }} Committees
              </Link>
            </td>
            <td class="text-center">
              <!-- href="{{ route('screen-display.index', $session->id) }}" -->
              <a
                :href="`/screen-display/${schedule.id}`"
                class="btn btn-soft-primary"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-original-title="Operate Screen Display"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-file-spreadsheet-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M12 0H4a2 2 0 0 0-2 2v4h12V2a2 2 0 0 0-2-2m2 7h-4v2h4zm0 3h-4v2h4zm0 3h-4v3h2a2 2 0 0 0 2-2zm-5 3v-3H6v3zm-4 0v-3H2v1a2 2 0 0 0 2 2zm-3-4h3v-2H2zm0-3h3V7H2zm4 0V7h3v2zm0 1h3v2H6z"
                  />
                </svg>
              </a>

              <!-- href="{{ route('display.screen.monitor', $session->id) }}" -->
              <a
                :href="`/screen/${schedule.id}`"
                class="btn btn-soft-success mx-2"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                target="_blank"
                data-bs-original-title="Display Upcoming"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-display"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75c.167-.333.25-.833.25-1.5H2s-2 0-2-2V4zm1.398-.855a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.602.07.105.17.188.302.254a1.464 1.464 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.758.758 0 0 0 .254-.302 1.464 1.464 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.757.757 0 0 0-.302-.254A1.46 1.46 0 0 0 13.99 3H2c-.325 0-.502.078-.602.145z"
                  />
                </svg>
              </a>

              <!-- {{ route('regular-session.show', $session->id) }} -->
              <a
                href=""
                class="btn btn-soft-info"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-original-title="View Details"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-list-columns-reverse"
                  viewBox="0 0 16 16"
                >
                  <path
                    fill-rule="evenodd"
                    d="M0 .5A.5.5 0 0 1 .5 0h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 .5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10A.5.5 0 0 1 4 .5Zm-4 2A.5.5 0 0 1 .5 2h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 4h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2A.5.5 0 0 1 .5 8h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5Zm-4 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm4 0a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5Z"
                  />
                </svg>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </layout>
</template>
