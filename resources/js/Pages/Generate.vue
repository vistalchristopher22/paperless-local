<script setup>
import { defineComponent, inject, provide, ref, watch } from "vue";
import Layout from "@pages/Layout.vue";
import MinutesInformation from "@components/Session/MinutesInformation.vue";
import { VuePDF, usePDF } from "@tato30/vue-pdf";
import { addNumberSuffix } from "@common/helpers";
import vSelect from "vue-select";
import moment from "moment";
import { FIRST_DISTRICT, SECOND_DISTRICT } from "@/contants/injectKeys.js";
import {
  getPresentRecords,
  presentGroupByDistrictRecords,
  getAbsentRecords,
  getOnSickLeaveRecords,
  getOfficialBusinessRecords,
} from "@services/AttendanceService";

defineComponent({
  vSelect,
});

const props = defineProps({
  schedule: {
    type: Object,
    required: true,
  },
  presidingOfficer: {
    required: true,
  },
  sanggunianMembers: {
    type: Array,
    required: true,
  },
});

const config = inject("$config");
const presentByDistrict = presentGroupByDistrictRecords(props.schedule);

const firstDistrictPresent = ref(
  presentByDistrict[FIRST_DISTRICT].map((record) => record.fullname)
);
const secondDistrictPresent = ref(
  presentByDistrict[SECOND_DISTRICT].map((record) => record.fullname)
);
const selectedPresidingOfficer = ref(props.presidingOfficer.value);
const absentMembers = ref(
  getAbsentRecords(props.schedule).map((record) => record.fullname)
);
const onOfficialBusinessMembers = ref(
  getOfficialBusinessRecords(props.schedule).map((record) => record.fullname)
);
const onSickLeaveMembers = ref(
  getOnSickLeaveRecords(props.schedule).map((record) => record.fullname)
);

const modifyDocument = () => {
  config.socket.emit("WRITE_RESO", {
    ...props.schedule,
    id: props.schedule.id,
    presiding_officer: selectedPresidingOfficer.value,
    firstDistrictPresent: firstDistrictPresent.value,
    secondDistrictPresent: secondDistrictPresent.value,
    absents: absentMembers.value,
    on_sick_leave: onSickLeaveMembers.value,
    on_official_business: onOfficialBusinessMembers.value,
    date: moment(props.schedule.date_and_time).format("MMMM DD, YYYY"),
    suffix: addNumberSuffix(parseInt(props.schedule.reference_session, 10)),
  });
};

const printDocument = () => {
  config.socket.emit("PRINT_DOCUMENT", {
    ...props.schedule,
    id: props.schedule.id,
    presiding_officer: selectedPresidingOfficer.value,
    firstDistrictPresent: firstDistrictPresent.value,
    secondDistrictPresent: secondDistrictPresent.value,
    absents: absentMembers.value,
    on_sick_leave: onSickLeaveMembers.value,
    on_official_business: onOfficialBusinessMembers.value,
    date: moment(props.schedule.date_and_time).format("MMMM DD, YYYY"),
    suffix: addNumberSuffix(parseInt(props.schedule.reference_session, 10)),
  });
};

const page = ref(1);
const { pdf, pages } = usePDF("");

config.socket.on("UPDATE_RESO_DOCX_TO_PDF_COMPLETE", (data) => {
  page.value = 1;

  const { pdf: newPDFToLoad, pages: newPages } = usePDF(`/legislations/${data.pdfPath}`);

  watch(newPDFToLoad, () => {
    pdf.value = newPDFToLoad.value;
  });

  watch(newPages, () => {
    pages.value = newPages.value;
  });
});

const onAnnotation = (value) => {
  if (value.type === "link") {
    window.open(value.data.url, "_blank");
  }
};

provide("schedule", ref(props.schedule));
</script>

