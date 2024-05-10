<script setup>
import vSelect from "vue-select";
import { defineComponent, inject, onMounted, ref, watch } from "vue";
import { isRecordNew, getBaseURL } from "@common/helpers";
import Pagination from "@components/Pagination.vue";
import moment from "moment";
import axios from "axios";
import { router } from "@inertiajs/vue3";
import { Notyf } from "notyf";

import {
  AVAILABLE_SESSION_SCHEDULES,
  DISPLAY_MEMBERS,
  EDIT_COMMITTEE,
  FETCHED_MEMBERS,
  PROCESSING,
  SEARCH_EXPANDED_COMMITTEE,
  SEARCH_LEAD_COMMITTEE,
  SEARCH_SCHEDULE_SESSION,
  VIEW_SELECTED_FILE,
  SOCKET_INSTANCE,
} from "@/contants/injectKeys";

const notyf = new Notyf({
  duration: 4000,
  position: {
    x: "right",
    y: "bottom",
  },
});

defineComponent({
  vSelect,
  Pagination,
});

const props = defineProps({
  agendas: {
    required: true,
  },
  committees: {
    required: true,
  },
});

const inspectLink = ref("");
const fetchedMembers = inject(FETCHED_MEMBERS);
const displayMembers = inject(DISPLAY_MEMBERS);
const processing = inject(PROCESSING);
const searchLead = inject(SEARCH_LEAD_COMMITTEE);
const searchExpanded = inject(SEARCH_EXPANDED_COMMITTEE);
const searchSession = inject(SEARCH_SCHEDULE_SESSION);
const availableRegularSessions = inject(AVAILABLE_SESSION_SCHEDULES);
const editCommittee = inject(EDIT_COMMITTEE);
const viewSelectedFile = inject(VIEW_SELECTED_FILE);
const config = inject("$config");

const showMembers = async (committee, type) => {
  if (committee) {
    try {
      processing.value = true;
      const response = await axios.get(`/api/agenda-members/${committee[type]}`);
      if (response.status === 200) {
        displayMembers.value = true;
        processing.value = false;
        fetchedMembers.value = response.data.agenda;
      }
    } catch (error) {
      console.error(error);
    }
  }
};

watch([searchLead, searchExpanded, searchSession], () => {
  processing.value = true;
  router.visit(
    `/committee/?lead=${searchLead.value || ""}&expanded=${
      searchExpanded.value || ""
    }&schedule=${searchSession.value || ""}`
  );
});

const truncateText = (text, maxLength) => {
  if (!text) return;
  if (text.length > maxLength) {
    return text.substring(0, maxLength) + "...";
  }
  return text;
};

const copyPublicLinkToClipboard = (link) => {
  navigator.clipboard.writeText(`${getBaseURL()}${link}`);
  notyf.success("Link copied to clipboard");
};

const editAttachment = (committee) => {
  alertify.confirm(
    "Edit Attachment",
    "After editing, Please close the application to apply the changes are you sure you want to edit this attachment?",
    () => {
      config.socket.emit("EDIT_FILE", {
        id: committee.id,
        file_path: committee.file_path,
        type: "committee",
      });
    },
    () => {}
  );
};

const updateAttachmentData = async (id) => {
  try {
    const response = await axios(`/api/committee-update-attachment/${id}`);
    if (response.status === 200) {
      notyf.success(
        "Please refresh the page to apply the modified attachment if the changes are not applied"
      );
      router.reload();
    }
  } catch (error) {
    console.error(error);
  }
};

config.socket.on("EDIT_FILE_COMMITTEE_EXIT", (data) => {
  updateAttachmentData(data.id);
});
</script>

