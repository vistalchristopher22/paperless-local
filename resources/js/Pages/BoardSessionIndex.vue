<script>
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link, router } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import { ref } from "vue";
import { getName } from "@common/helpers";
import moment from "moment";

export default {
  props: {
    boardSessions: {
      required: true,
    },
  },
  layout: Layout,
  components: {
    Link,
    FullScreenLoader,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const displayAgenda = ref(false);
    const agendas = ref([]);
    const processing = ref(false);
    const selectedMember = ref(null);

    return {
      processing,
      getName,
      moment,
    };
  },
};
</script>

<template>
  <div>
    <FullScreenLoader :processing="processing" />
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div>
        <h5 class="fw-bolder text-uppercase">
          total records [ {{ boardSessions.total }} Entry / Entries ]
        </h5>
      </div>
      <div>
        <Link href="#" class="btn btn-dark shadow">
          <i class="mdi mdi-plus-circle me-1"></i>
          Add New Order of Business
        </Link>
      </div>
    </div>
    <div>
      <table class="table table-hover border table-bordered">
        <thead>
          <tr class="bg-light">
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Order Business Title
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Regular Session
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Filename
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
        <tbody>
          <tr v-for="board_session in boardSessions.data" :key="board_session.id">
            <td class="text-capitalize">
              <span class="ms-2">{{ board_session.title }}</span>
            </td>
            <td>{{ board_session.schedule }}</td>
            <td class="text-center">
              <span class="fw-bold text-decoration-underline">{{
                getName(board_session.file_path)
              }}</span>
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
                    <a href="#" class="dropdown-item">Edit Session</a>
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <!-- {{ $boardSession?->file_link->view_link }} -->
                    <button class="dropdown-item btn-inspect-link" data-view-link="#">
                      Inspect Link
                    </button>
                  </li>
                  <li>
                    <a href="#">
                      <!-- {{ $boardSession->file_path }} -->
                      <!-- {{ $boardSession->id }} -->
                      <span
                        class="dropdown-item text-decoration-none fw-medium text-capitalize cursor-pointer btn-view-file"
                        data-path=""
                        data-id=""
                        >Edit File
                      </span>
                    </a>
                  </li>
                  <li>
                    <!-- {{ route('board-sessions.show', $boardSession->id) }} -->
                    <a href="" target="_blank" class="dropdown-item">View File</a>
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <!-- {{ $boardSession->id }} -->
                    <a
                      data-id=""
                      class="dropdown-item btn-delete-session cursor-pointer text-danger"
                    >
                      Delete Session
                    </a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
