<script>
import Layout from "@pages/Layout.vue";
import Agenda from "@components/Agenda.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AgendaMembers from "@components/AgendaMembers.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import axios from "axios";
import { getBaseURL } from "@common/helpers";
import { Notyf } from "notyf";
import vSelect from "vue-select";

export default {
  props: {
    committees: {
      required: true,
    },
    agendas: {
      required: true,
    },
    availableRegularSessions: {
      required: true,
    },
    searchLead: {
      required: true,
    },
    searchExpanded: {
      required: true,
    },
  },
  layout: Layout,
  components: {
    Link,
    vSelect,
    Agenda,
    AgendaMembers,
    FullScreenLoader,
    AgendaMembers,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const processing = ref(false);
    const displayMembers = ref(false);
    const fetchedMembers = ref([]);
    const inspectLink = ref("");
    const searchExpanded = ref(parseInt(props.searchExpanded) || "");
    const searchLead = ref(parseInt(props.searchLead) || "");
    const viewLink = (link) => {
      if (link) {
        inspectLink.value = link;
      } else {
        inspectLink.value = "NO LINK AVAILABLE";
      }
    };

    const showMembers = (committee, type) => {
      if (committee) {
        processing.value = true;
        axios.get(`/api/agenda-members/${committee[type]}`).then((response) => {
          if (response.status === 200) {
            displayMembers.value = true;
            processing.value = false;
            fetchedMembers.value = response.data.agenda;
          }
        });
      }
    };

    const truncateText = (text, maxLength) => {
      if (!text) return;
      if (text.length > maxLength) {
        return text.substring(0, maxLength) + "...";
      }
      return text;
    };

    watch(searchLead, (newValue, oldValue) => {
      processing.value = true;
      router.visit(
        `/committee/?lead=${searchLead.value || ""}&expanded=${
          searchExpanded.value || ""
        }`
      );
    });

    watch(searchExpanded, (newValue, oldValue) => {
      processing.value = true;
      router.visit(
        `/committee/?lead=${searchLead.value || ""}&expanded=${
          searchExpanded.value || ""
        }`
      );
    });

    const fetchCommittees = (url) => router.visit(url);

    return {
      processing,
      displayMembers,
      fetchedMembers,
      inspectLink,
      searchLead,
      searchExpanded,
      viewLink,
      truncateText,
      showMembers,
      fetchCommittees,
    };
  },
};
</script>

