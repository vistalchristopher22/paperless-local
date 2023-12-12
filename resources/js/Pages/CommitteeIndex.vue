<script>
import Layout from "@pages/Layout.vue";
import Agenda from "@components/Agenda.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import axios from "axios";
import AgendaMembers from "@components/AgendaMembers.vue";
import { getBaseURL } from "@common/helpers";

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
  },
  layout: Layout,
  components: {
    Link,
    Agenda,
    AgendaMembers,
    FullScreenLoader,
    AgendaMembers,
  },
  setup(props) {
    const baseURL = getBaseURL;
    const processing = ref(false);
    const displayMembers = ref(false);
    const fetchedMembers = ref([]);

    const viewLink = (link) => {
      console.log(link);
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

    const fetchCommittees = (url) => router.visit(url);

    return {
      processing,
      displayMembers,
      fetchedMembers,
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
    <div class="card-body">
      <div class="row mt-2">
        <div class="col-lg-4">
          <div class="form-group">
            <label class="fw-medium text-dark form-label">Lead Committee</label>
            <select id="filterLeadCommitee" class="form-control" style="width: 100%">
              <option value="*">All</option>
              <option :value="agenda.id" v-for="agenda in agendas" :key="agenda.id">
                {{ agenda.title }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label class="fw-medium text-dark form-label">Expanded Committee</label>
            <select id="filterExpandedCommittee" class="form-select" style="width: 100%">
              <option value="*">All</option>
              <option :value="agenda.id" v-for="agenda in agendas" :key="agenda.id">
                {{ agenda.title }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label class="fw-medium text-dark form-label">Available Sessions</label>
            <select id="availableSession" class="form-select" style="width: 100%">
              <option value="*">All</option>
              <option
                :value="availableRegularSessions.id"
                v-for="(availableRegularSessions, index) in availableRegularSessions"
                :key="index"
              >
                {{ availableSession.number }} Regular Session -
                {{ availableSession.year }}
              </option>
            </select>
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
    <div class="">
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
            <!-- <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Other Expanded committee
            </th> -->
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
            <!-- <td
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
            </td> -->
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
                      <a class="dropdown-item" :href="`committee/${committee.id}/edit`"
                        >Edit Committee</a
                      >
                    </li>
                    <li>
                      <button
                        class="dropdown-item btn-inspect-link"
                        @click="viewLink(committee?.file_link?.view_link)"
                      >
                        Inspect Link
                      </button>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a
                        class="dropdown-item"
                        :href="`committee-invited-guest/${committee.id}`"
                        >Add Invited Guest</a
                      >
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a
                        :href="`/committee-file/${committee.id}`"
                        class="dropdown-item"
                        target="_blank"
                        >View File</a
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
                      <a
                        class="dropdown-item"
                        :href="`committee-file/${committee.id}/download`"
                        >Download File</a
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