<template>
  <div>
    <layout>
      <div class="w-100 p-0 m-0" v-for="page in pages" :key="page">
        <VuePDF
          :pdf="pdf"
          :page="page"
          annotation-layer
          text-layer
          fit-parent
          @annotation="onAnnotation"
        />
      </div>

      <MinutesInformation :schedule="schedule" />
      <div class="header">
        <div class="title w-100 bg-dark p-2">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-bold h5 text-uppercase text-white">attendees</h5>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="form-group row m-2 mb-3">
              <label class="col-sm-2 col-form-label text-uppercase text-dark fw-bold"
                >Presiding Officer</label
              >
              <div class="col-sm-10">
                <v-select
                  :options="sanggunianMembers"
                  :reduce="(option) => option.fullname"
                  label="fullname"
                  v-model="selectedPresidingOfficer"
                >
                </v-select>
              </div>
            </div>

            <div class="form-group row m-2 mb-3">
              <label class="col-sm-2 col-form-label text-uppercase text-dark fw-bold">
                Present (District I):
              </label>
              <div class="col-sm-10">
                <v-select
                  :options="sanggunianMembers"
                  :reduce="(option) => option.fullname"
                  label="fullname"
                  v-model="firstDistrictPresent"
                  multiple
                >
                </v-select>
              </div>
            </div>

            <div class="form-group row m-2 mb-3">
              <label class="col-sm-2 col-form-label text-uppercase text-dark fw-bold">
                Present (District II) :
              </label>
              <div class="col-sm-10">
                <v-select
                  :options="sanggunianMembers"
                  :reduce="(option) => option.fullname"
                  label="fullname"
                  v-model="secondDistrictPresent"
                  multiple
                >
                </v-select>
              </div>
            </div>

            <div class="form-group row m-2 mb-3">
              <label class="col-sm-2 col-form-label text-uppercase text-dark fw-bold">
                Absent :
              </label>
              <div class="col-sm-10">
                <v-select
                  :options="sanggunianMembers"
                  :reduce="(option) => option.fullname"
                  label="fullname"
                  v-model="absentMembers"
                  multiple
                >
                </v-select>
              </div>
            </div>

            <div class="form-group row m-2 mb-3">
              <label class="col-sm-2 col-form-label text-uppercase text-dark fw-bold">
                On Official Business:
              </label>
              <div class="col-sm-10">
                <v-select
                  :options="sanggunianMembers"
                  :reduce="(option) => option.fullname"
                  label="fullname"
                  v-model="onOfficialBusinessMembers"
                  multiple
                >
                </v-select>
              </div>
            </div>

            <div class="form-group row m-2 mb-3">
              <label class="col-sm-2 col-form-label text-uppercase text-dark fw-bold">
                On Sick Leave:
              </label>
              <div class="col-sm-10">
                <v-select
                  :options="sanggunianMembers"
                  :reduce="(option) => option.fullname"
                  label="fullname"
                  v-model="onSickLeaveMembers"
                  multiple
                >
                </v-select>
              </div>
            </div>
          </div>
        </div>

        <table class="table border mb-0">
          <tr>
            <th class="p-2 fw-bold text-uppercase w-50 letter-spacing-1"></th>
            <td class="p-2 align-middle fw-bold text-uppercase"></td>
          </tr>
        </table>
      </div>

      <div class="add-attachment-body d-flex flex-column align-items-center p-2 mt-4">
        <div class="align-self-end me-2" @click="printDocument">
          <button class="btn btn-dark">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-printer-fill"
              viewBox="0 0 16 16"
            >
              <path
                d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1"
              />
              <path
                d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"
              />
            </svg>
            PRINT
          </button>
        </div>
        <div class="card rounded-0 shadow-none document__body p-2">
          <div
            class="card-body d-flex align-items-center flex-row justify-content-center"
          >
            <button
              @click="modifyDocument"
              class="btn btn-primary btn-lg mb-2 fw-medium shadow position-absolute"
              style="z-index: 9999999999999"
            >
              MODIFY TEMPLATE
            </button>
            <div class="overlay"></div>
          </div>
        </div>
      </div>
    </layout>
  </div>
</template>
<style scoped>
.add-attachment-body {
  height: 57vh;
  background-color: #f4f4f4;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

.document__body {
  width: 80vw;
  height: 60vh;
  background: url("/document_body_placeholder.png") no-repeat top center;
  background-size: cover;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.95);
  z-index: 1;
}
</style>