<template>
  <div>
    <FullScreenLoader :processing="processing" />
    <AgendaMembers :displayMembers="displayMembers" :fetchedMembers="fetchedMembers" />

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

    <div class="card-body">
      <div class="row mt-2">
        <div class="col-lg-4">
          <!-- v-model="committee.lead_committee"
              :class="{ 'outline-none border-danger rounded': errors?.lead_committee }" -->
          <div class="form-group">
            <label class="fw-medium text-dark form-label">Lead Committee</label>
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
            <label class="fw-medium text-dark form-label"
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
            <label class="fw-medium text-dark form-label">Available Sessions</label>
            <v-select id="availableSession">
              <option value="*">All</option>
              <option
                :value="availableRegularSessions.id"
                v-for="(availableRegularSessions, index) in availableRegularSessions"
                :key="index"
              >
                {{ availableSession.number }} Regular Session -
                {{ availableSession.year }}
              </option>
            </v-select>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-lg-12">
          <div class="form-group">
            <label class="form-label fw-medium text-dark">Search by Content</label>
            <input
              id="filterByContent"
              class="form-control"
              placeholder="Enter phrase or word"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div>
        <h5 class="fw-bolder text-uppercase"></h5>
      </div>
      <div class="mt-2">
        <Link href="/committee/create" class="btn btn-dark shadow">
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
          Add New Committee</Link
        >
      </div>
    </div>
    <div>
      <table class="table table-bordered" id="committees-table" width="100%">
        <thead>
          <tr class="bg-light">
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Name
            </th>
            <!-- <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-truncate"
            >
              Submitted By
            </th> -->
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Lead committee
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Expanded committee
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Other Expanded committee
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-truncate"
            >
              Regular Session
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Status
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-truncate"
            >
              Submitted At
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(committee, index) in committees.data" :key="index.id">
            <td class="text-uppercase text-start">{{ committee.name }}</td>
            <!-- <td class="text-center">
              {{ committee?.submitted?.fullname }}
            </td> -->
            <td class="text-start text-capitalize text-decoration-underline fw-bold">
              <span
                @click="showMembers(committee, 'lead_committee')"
                class="text-truncate cursor-pointer"
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
            </td>
            <td
              class="text-start text-capitalize text-decoration-underline fw-bold text-truncate"
            >
              <span
                @click="showMembers(committee, 'expanded_committee')"
                class="cursor-pointer"
              >
                {{
                  truncateText(
                    committee?.expanded_committee_information?.title
                      ?.toLowerCase()
                      ?.replace("committee on ", ""),
                    50
                  )
                }}
              </span>
            </td>
            <td
              class="text-start text-capitalize text-decoration-underline fw-bold text-truncate"
            >
              <span
                @click="showMembers(committee, 'expanded_committee_2')"
                class="cursor-pointer"
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
            </td>
            <td class="text-center"></td>
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
            <td class="text-center">
              {{ committee.submitted_at }}
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
                  <ul
                    class="dropdown-menu"
                    aria-labelledby="dropdownMenuButton1"
                    style=""
                  >
                    <li>
                      <Link
                        class="dropdown-item"
                        :href="`/committee/${committee.id}/edit`"
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
                      </Link>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="text-center">
                      <a
                        class="dropdown-item"
                        :href="`committee-invited-guest/${committee.id}`"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-people mx-1"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"
                          />
                        </svg>
                        Add Invited Guest</a
                      >
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a
                        :href="`/committee-file/${committee.id}`"
                        class="dropdown-item"
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
                        View File</a
                      >
                    </li>
                    <!-- <li>
                      <button
                        class="dropdown-item btn-edit"
                        data-id="{{ $committee->id }}"
                      >
                        Edit File
                      </button>
                    </li> -->
                    <li>
                      <button
                        v-if="committee?.file_link?.view_link"
                        class="dropdown-item btn-inspect-link"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalCenter"
                        @click="viewLink(committee?.file_link?.view_link)"
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
                        Inspect Link
                      </button>
                    </li>
                    <li>
                      <a
                        class="dropdown-item"
                        :href="`committee-file/${committee.id}/download`"
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
                    <li class="dropdown-divier"></li>
                    <!-- <li>
                      <form
                        action="{{ route('committee.destroy', $committee->id) }}"
                        method="POST"
                        id="deleteCommitteeForm-{{ $committee->id }}"
                      >
                        <button
                          type="button"
                          class="dropdown-item text-danger btn-delete-committee"
                          data-id="{{ $committee->id }}"
                        >
                          Delete Committee
                        </button>
                      </form>
                    </li> -->
                  </ul>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end me-2">
          <li class="page-item" :class="{ disabled: !committees.prev_page_url }">
            <a
              class="page-link"
              href="#"
              @click="fetchCommittees(committees.prev_page_url)"
            >
              Previous
            </a>
          </li>
          <li
            class="page-item"
            v-for="page in committees.last_page"
            :key="page"
            :class="{ active: page === committees.current_page }"
          >
            <a
              class="page-link"
              href="#"
              @click="fetchCommittees(`/committee/?page=${page}`)"
            >
              {{ page }}
            </a>
          </li>
          <li class="page-item" :class="{ disabled: !committees.next_page_url }">
            <a
              class="page-link"
              href="#"
              @click="fetchCommittees(committees.next_page_url)"
            >
              Next
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>
<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
