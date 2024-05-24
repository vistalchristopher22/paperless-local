<script setup>
import Layout from "@pages/Layout.vue";
import { Head } from "@inertiajs/vue3";

import { defineComponent, defineProps, onMounted } from "vue";

import General from "@components/ScreenDisplay/General.vue";
import Display from "@components/ScreenDisplay/Display.vue";
import CommitteeMeeting from "@components/ScreenDisplay/CommitteeMeeting.vue";

defineComponent({
  Layout,
  General,
  Display,
  CommitteeMeeting,
});

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
  sanggunianMembers: {
    type: Array,
    required: true,
  },
  settings: {
    type: Object,
    required: true,
  },
  schedule: {
    type: Object,
    required: true,
  },
  id: {
    type: Number,
    required: true,
  },
});

const saveTab = (tab) => {
  localStorage.setItem("tab", tab);
};

const selectedTab = localStorage.getItem("tab") || "general";
</script>

<template>
  <layout>
    <Head title="Control Screen Display" />
    <ul class="nav nav-pills nav-justified mt-2" role="tablist">
      <li class="nav-item waves-effect waves-light" role="presentation">
        <a
          class="nav-link"
          data-bs-toggle="tab"
          @click="saveTab('general')"
          :class="{ active: selectedTab === 'general' }"
          href="#general"
          role="tab"
          aria-selected="true"
        >
          <span class="fw-bold text-uppercase" style="letter-spacing: 1px">General</span>
        </a>
      </li>
      <li class="nav-item waves-effect waves-light" role="presentation">
        <a
          class="nav-link"
          data-bs-toggle="tab"
          @click="saveTab('display')"
          href="#display"
          :class="{ active: selectedTab === 'display' }"
          role="tab"
          aria-selected="false"
          tabindex="-1"
        >
          <span class="fw-bold text-uppercase" style="letter-spacing: 1px">
            Display
          </span>
        </a>
      </li>
      <li class="nav-item waves-effect waves-light" role="presentation">
        <a
          class="nav-link"
          data-bs-toggle="tab"
          :class="{ active: selectedTab === 'committee-meeting' }"
          href="#committee-meeting"
          @click="saveTab('committee-meeting')"
          role="tab"
          aria-selected="false"
          tabindex="-1"
        >
          <span class="fw-bold text-uppercase" style="letter-spacing: 1px">
            Committee Meeting
          </span>
        </a>
      </li>
    </ul>
    <div class="card">
      <div class="card-body">
        <div class="tab-content" id="pills-tabContent">
          <div
            class="tab-pane fade"
            id="general"
            role="tabpanel"
            :class="{
              active: selectedTab === 'general',
              show: selectedTab === 'general',
            }"
            aria-labelledby="general-tab"
          >
            <General :settings="settings" />
          </div>

          <div
            class="tab-pane fade"
            id="display"
            :class="{
              active: selectedTab === 'display',
              show: selectedTab === 'display',
            }"
            role="tabpanel"
            aria-labelledby="display-tab"
          >
            <Display :sanggunianMembers="sanggunianMembers" :id="id" />
          </div>

          <div
            class="tab-pane fade"
            :class="{
              active: selectedTab === 'committee-meeting',
              show: selectedTab === 'committee-meeting',
            }"
            id="committee-meeting"
            role="tabpanel"
            aria-labelledby="committee-meeting-tab"
          >
            <CommitteeMeeting :schedule="schedule" />
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<style scoped>
.nav-link.active {
  color: white !important;
}

.letter-spacing-1 {
  letter-spacing: 0.9px;
}
</style>
