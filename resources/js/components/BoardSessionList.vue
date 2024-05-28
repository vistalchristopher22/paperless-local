<script setup>
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AddBoardSessionModal from "@components/AddBoardSessionModal.vue";
import EditBoardSessionModal from "@components/EditBoardSessionModal.vue";
import ViewLinkModal from "@components/ViewLinkModal.vue";
import { Link, router } from "@inertiajs/vue3";
import { defineComponent, ref, watch, inject, provide } from "vue";
import { getName, removeTimestampPrefix, isRecordNew, getBaseURL } from "@common/helpers";
import moment from "moment";
import Pagination from "@components/Pagination.vue";
import vSelect from "vue-select";
import { Notyf } from "notyf";
const config = inject("$config");

import {
  AVAILABLE_SESSION_SCHEDULES,
  VIEW_SELECTED_FILE,
  SEARCH_SCHEDULE_SESSION,
} from "@/contants/injectKeys";

const props = defineProps({
  boardSessions: {
    required: true,
  },
});

defineComponent({
  Link,
  Pagination,
  FullScreenLoader,
  AddBoardSessionModal,
  EditBoardSessionModal,
  ViewLinkModal,
  vSelect,
});

const viewSelectedFile = inject(VIEW_SELECTED_FILE);
const availableRegularSessions = inject(AVAILABLE_SESSION_SCHEDULES);
const searchSession = inject(SEARCH_SCHEDULE_SESSION);

const selectedBoardSession = ref({});
const processing = ref(false);
const inspectLink = ref("");
const notyf = new Notyf({
  duration: 4000,
  position: {
    x: "right",
    y: "bottom",
  },
});

const viewLink = (link) => {
  if (link) {
    inspectLink.value = `${getBaseURL()}${link}`;
  } else {
    inspectLink.value = "NO LINK AVAILABLE";
  }
};

watch(searchSession, (newValue) => {
  let fragment = window.location.hash || "";
  if (newValue) {
    processing.value = true;
    router.visit("/committee?schedule=" + newValue + fragment);
  }
});

const editBoardSession = (boardSession) => {
  selectedBoardSession.value = boardSession;
};

const copyPublicLinkToClipboard = (link) => {
  navigator.clipboard.writeText(`${getBaseURL()}${link}`);
  notyf.success("Link copied to clipboard");
};

const editAttachment = (boardSession) => {
  alertify.confirm(
    "Edit File",
    "After editing, Please close the application to apply the changes are you sure you want to edit this File?",
    () => {
      config.socket.emit("EDIT_FILE", {
        id: boardSession.id,
        file_path: boardSession.file_path,
        type: "order_of_business",
      });
    },
    () => {}
  );
};

const updateAttachmentData = async (id) => {
  try {
    const response = await axios(`/api/order-of-business-update-attachment/${id}`);
    if (response.status === 200) {
      notyf.success(
        "Please refresh the page to apply the modified file if the changes are not applied"
      );
      router.reload();
    }
  } catch (error) {
    console.error(error);
  }
};

config.socket.on("EDIT_FILE_ORDER_OF_BUSINESS_EXIT", (data) => {
  updateAttachmentData(data.id);
});
</script>

