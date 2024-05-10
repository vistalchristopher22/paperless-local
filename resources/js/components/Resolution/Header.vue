<script setup>
import { inject } from "vue";
import moment from "moment";
const schedule = inject("schedule");
</script>
<template>
  <div class="header">
    <div
      class="header__container mt-2 d-flex align-items-center justify-content-center flex-column"
    >
      <span class="header__text fw-bold">Republika ng Pilipinas</span>
      <span class="header__text fw-bold">LALAWIGAN NG SURIGAO DEL SUR</span>
      <span class="header__text fw-bold">TANDAG CITY</span>
    </div>

    <div
      class="header__container mt-2 d-flex align-items-center justify-content-center flex-column"
    >
      <span class="header__text fw-bold">Tanggapan ng Sangguniang Panlalawigan</span>
      <span class="header__text fw-bold">(Office of the Provincial Council)</span>
    </div>

    <br />
    <div class="header__description text-uppercase fw-bold">
      EXCERPT FROM THE MINUTES OF THE {{ schedule.reference_session }}
      {{ schedule.type }} OF THE (20<sup>th</sup>) SANGGUNIANG PANLALAWIGAN OF SURIGAO DEL
      SUR HELD AT THE {{ schedule.schedule_venue.name }}, LEGISLATIVE BUILDING, CAPITOL OF
      THE SOUTH, BARANGAY KAHAYAG, BISLIG CITY, PROVINCE OF SURIGAO DEL SUR ON
      {{ moment(schedule.date_and_time).format("MMMM DD, YYYY") }}
    </div>
  </div>
</template>

<style scoped>
.header__text {
  font-size: 47.3725px;
  color: black;
}

.header__container {
  text-align: center;
  padding: 0;
  margin: 0;
  color: black;
}

.header {
  padding-right: 200px;
  padding-left: 200px;
  font-size: 47.3725px;
  font-family: "Times New Roman", Times, serif;
  color: black;
}

.header__description {
  margin-top: 30px;
  font-size: 47.3725px;
  text-align: justify;
  color: black;
}
</style>
