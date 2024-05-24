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
              <div class="btn-group">
                <Link
                  :href="`/screen-display/${schedule.id}`"
                  class="btn btn-primary"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  data-bs-original-title="Operate Screen Display"
                >
                  SETTINGS
                </Link>

                <!-- href="{{ route('display.screen.monitor', $session->id) }}" -->
                <a
                  :href="`/screen/${schedule.id}`"
                  class="btn btn-success"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  target="_blank"
                  data-bs-original-title="Display Upcoming"
                >
                  SCREEN DISPLAY
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </layout>
</template>