<template>
  <div>
    <FullScreenLoader :processing="processing" />
    <AddBoardSessionModal />
    <EditBoardSessionModal :boardSession="selectedBoardSession" />
    <ViewLinkModal :link="inspectLink" />
    <div class="col-lg-12 mb-2">
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
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div>
        <h5 class="fw-bolder text-uppercase">
          total records [ {{ boardSessions.total }} Entry / Entries ]
        </h5>
      </div>
      <div>
        <button
          data-bs-target="#addBoardSessionModal"
          data-bs-toggle="modal"
          class="btn btn-primary shadow text-uppercase fw-bold"
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
          Add New Order of Business
        </button>
      </div>
    </div>
    <div>
      <table class="table table-hover border">
        <thead>
          <tr>
            <th class="border text-white bg-dark border border-dark">&nbsp;</th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Order Business Title
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-start"
            >
              Session
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Venue
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Created At
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              Actions
            </th>
          </tr>
        </thead>
        <tbody v-if="boardSessions.data.length !== 0">
          <tr
            v-for="board_session in boardSessions.data"
            :key="board_session.id"
            class="bg-light"
          >
            <td style="width: 20px">
              <span
                class="badge bg-primary shadow fw-bold text-uppercase"
                style="letter-spacing: 1px"
                v-if="isRecordNew(board_session)"
              >
                new
              </span>
            </td>
            <td>
              <span
                class="text-uppercase fw-bold"
                :class="{
                  'text-danger': !board_session.file_path,
                }"
              >
                {{ board_session.title }}</span
              >
              <div v-if="board_session.file_path" class="d-flex align-items-center">
                <div>
                  <span
                    data-bs-target="#viewFileModal"
                    data-bs-toggle="modal"
                    @click="viewSelectedFile(board_session.file)"
                    class="cursor-pointer fw-bold text-primary highlight"
                  >
                    <i class="mdi mdi-paperclip"></i>
                    {{ removeTimestampPrefix(getName(board_session.file_path)) }}
                  </span>
                </div>
              </div>
              <div v-else>-</div>
            </td>
            <td class="text-start text-uppercase">
              <span class="text-dark fw-bold" v-if="board_session?.schedule_information">
                {{ board_session?.schedule_information?.reference_session }} -
                {{ board_session?.schedule_information?.type }}
              </span>
            </td>
            <td class="text-dark fw-bold text-uppercase text-center">
              {{ board_session?.schedule_information?.schedule_venue?.name }}
            </td>
            <td class="text-center">
              {{ moment(board_session.created_at).format("YYYY-MM-DD hh:mm A") }}
            </td>
            <td class="text-center">
              <div
                class="dropdown"
                data-id="{{ $boardSession->id }}"
                data-file-path="{{ $boardSession->file_path }}"
              >
                <button
                  class="btn btn-dark dropdown-toggle fw-medium"
                  type="button"
                  id="dropdownAction"
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
                <ul class="dropdown-menu" aria-labelledby="dropdownAction" style="">
                  <li>
                    <button
                      @click="editBoardSession(board_session)"
                      data-bs-target="#editBoardSessionModal"
                      data-bs-toggle="modal"
                      :href="`/board-sessions/${board_session.id}/edit`"
                      class="dropdown-item"
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
                      Edit Order of Business
                    </button>
                  </li>
                  <li class="dropdown-divider" v-if="board_session.file"></li>
                  <li v-if="board_session.file">
                    <button
                      class="dropdown-item btn-inspect-link"
                      data-bs-target="#viewFileModal"
                      data-bs-toggle="modal"
                      @click="viewSelectedFile(board_session.file)"
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
                      Preview File
                    </button>
                  </li>
                  <li class="dropdown-divider" v-if="board_session?.file_path"></li>
                  <li>
                    <a
                      href="#"
                      @click="editAttachment(board_session)"
                      v-if="board_session?.file_path"
                    >
                      <span
                        class="dropdown-item text-decoration-none fw-medium text-capitalize cursor-pointer btn-view-file"
                        data-path=""
                        data-id=""
                      >
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
                        Edit File
                      </span>
                    </a>
                  </li>
                  <li class="dropdown-divider" v-if="board_session?.file_path"></li>
                  <li v-if="board_session?.file_path">
                    <a
                      class="dropdown-item"
                      :href="`/order-business-file/download/${board_session.id}`"
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
                      Download File</a
                    >
                  </li>

                  <li
                    class="dropdown-divider"
                    v-if="board_session?.file_link?.view_link"
                  ></li>
                  <li v-if="board_session?.file_link?.view_link">
                    <button
                      class="dropdown-item btn-inspect-link"
                      @click="
                        copyPublicLinkToClipboard(board_session?.file_link?.view_link)
                      "
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-link mx-1"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9c-.086 0-.17.01-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z"
                        />
                        <path
                          d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4.02 4.02 0 0 1-.82 1H12a3 3 0 1 0 0-6z"
                        />
                      </svg>
                      Copy Public Link
                    </button>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr class="bg-light">
            <td
              colspan="6"
              class="text-center fw-bold text-uppercase text-danger h5 letter-spacing"
            >
              No Board Sessions Found
            </td>
          </tr>
        </tbody>
      </table>
      <pagination :records="boardSessions" :link="boardSessions.path" />
    </div>
  </div>
</template>

<style scoped>
.letter-spacing-1 {
  letter-spacing: 0.4px;
}

.highlight:hover {
  border-bottom: 1px solid #0b51b7;
}
</style>
