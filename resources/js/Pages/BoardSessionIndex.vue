<script>
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link, router } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import { ref, watch } from "vue";
import { getName, removeFileExtension, removeTimestampPrefix } from "@common/helpers";
import moment from "moment";
import { VuePDF, usePDF } from "@tato30/vue-pdf";

export default {
  props: {
    boardSessions: {
      required: true,
    },
  },
  layout: Layout,
  components: {
    Link,
    VuePDF,
    FullScreenLoader,
  },
  setup(props) {
    const selectedFile = ref(null);
    const notyf = new Notyf({
      duration: 4000,
    });
    const processing = ref(false);
    const inspectLink = ref("");

    const page = ref(1);
    const { pdf, pages } = usePDF(
      "https://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf"
    );

    const getExtension = (filename) => {
      const parts = filename.split(".");
      return parts[parts.length - 1];
    };

    const viewFile = (file) => {
      // reset the page value to 1
      page.value = 1;
      selectedFile.value = file;
      let extension = getExtension(file.file);
      const { pdf: newPDFToLoad, pages: newPages } = usePDF({
        url: `/storage/committees/${file.file.replace(extension, "pdf")}`,
      });

      watch(newPDFToLoad, () => {
        pdf.value = newPDFToLoad.value;
      });

      watch(newPages, () => {
        pages.value = newPages.value;
      });
    };

    const viewLink = (link) => {
      console.log(link);
      if (link) {
        inspectLink.value = link;
      } else {
        inspectLink.value = "NO LINK AVAILABLE";
      }
    };

    const windowWidth = ref(window.innerWidth);

    const pagePrevious = () => {
      page.value = page.value > 1 ? page.value - 1 : page.value;
    };

    const pageNext = () => {
      page.value = page.value < pages.value ? page.value + 1 : page.value;
    };

    const onAnnotation = (annotation) => {
      console.log(annotation);
    };

    return {
      onAnnotation,
      windowWidth,
      processing,
      moment,
      inspectLink,
      pdf,
      getName,
      removeFileExtension,
      removeTimestampPrefix,
      pages,
      page,
      selectedFile,
      viewFile,
      viewLink,
      pagePrevious,
      pageNext,
    };
  },
};
</script>

<template>
  <div>
    <FullScreenLoader :processing="processing" />
    <div
      class="modal fade"
      id="exampleModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h6 class="modal-title m-0" id="exampleModalCenterTitle">File Link</h6>
            <button
              type="button"
              class="btn-close text-white"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <!--end modal-header-->
          <div class="modal-body">
            <div class="row">
              <!--end col-->
              <div class="col-lg-12">
                <h5 class="text-center fw-bold">
                  {{ inspectLink }}
                </h5>
              </div>
              <!--end col-->
            </div>
            <!--end row-->
          </div>
          <!--end modal-body-->
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-soft-secondary btn-sm"
              data-bs-dismiss="modal"
            >
              Close
            </button>
          </div>
          <!--end modal-footer-->
        </div>
        <!--end modal-content-->
      </div>
      <!--end modal-dialog-->
    </div>

    <div
      class="modal fade"
      id="viewFileModal"
      tabindex="-1"
      aria-labelledby="viewFileModalTitle"
      aria-hidden="true"
    >
      <div
        class="modal-dialog"
        style="max-width: 90vw; width: 90vw; max-height: 90vh; height: 90vh"
      >
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title" id="viewFileModalTitle">
              File Preview Page : {{ page }}
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body d-flex justify-content-between">
            <button class="border px-2" @click="pagePrevious">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="currentColor"
                class="bi bi-chevron-left"
                viewBox="0 0 16 16"
              >
                <path
                  fill-rule="evenodd"
                  d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"
                />
              </svg>
            </button>
            <div class="d-flex flex-column justify-content-center">
              <h3 class="text-center fw-bold text-dark">
                Page : {{ page }} / {{ pages }}
              </h3>
              <div>
                <VuePDF
                  :pdf="pdf"
                  :page="page"
                  :scale="windowWidth / 1000"
                  annotation-layer
                  @annotation="onAnnotation"
                />
              </div>
            </div>
            <button class="border px-2" @click="pageNext">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="currentColor"
                class="bi bi-chevron-right"
                viewBox="0 0 16 16"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"
                />
              </svg>
            </button>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-2">
      <div>
        <h5 class="fw-bolder text-uppercase">
          total records [ {{ boardSessions.total }} Entry / Entries ]
        </h5>
      </div>
      <div>
        <Link href="/board-sessions/create" class="btn btn-dark shadow">
          <i class="mdi mdi-plus-circle me-1"></i>
          Add New Order of Business
        </Link>
      </div>
    </div>
    <div>
      <table class="table table-hover border table-striped">
        <thead>
          <tr>
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
            <td class="text-uppercase">
              <span class="ms-2">{{ board_session.title }}</span>
            </td>
            <td class="text-center text-uppercase">
              {{ board_session?.schedule_information?.reference_session }} -
              {{ board_session?.schedule_information?.type }} -
              {{ board_session?.schedule_information?.schedule_venue?.name }}
            </td>
            <td class="text-start">
              <span
                v-if="board_session.file_path"
                data-bs-target="#viewFileModal"
                data-bs-toggle="modal"
                @click="viewFile(board_session)"
                class="fw-bold text-decoration-underline cursor-pointer"
                >{{ removeTimestampPrefix(getName(board_session.file_path)) }}</span
              >
              <span v-else class="text-danger">N/A</span>
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
                    <Link
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
                    </Link>
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <button
                      class="dropdown-item btn-inspect-link"
                      data-bs-toggle="modal"
                      data-bs-target="#exampleModalCenter"
                      @click="viewLink(board_session?.file_link?.view_link)"
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
                      Public Link
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
                        Edit Document
                      </span>
                    </a>
                  </li>
                  <!-- <li class="dropdown-divider"></li> -->
                  <!-- <li>
                    <a
                      data-id=""
                      class="dropdown-item btn-delete-session cursor-pointer text-danger"
                    >
                      Delete Session
                    </a>
                  </li> -->
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
