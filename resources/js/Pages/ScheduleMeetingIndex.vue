<script setup>
import { defineComponent, ref } from "vue";
import Layout from "./Layout.vue";
import moment from "moment";
import { VueDraggableNext } from "vue-draggable-next";

defineProps({
  schedule: {
    required: true,
  },
});

defineComponent({
  Layout,
  draggable: VueDraggableNext,
});

const meals = ref(["Hamburger", "Pizza", "Spaghetti", "Tacos", "Teriyaki Chicken"]);
</script>
<template>
  <div>
    <layout>
      <h1>Favorite Foods</h1>
      <draggable v-model="meals" tag="ul">
        <template #item="{ element: meal }">
          <li>{{ meal }}</li>
        </template>
      </draggable>

      <div
        class="header d-flex flex-row align-items-center justify-content-center border border-start-0 border-end-0 border-top-0 border-5 border-dark mb-3"
      >
        <img
          width="10%"
          src="http://localhost:8000/session/logo.png"
          alt=""
          class="me-auto"
        />
        <div class="d-flex flex-column align-items-center">
          <h4 class="text-dark">Republic of the Philippines</h4>
          <h4 class="fw-bold text-dark">PROVINCE OF SURIGAO DEL SUR</h4>
          <h4 class="text-dark">Tandag City</h4>
          <h3 class="fw-bold text-dark">TANGGAPAN NG SANGGUNIANG PANLALAWIGAN</h3>
          <h5 class="text-dark">(Office of the Provincial Council)</h5>
        </div>
        <img
          width="11.5%"
          src="http://localhost:8000/assets/tsp.png"
          alt=""
          class="ms-auto"
        />
      </div>
      <div class="text-center">
        <h4 class="fw-medium" style="letter-spacing: 1.8px">
          SCHEDULE OF COMMITTEE MEETINGS
          <h4 class="fw-bold text-uppercase text-decoration-underline">
            {{ schedule?.schedule_venue.name }}
          </h4>
        </h4>
        <h5 class="fw-medium text-center mt-5">
          <span class="text-uppercase">
            {{ moment(schedule?.date_and_time).format("MMMM DD, YYYY") }}
          </span>
        </h5>
        <h5 class="fw-medium text-uppercase text-center mt-3" style="letter-spacing: 2px">
          COMMITTEE WITHOUT INVITED GUESTS
        </h5>
      </div>
    </layout>
  </div>
</template>
