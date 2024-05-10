<script setup>
import Layout from "@pages/Layout.vue";
import { Head } from "@inertiajs/vue3";

import { defineComponent, defineProps } from "vue";

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
});
</script>

<template>
  <layout>
    <Head title="Control Screen Display" />
    <ul class="nav nav-pills nav-justified mt-2" role="tablist">
      <li class="nav-item waves-effect waves-light" role="presentation">
        <a
          class="nav-link show active"
          data-bs-toggle="tab"
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
          href="#display"
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
          href="#committee-meeting"
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
            class="tab-pane fade show active"
            id="general"
            role="tabpanel"
            aria-labelledby="general-tab"
          >
            <General :settings="settings" />
          </div>

          <div
            class="tab-pane fade"
            id="display"
            role="tabpanel"
            aria-labelledby="display-tab"
          >
            <Display :sanggunianMembers="sanggunianMembers" />
          </div>

          <div
            class="tab-pane fade"
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