<template>
  <div>
    <div class="row mt-2">
      <div class="col-lg-4">
        <div class="form-group">
          <label class="fw-bold text-dark form-label text-uppercase"
            >Lead Committee</label
          >
          <v-select
            class="text-uppercase"
            :options="agendas"
            v-model="searchLead"
            label="title"
            :reduce="(agendas) => agendas.id"
          >
            <template #option="{ title, chairman_information }">
              <div class="d-flex my-3 align-items-center justify-content-start">
                <div>
                  <img
                    class="img-fluid rounded"
                    :src="`/storage/user-images/${chairman_information.profile_picture}`"
                    style="width: 3vw"
                    alt=""
                  />
                </div>
                <div class="d-flex flex-column ms-2">
                  <strong>{{ title }}</strong>
                  <span>{{ chairman_information.fullname }}</span>
                </div>
              </div>
            </template>
          </v-select>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <label class="fw-bold text-uppercase text-dark form-label"
            >Expanded / Other Committee</label
          >
          <v-select
            class="text-uppercase"
            :options="agendas"
            v-model="searchExpanded"
            label="title"
            :reduce="(agendas) => agendas.id"
          >
            <template #option="{ title, chairman_information }">
              <div class="d-flex my-3 align-items-center justify-content-start">
                <div>
                  <img
                    class="img-fluid rounded"
                    :src="`/storage/user-images/${chairman_information.profile_picture}`"
                    style="width: 3vw"
                    alt=""
                  />
                </div>
                <div class="d-flex flex-column ms-2">
                  <strong>{{ title }}</strong>
                  <span>{{ chairman_information.fullname }}</span>
                </div>
              </div>
            </template>
          </v-select>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <label class="fw-bold text-dark form-label text-uppercase"
            >Available Schedules</label
          >
          <v-select
            id="availableSession"
            v-model="searchSession"
            class="text-uppercase"
            :options="availableRegularSessions"
            :get-option-label="(option) => option.reference_session + ' - ' + option.type"
            :reduce="(schedule) => schedule.reference_session + ' - ' + schedule.type"
          >
          </v-select>
        </div>
      </div>
    </div>
    <div class="mt-2 d-flex justify-content-between">
      <div class="mb-0">
        <h5 class="fw-bolder text-uppercase">
          total records [ {{ committees.total }} Entry / Entries ]
        </h5>
      </div>
      <div class="mb-0">
        <button
          data-bs-target="#addNewCommittee"
          data-bs-toggle="modal"
          class="btn btn-primary shadow-lg text-uppercase fw-bold letter-spacing-1"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-plus-circle me-1"
            viewBox="0 0 16 16"
          >
            <path
              d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
            />
            <path
              d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
            />
          </svg>
          Add New Committee
        </button>
      </div>
    </div>
    <table class="table border table-hover" id="committees-table">
      <thead>
        <tr class="bg-light">
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Lead committee
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Guests
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center text-truncate"
          >
            Session
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Veneu
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Status
          </th>

          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center text-truncate"
          >
            Created At
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Actions
          </th>
        </tr>
      </thead>
      <tbody v-if="committees.data.length !== 0">
        <tr
          v-for="(committee, index) in committees.data"
          :key="index.id"
          class="bg-light"
        >
          <td class="text-start text-uppercase align-middle">
            <span
              class="me-2 badge bg-primary shadow-sm fw-bold"
              style="letter-spacing: 1px"
              v-if="isRecordNew(committee)"
            >
              new
              <br />
            </span>
            <span
              @click="showMembers(committee, 'lead_committee')"
              class="text-truncate cursor-pointer fw-bold letter-spacing-1"
            >
              {{
                truncateText(
                  committee?.lead_committee_information?.title
                    ?.toLowerCase()
                    ?.replace("committee on", ""),
                  50
                )
              }}
            </span>
            <small v-if="committee?.expanded_committee_information">
              <br />
              <span
                @click="showMembers(committee, 'expanded_committee')"
                class="cursor-pointer fw-bold text-primary"
              >
                {{
                  truncateText(
                    committee?.expanded_committee_information?.title
                      ?.toLowerCase()
                      ?.replace("committee on ", ""),
                    50
                  )
                }}
              </span></small
            >
            <small v-if="committee?.other_expanded_committee_information">
              <br />
              <span
                @click="showMembers(committee, 'expanded_committee_2')"
                class="cursor-pointer fw-bold text-primary"
              >
                {{
                  truncateText(
                    committee?.other_expanded_committee_information?.title
                      ?.toLowerCase()
                      ?.replace("committee on", ""),
                    50
                  )
                }}
              </span>
            </small>
          </td>
          <td class="text-center text-dark fw-bold">
            {{ committee.committee_invited_guests_count }}
          </td>
          <td class="text-uppercase text-start text-truncate text-dark fw-bold">
            <span class="ms-4" v-if="committee?.schedule_information">
              {{ committee?.schedule_information?.reference_session }} -
              {{ committee?.schedule_information?.type }}
            </span>
          </td>
          <td class="text-uppercase text-dark fw-bold">
            {{ committee?.schedule_information?.schedule_venue?.name }}
          </td>
          <td class="text-center">
            <span
              v-if="committee.status === 'approved'"
              class="badge bg-success text-uppercase"
              >{{ committee.status }}</span
            >
            <span
              v-if="committee.status === 'review'"
              class="badge bg-primary text-uppercase"
              >{{ committee.status }}</span
            >
            <span
              v-if="committee.status === 'returned'"
              class="badge bg-primary text-uppercase"
              >{{ committee.status }}</span
            >
          </td>
          <td class="text-center text-truncate">
            {{ moment(committee.created_at).format("YYYY-MM-DD hh:mm A") }}
          </td>
          <td>
            <div class="text-center">
              <div class="dropdown">
                <button
                  class="btn btn-dark dropdown-toggle"
                  type="button"
                  id="dropdownMenuButton1"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  Actions
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-chevron-down"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"
                    />
                  </svg>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                  <li>
                    <button
                      class="dropdown-item"
                      @click="editCommittee(committee)"
                      data-bs-toggle="modal"
                      data-bs-target="#editCommitteeModal"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-pencil mx-1"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"
                        />
                      </svg>
                      Edit Committee
                    </button>
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <button class="dropdown-item" @click="editAttachment(committee)">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-file-word mx-1"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M4.879 4.515a.5.5 0 0 1 .606.364l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 7.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 0 1 .364-.606z"
                        />
                        <path
                          d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1"
                        />
                      </svg>
                      Edit Attachment
                    </button>
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <a
                      data-bs-target="#viewFileModal"
                      data-bs-toggle="modal"
                      @click="viewSelectedFile(committee.file)"
                      class="dropdown-item cursor-pointer"
                      target="_blank"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-file-break mx-1"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M0 10.5a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5M12 0H4a2 2 0 0 0-2 2v7h1V2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v7h1V2a2 2 0 0 0-2-2m2 12h-1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-2H2v2a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2z"
                        />
                      </svg>
                      Preview Attachment</a
                    >
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <a
                      class="dropdown-item"
                      :href="`/committee-file/${committee.id}/download`"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-cloud-arrow-down mx-1"
                        viewBox="0 0 16 16"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z"
                        />
                        <path
                          d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"
                        />
                      </svg>
                      Download Attachment</a
                    >
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <button
                      v-if="committee?.file_link?.view_link"
                      class="dropdown-item btn-inspect-link"
                      @click="copyPublicLinkToClipboard(committee?.file_link?.view_link)"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-link-45deg mx-1"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"
                        />
                        <path
                          d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243z"
                        />
                      </svg>
                      Copy Public Link
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr class="bg-light">
          <td
            colspan="8"
            class="text-center fw-bold text-uppercase text-danger h5 letter-spacing-1"
          >
            No Committees Found
          </td>
        </tr>
      </tbody>
    </table>
    <pagination :records="committees" :link="committees.path" />
  </div>
</template>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}

.letter-spacing-1 {
  letter-spacing: 1px;
}
</style>
