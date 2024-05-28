<script setup>
import Layout from "@pages/Layout.vue";
import { Link, router } from "@inertiajs/vue3";
import { defineComponent, provide, ref } from "vue";

import FullScreenLoader from "@components/FullScreenLoader.vue";
import AgendaMembers from "@components/AgendaMembers.vue";
import BoardSessionList from "@components/BoardSessionList.vue";
import ViewPDFFile from "@components/ViewPDFFile.vue";
import AddCommitteeModal from "@components/AddCommitteeModal.vue";
import EditCommitteeModal from "@components/EditCommitteeModal.vue";
import CommitteeList from "@components/CommitteeList.vue";

import {
  DISPLAY_MEMBERS,
  FETCHED_MEMBERS,
  PROCESSING,
  SEARCH_EXPANDED_COMMITTEE,
  SEARCH_LEAD_COMMITTEE,
  SEARCH_SCHEDULE_SESSION,
  AVAILABLE_SESSION_SCHEDULES,
  EDIT_COMMITTEE,
  VIEW_SELECTED_FILE,
} from "@/contants/injectKeys";

const props = defineProps({
  committees: {
    required: true,
  },
  agendas: {
    required: true,
  },
  availableRegularSessions: {
    required: true,
  },
  searchLead: {},
  searchExpanded: {},
  searchSchedule: {},
  boardSessions: {
    required: true,
  },
});

defineComponent({
  Link,
  CommitteeList,
  AddCommitteeModal,
  EditCommitteeModal,
  AgendaMembers,
  FullScreenLoader,
  BoardSessionList,
  ViewPDFFile,
});

const selectedCommittee = ref("");
const existingCommittee = ref({});
const fetchedMembers = ref([]);
const displayMembers = ref(false);
const processing = ref(false);

const searchExpanded = ref(parseInt(props.searchExpanded) || "");
const searchLead = ref(parseInt(props.searchLead) || "");
const searchSession = ref(props.searchSchedule || "");
const fragment = window.location.hash;
const editCommittee = (committee) => {
  existingCommittee.value = committee;
};

const viewSelectedFile = (file) => {
  selectedCommittee.value = file;
};

const navigate = (tab) => {
  if (tab === "committee") {
    router.visit("/committee#committees");
  } else {
    router.visit("/committee#order_of_business");
  }
};

const closeAgendaMembers = () => {
  displayMembers.value = false;
};

provide(PROCESSING, processing);
provide(FETCHED_MEMBERS, fetchedMembers);
provide(DISPLAY_MEMBERS, displayMembers);
provide(SEARCH_EXPANDED_COMMITTEE, searchExpanded);
provide(SEARCH_LEAD_COMMITTEE, searchLead);
provide(SEARCH_SCHEDULE_SESSION, searchSession);
provide(AVAILABLE_SESSION_SCHEDULES, props.availableRegularSessions);

provide(EDIT_COMMITTEE, editCommittee);
provide(VIEW_SELECTED_FILE, viewSelectedFile);
</script>

<template>
  <layout>
    <div class="mt-2">
      <FullScreenLoader :processing="processing" />

      <AgendaMembers
        @close-display="closeAgendaMembers"
        :displayMembers="displayMembers"
        :fetchedMembers="fetchedMembers"
      />

      <ViewPDFFile :file="selectedCommittee" />

      <AddCommitteeModal :agendas="agendas" />
      <EditCommitteeModal :agendas="agendas" :existingCommittee="existingCommittee" />

      <div class="card">
        <div class="card-header p-0">
          <ul class="nav nav-pills nav-justified" role="tablist">
            <li
              class="nav-item waves-effect waves-light"
              role="presentation"
              @click="navigate('committee')"
            >
              <a
                class="nav-link"
                :class="{
                  active: fragment === '#committees' || fragment === '',
                }"
                data-bs-toggle="tab"
                href="#home-1"
                role="tab"
                aria-selected="true"
              >
                <span class="font-16 fw-bold text-uppercase" style="letter-spacing: 1px"
                  >committees</span
                >
              </a>
            </li>
            <li
              class="nav-item waves-effect waves-light"
              role="presentation"
              @click="navigate('order_of_business')"
            >
              <a
                class="nav-link"
                :class="{
                  active: fragment === '#order_of_business',
                }"
                data-bs-toggle="tab"
                href="#profile-1"
                role="tab"
                aria-selected="false"
                tabindex="-1"
              >
                <span class="font-16 fw-bold text-uppercase" style="letter-spacing: 1px"
                  >order of business</span
                >
              </a>
            </li>
          </ul>
        </div>
        <div class="card-body pb-0">
          <div class="tab-content">
            <div
              class="tab-pane p-0"
              :class="{
                'active show': fragment === '#committees' || fragment === '',
              }"
              id="home-1"
              role="tabpanel"
            >
              <CommitteeList :agendas="agendas" :committees="committees" />
            </div>
            <div
              class="tab-pane p-0"
              id="profile-1"
              role="tabpanel"
              :class="{
                'active show': fragment === '#order_of_business',
              }"
            >
              <BoardSessionList :boardSessions="boardSessions"></BoardSessionList>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>
