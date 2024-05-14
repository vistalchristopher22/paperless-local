<script setup>
import { inject } from "vue";
import moment from "moment";
const schedule = inject("schedule");
</script>
<template>
  <div class="header mt-3">
    <div class="title w-100 bg-dark p-2">
      <div class="d-flex align-items-center justify-content-between">
        <h5 class="fw-bold h5 text-uppercase text-white">Schedule Information</h5>
      </div>
    </div>
    <table class="table table-bordered border table-hover mb-0">
      <tr>
        <th class="p-2 align-middle fw-bold text-uppercase w-50 letter-spacing-1">
          Date:
        </th>
        <td class="p-2 align-middle fw-bold text-uppercase">
          {{ moment(schedule.date_and_time).format("MMMM DD, YYYY") }}
        </td>
      </tr>
      <tr>
        <th class="p-2 fw-bold text-uppercase w-50 letter-spacing-1">Time:</th>
      </tr>
      <tr>
        <th class="p-2 fw-bold text-uppercase w-50 letter-spacing-1">Venue:</th>
        <td class="p-2 fw-bold">{{ schedule.schedule_venue.name }}</td>
      </tr>
      <tr>
        <th class="p-2 fw-bold text-uppercase w-50 letter-spacing-1">Session Type:</th>
        <td class="p-2 fw-bold text-uppercase">{{ schedule.type }}</td>
      </tr>
      <tr>
        <th class="p-2 fw-bold text-uppercase w-50 letter-spacing-1">
          Session Reference:
        </th>
        <td class="p-2 fw-bold text-uppercase">{{ schedule.reference_session }}</td>
      </tr>
    </table>
  </div>
</template>
