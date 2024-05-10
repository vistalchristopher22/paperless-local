<script setup>
import { inject } from "vue";
import moment from "moment";
const schedule = inject("schedule");
console.log(schedule);
</script>
<template>
  <div class="members">
    <div class="members__text">
      <br />
      <br />
      <span class="fw-bold">PRESENT: </span>
      <div class="row">
        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">Hon. Manuel O. Alameda, Sr.</div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">&nbsp;- Vice Governor</div>
            <div class="mx-6">(Presiding Officer)</div>
          </div>
        </div>
      </div>
      <div class="text-center mt-3">
        <span class="fw-bold">Regular Sangguniang Panlalawigan Members: </span>
      </div>
      <div class="d-flex justify-content-around mt-4">
        <span class="text-center fw-bold">DISTRICT I</span>
        <span class="text-center fw-bold"> DISTRICT II </span>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">Hon. Ruel D. Momo</div>
            <div class="mx-6">Hon. Amado M. Layno, Jr.</div>
            <div class="mx-6">Hon. Antonio C. Azarcon</div>
            <div class="mx-6">Hon. Valerio T. Montesclaros, Jr.</div>
            <div class="mx-6">Hon. Jose Dumagan Jr.</div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">Hon. Conrad C. Cejoco</div>
            <div class="mx-6">Hon. Margarita G. Garay</div>
            <div class="mx-6">Hon. Gines Ricky J. Sayawan, Sr.</div>
            <div class="mx-6">Hon. Anthony Joseph P. Cañedo</div>
            <div class="mx-6">Hon. Raul K. Salazar</div>
          </div>
        </div>
      </div>

      <div class="text-center mt-3">
        <span class="fw-bold">Ex - Officio Members: </span>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">Hon. John Paul C. Pimentel</div>
            <div class="mx-6"></div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">- President, Philippine Councilors’</div>
            <div class="mx-6">&nbsp;&nbsp;League, Surigao del</div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">Hon. Charles P. Arreza</div>
            <div class="mx-6"></div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">- President, Panlalawigang Pederasyon</div>
            <div class="mx-6">&nbsp;&nbsp;ng mga Sangguniang Kabataan</div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">Hon. Melanie Joy Momo-Guno</div>
            <div class="mx-6"></div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">- President, Provincial Chapter of the</div>
            <div class="mx-6">&nbsp;&nbsp;Liga ng mga Barangay sa Pilipinas</div>
          </div>
        </div>
      </div>

      <span class="fw-bold">ON OFFICIAL BUSINESS: </span>
      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">Hon. Melanie Joy Momo-Guno</div>
            <div class="mx-6"></div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">- President, Provincial Chapter of the</div>
            <div class="mx-6">&nbsp;&nbsp;Liga ng mga Barangay sa Pilipinas</div>
          </div>
        </div>
      </div>

      <span class="fw-bold">ABSENT: </span>

      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6 fw-bold">Sick Leave :</div>
            <div class="mx-6"></div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">Hon. Jimmy I. Guinsod</div>
            <div class="mx-6"></div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="d-flex flex-column w-100">
            <div class="mx-6">- Indigenous Peoples Mandatory</div>
            <div class="mx-6">&nbsp;&nbsp;Representative, Surigao del Sur</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.members__text {
  font-size: 47.3725px;
  color: black;
}

.members__container {
  text-align: center;
  padding: 0;
  margin: 0;
  color: black;
}

.members {
  padding-right: 200px;
  padding-left: 200px;
  font-size: 47.3725px;
  font-family: "Times New Roman", Times, serif;
  color: black;
}

.members__description {
  margin-top: 30px;
  font-size: 1.8rem;
  text-align: justify;
  color: black;
}

.mx-6 {
  margin-left: 12rem;
  color: black;
}
</style>
