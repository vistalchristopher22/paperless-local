<script>
import Layout from "@pages/Layout.vue";
import Widget from "@components/Widgets.vue";
import { router } from "@inertiajs/vue3";
import { getBaseURL } from "@common/helpers";
export default {
  props: [
    "reviewCommittees",
    "returnedCommittees",
    "todaysSchedule",
    "activeUsers",
    "loginHistories",
    "submittedCommittees",
  ],
  layout: Layout,
  components: {
    Widget,
  },
  setup(props) {
    const baseURL = getBaseURL;

    const fetchLoginHistories = (url) => router.visit(url);
    return {
      baseURL,
      fetchLoginHistories,
    };
  },
};
</script>

<template>
  <div>
    <div class="row">
      <Widget text="REVIEW COMMITTEES" :data="reviewCommittees" class="col-lg-3" />
      <Widget text="RETURNED COMMITTEES" :data="returnedCommittees" class="col-lg-3" />
      <Widget text="TODAY'S SCHEDULE" :data="todaysSchedule" class="col-lg-3" />
      <Widget text="ONLINE USERS" :data="activeUsers" class="col-lg-3" />
    </div>

    <div class="">
      <div class="mb-1 justify-content-between align-items-center d-flex">
        <h6 class="card-title m-0 p-1 text-dark">
          Submitted Committees [ {{ submittedCommittees.total }} Entries]
          <span class="text-warning">
            <small> - (review)</small>
          </span>
        </h6>
      </div>
    </div>
    <div class="">
      <table class="table table-hover border" width="100%">
        <thead>
          <tr class="bg-light">
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Name
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Lead Committee
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Expanded Committee
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              submitted at
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              submitted by
            </th>
            <th
              class="border text-center text-white bg-dark border border-dark text-uppercase"
            >
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="submittedCommittee in submittedCommittees.data"
            :key="submittedCommittee.id"
          >
            <td>{{ submittedCommittee.name }}</td>
            <td>{{ submittedCommittee?.lead_committee_information?.title }}</td>
            <td>
              {{ submittedCommittee?.expanded_committee_information?.title || "-" }}
            </td>
            <td class="text-center">{{ submittedCommittee.created_at }}</td>
            <td class="text-center">{{ submittedCommittee?.submitted?.fullname }}</td>
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
                    <li><a class="dropdown-item" href="">Edit Committee</a></li>
                    <li>
                      <button class="dropdown-item btn-inspect-link" data-view-link="">
                        Inspect Link
                      </button>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="">Add Invited Guest</a></li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a href="" class="dropdown-item" target="_blank">View File</a>
                    </li>
                    <li>
                      <button class="dropdown-item btn-edit" data-id="">Edit File</button>
                    </li>

                    <li><a class="dropdown-item" href="">Download File</a></li>
                    <li class="dropdown-divier"></li>
                    <li>
                      <a class="dropdown-item" href=""> Delete Committee </a>
                    </li>
                  </ul>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end me-2">
          <li class="page-item" :class="{ disabled: !submittedCommittees.prev_page_url }">
            <a
              class="page-link"
              href="#"
              @click="fetchLoginHistories(submittedCommittees.prev_page_url)"
            >
              Previous
            </a>
          </li>
          <li
            class="page-item"
            v-for="page in submittedCommittees.last_page"
            :key="page"
            :class="{ active: page === submittedCommittees.current_page }"
          >
            <a
              class="page-link"
              href="#"
              @click="
                fetchLoginHistories(
                  `${baseURL}/administrator/home?submittedCommitteesPage=${page}`
                )
              "
            >
              {{ page }}
            </a>
          </li>
          <li class="page-item" :class="{ disabled: !submittedCommittees.next_page_url }">
            <a
              class="page-link"
              href="#"
              @click="submittedCommittees(submittedCommittees.next_page_url)"
            >
              Next
            </a>
          </li>
        </ul>
      </nav>
    </div>

    <div class="table-responsive">
      <div class="mb-1 justify-content-between align-items-center d-flex">
        <h6 class="card-title text-dark h6">
          Login History [ {{ loginHistories.total }} Entries ]
        </h6>
      </div>
      <table class="table table-hover border">
        <thead>
          <tr class="bg-light">
            <th
              class="fw-medium text-center bg-dark text-white text-uppercase border border-dark"
            >
              User
            </th>
            <th
              class="fw-medium text-center bg-dark text-white text-uppercase border border-dark"
            >
              Account Type
            </th>
            <th
              class="fw-medium text-center bg-dark text-white text-uppercase border border-dark"
            >
              IP Address
            </th>
            <th
              class="fw-medium text-center bg-dark text-white text-uppercase border border-dark"
            >
              Action Type
            </th>
            <th
              class="fw-medium text-center bg-dark text-white text-uppercase border border-dark"
            >
              Timestamp
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="history in loginHistories.data" :key="history.id">
            <td class="text-dark text-center p-3">
              <span class="mx-1"></span>{{ history.user.fullname }}
            </td>
            <td class="text-dark text-center">
              <span class="badge badge-soft-primary">
                {{ history.user.account_type }}
              </span>
            </td>
            <td class="text-dark text-center">
              {{ history.ip_address }}
            </td>
            <td class="text-dark text-center text-uppercase">
              <span
                v-if="history.type.toLowerCase().includes('in')"
                class="badge bg-soft-success"
              >
                LOGGED IN
              </span>
              <span v-else class="badge bg-soft-danger"> LOGGED OUT </span>
            </td>
            <td class="text-dark text-center">
              {{ history.logged_in_at }}
            </td>
          </tr>
        </tbody>
      </table>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end me-2">
          <li class="page-item" :class="{ disabled: !loginHistories.prev_page_url }">
            <a
              class="page-link"
              href="#"
              @click="fetchLoginHistories(loginHistories.prev_page_url)"
            >
              Previous
            </a>
          </li>
          <li
            class="page-item"
            v-for="page in loginHistories.last_page"
            :key="page"
            :class="{ active: page === loginHistories.current_page }"
          >
            <a
              class="page-link"
              href="#"
              @click="
                fetchLoginHistories(
                  `${baseURL}/administrator/home?loginHistoryPage=${page}`
                )
              "
            >
              {{ page }}
            </a>
          </li>
          <li class="page-item" :class="{ disabled: !loginHistories.next_page_url }">
            <a
              class="page-link"
              href="#"
              @click="fetchLoginHistories(loginHistories.next_page_url)"
            >
              Next
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>
<style scoped></style>
