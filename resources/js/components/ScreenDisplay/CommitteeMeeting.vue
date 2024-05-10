<script setup>
const props = defineProps({
  schedule: {
    type: Object,
    required: true,
  },
});
</script>
<template>
  <div>
    <h5 class="card-title text-dark mb-3">Committee Meeting</h5>
    <div class="card-text">
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="bg-light text-uppercase fw-bold letter-spacing-1">Chairman</th>
            <th class="bg-light text-uppercase fw-bold letter-spacing-1">
              Vice Chairman
            </th>
            <th class="bg-light text-uppercase fw-bold letter-spacing-1">Meeting Date</th>
            <th class="bg-light text-uppercase fw-bold letter-spacing-1">Venue</th>
            <th class="bg-light text-uppercase fw-bold letter-spacing-1">Agenda</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="committee in schedule.committees" :key="committee">
            <td>
              {{ committee.lead_committee_information?.chairman_information?.fullname }}
            </td>
            <td>
              {{
                committee.lead_committee_information?.vice_chairman_information?.fullname
              }}
            </td>
            <td>
              {{ schedule.date_and_time }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
