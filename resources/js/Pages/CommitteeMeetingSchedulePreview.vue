<script setup>
import moment from "moment";
import _ from "lodash";
import { defineComponent, watch, ref, onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import { usePDF, VuePDF } from "@tato30/vue-pdf";
import "@tato30/vue-pdf/style.css";
const props = defineProps({
  schedule: {
    type: Object,
    required: true,
  },
  settings: {
    type: Object,
    required: true,
  },
  members: {
    type: Array,
    required: true,
  },
  orderOfBusinessLink: {
    type: Object,
  },
});

defineComponent({
  VuePDF,
});

const showSidebar = ref(false);
const hightlightBoardMember = ref(null);

const addLeadingZero = (number) => {
  return number < 10 ? `0${number}` : number;
};

const getCommitteeMembers = (members) => {
  return _.map(members, "sanggunian_member");
};

const hideSidebar = () => {
  showSidebar.value = !showSidebar.value;
};

const highlight = (member) => {
  if (hightlightBoardMember.value === member.id) {
    hightlightBoardMember.value = null;
    return;
  }
  hightlightBoardMember.value = member.id;
};

const DEFAULT_SCALE_SIZE = 3.75;
const page = ref(1);
const pages = ref(0);
const { pdf } = usePDF("");
const scale = ref(DEFAULT_SCALE_SIZE);
const pdfView = ref({});
const newPage = ref(1);
const pageScale = ref(scale.value);
const parentWidth = ref(scale.value * 20);
page.value = 1;

const { pdf: newPDFToLoad, pages: newPages } = usePDF(
  `/storage/committees/${props?.orderOfBusinessLink?.name}`
);

watch(newPDFToLoad, () => {
  pdf.value = newPDFToLoad.value;
});

watch(newPages, () => {
  pages.value = newPages.value;
});

const goToNewPage = () => {
  if (newPage.value && typeof newPage.value == "number") {
    if (newPage.value > pages.value) {
      page.value = pages.value;
    }
    page.value = newPage.value;
  }
};

const pagePrevious = () => {
  page.value = page.value > 1 ? page.value - 1 : page.value;
  newPage.value = page.value;
};

const pageNext = () => {
  page.value = page.value < pages.value ? page.value + 1 : page.value;
  newPage.value = page.value;
};

const handleKeyDown = (e) => {
  if (e.key === "ArrowRight") {
    pageNext();
  } else if (e.key === "ArrowLeft") {
    pagePrevious();
  }
};

const onAnnotation = (value) => {
  console.log(value);
  if (value.type === "link") {
    window.open(value.data.url, "_blank");
  }
};

const highlightTextInsideInput = (e) => {
  e.target.select();
};

const changeScale = () => {
  if (pageScale.value >= 7) {
    return;
  }
  scale.value = pageScale.value;
  parentWidth.value = scale.value * 20;
  pdfView.value.reload();
};

const increaseScale = () => {
  if (scale.value >= 5) {
    return;
  }
  scale.value = scale.value + 0.25;
  pageScale.value = scale.value;
  parentWidth.value = scale.value * 20;
  pdfView.value.reload();
};

const decreaseScale = () => {
  if (scale.value <= 1) {
    return;
  }

  scale.value = scale.value - 0.25;
  pageScale.value = scale.value;
  parentWidth.value = scale.value * 20;
  pdfView.value.reload();
};

const presentationMode = () => {
  if (parentWidth.value >= 97) {
    parentWidth.value = scale.value * 20;
  } else {
    parentWidth.value = 97;
  }
  pdfView.value.reload();
};

onMounted(() => {
  window.addEventListener("keydown", handleKeyDown);
});
</script>

<template>
  <Head title="Session & Committee Schedule" />
  <div class="d-flex">
    <div
      class="d-flex flex-column align-items-stretch flex-shrink-0"
      :class="{ 'd-none': showSidebar }"
      style="width: 380px"
    >
      <div v-auto-animate>
        <div
          href="/"
          class="d-flex align-items-center justify-content-between flex-shrink-0 p-3 link-dark text-decoration-none border-bottom bg-primary"
        >
          <div>
            <span class="fs-5 text-uppercase fw-bold letter-spacing-0 text-white"
              >Board Members</span
            >
          </div>
          <div class="">
            <a href="#" @click="hideSidebar">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                class="w-6 h-6 text-white"
                viewBox="0 0 24 24"
              >
                <path d="M3 12h18M3 6h18M3 18h18"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <div class="list-group list-group-flush border-bottom scrollarea">
        <a
          href="#"
          class="list-group-item list-group-item-action py-3 lh-tight"
          @click="highlight(member)"
          v-for="member in members"
          :key="member"
          :class="{
            active: hightlightBoardMember == member.id,
          }"
        >
          <div class="d-flex w-100 align-items-center justify-content-between">
            <strong class="mb-1 text-uppercase ms-2 letter-spacing-0">{{
              member.fullname
            }}</strong>
            <small>
              <img
                width="60px"
                class="img-fluid rounded-circle"
                :src="`/storage/user-images/${member.profile_picture}`"
              />
            </small>
          </div>
          <div class="col-10 mb-1 small">
            <strong class="mb-1 text-uppercase ms-2 letter-spacing-0">
              {{ member.sanggunian }}th Sanggunian Member
            </strong>
          </div>
        </a>
      </div>
    </div>
    <main class="main-container bg-light">
      <div class="">
        <!-- add tabs -->
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
          <div class="d-flex w-100 align-items-center justify-content-between">
            <li class="nav-item ms-2">
              <a href="#" @click="hideSidebar" v-if="showSidebar">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  class="w-6 h-6 text-primary"
                  viewBox="0 0 24 24"
                >
                  <path d="M3 12h18M3 6h18M3 18h18"></path>
                </svg>
              </a>
            </li>

            <div class="d-flex align-items-center justify-content-center">
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link fs-5 text-uppercase fw-bold letter-spacing-0"
                  id="commitees-home-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-home"
                  type="button"
                  role="tab"
                  aria-controls="pills-home"
                  aria-selected="true"
                >
                  Committees
                </button>
              </li>
              <li class="nav-item me-2" role="presentation">
                <button
                  class="nav-link fs-5 text-uppercase fw-bold letter-spacing-0"
                  :href="`/${orderOfBusinessLink}`"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-contact"
                  type="button"
                  role="tab"
                  aria-controls="pills-contact"
                  aria-selected="false"
                >
                  Session
                </button>
              </li>
            </div>
          </div>
        </ul>
        <div class="clearfix mb-0 p-0"></div>
        <hr class="mt-0 mb-0" />
        <div class="tab-content pt-0 px-2" id="pills-tabContent">
          <div
            class="tab-pane fade show active"
            id="pills-home"
            role="tabpanel"
            aria-labelledby="commitees-home-tab"
          >
            <!-- begin of content -->
            <h3 class="letter-spacing-1 fw-bold text-uppercase text-dark">
              {{ schedule.reference_session }} {{ schedule.type }}
            </h3>

            <span class="text-uppercase h5 fw-bold mt-5 letter-spacing-0">
              Schedule Date :
              <span class="fw-bold letter-spacing-0">
                <span class="fw-bold text-primary">
                  {{ moment(schedule.date_and_time).format("MMMM DD, YYYY") }}
                </span>
                in
                <span class="text-dark">{{ schedule.schedule_venue.name }}</span>
              </span>
            </span>

            <p class="mt-4">
              <span class="text-uppercase h5 text-dark fw-bold mt-5 letter-spacing-0">
                COMMITTEE WITH INVITED GUESTS
              </span>
            </p>

            <div class="list-group">
              <div
                href="#"
                class="list-group-item list-group-item-action bg-white"
                v-for="(committee, withGuestIndex) in schedule.with_guest_committees"
                :key="committee"
              >
                <div class="d-flex w-100 justify-content-between flex-column">
                  <div>
                    <h5 class="mb-0 fw-bold d-flex">
                      <span class="fw-normal">
                        <span class="fw-bold"
                          >{{ addLeadingZero(withGuestIndex + 1) }}.</span
                        ></span
                      >
                      <div class="ms-1 letter-spacing-1">
                        <a
                          :href="committee?.file_link?.view_link"
                          class="text-primary lead-committee-title"
                          :target="committee?.file_link?.view_link ? '_blank' : '_self'"
                        >
                          {{
                            committee.lead_committee_information.title
                              .toLowerCase()
                              .replace("committee on", "")
                              .toUpperCase()
                          }}
                        </a>
                      </div>
                    </h5>
                  </div>
                  <div>
                    <h6
                      class="ms-5 my-1 d-flex"
                      v-if="committee?.expanded_committee_information"
                    >
                      <div v-if="committee?.other_expanded_committee_information">(</div>
                      <div>
                        <span class="fw-bold text-primary">
                          {{
                            committee?.expanded_committee_information?.title
                              .toLowerCase()
                              .replace("committee on", "")
                              .toUpperCase()
                          }}
                        </span>
                      </div>
                      <div
                        v-if="committee?.other_expanded_committee_information"
                        class="mx-1"
                      >
                        &
                      </div>
                      <div>
                        <span class="fw-bold text-primary">
                          {{
                            committee?.other_expanded_committee_information?.title
                              .toLowerCase()
                              .replace("committee on", "")
                              .toUpperCase()
                          }}
                        </span>
                      </div>
                      <div v-if="committee?.other_expanded_committee_information">)</div>
                    </h6>
                  </div>
                  <div class="mt-1">
                    Chairman :
                    <span
                      :class="{
                        'highlight-record':
                          hightlightBoardMember ==
                          committee?.lead_committee_information?.chairman,
                      }"
                    >
                      <strong>
                        {{
                          committee?.lead_committee_information?.chairman_information
                            ?.fullname
                        }}
                      </strong>
                    </span>
                  </div>
                  <div class="mt-1">
                    Vice Chairman:
                    <span
                      :class="{
                        'highlight-record':
                          hightlightBoardMember ==
                          committee?.lead_committee_information?.vice_chairman,
                      }"
                    >
                      {{
                        committee?.lead_committee_information?.vice_chairman_information
                          ?.fullname
                      }}
                    </span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <div class="mt-1">
                      Members:
                      <span
                        v-for="(member, index) in committee?.lead_committee_information
                          ?.members"
                        :key="member"
                      >
                        <span
                          v-for="person in member.sanggunian_member"
                          :key="person"
                          :class="{
                            'highlight-record': hightlightBoardMember == person.id,
                          }"
                        >
                          {{ person.fullname }}
                          <span
                            v-if="
                              index !==
                              committee?.lead_committee_information?.members?.length - 1
                            "
                          >
                            ,
                          </span>
                        </span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <p class="mt-5">
              <span class="text-uppercase text-dark h5 fw-bold mt-5 letter-spacing-0">
                COMMITTEE WITHOUT INVITED GUESTS
              </span>
            </p>

            <div class="list-group mb-5">
              <div
                class="list-group-item list-group-item-action bg-white"
                v-for="(
                  withoutInvitedGuests, withoutGuestIndex
                ) in schedule.without_guest_committees"
                :key="withoutInvitedGuests"
              >
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1 fw-bold d-flex">
                    <span class="fw-normal">
                      <span class="fw-bold"
                        >{{
                          addLeadingZero(
                            withoutGuestIndex + schedule.with_guest_committees.length + 1
                          )
                        }}.</span
                      >
                    </span>
                    <div class="text-primary ms-1 letter-spacing-1">
                      <a
                        :href="withoutInvitedGuests?.file_link?.view_link"
                        class="text-primary lead-committee-title"
                        :target="
                          withoutInvitedGuests?.file_link?.view_link ? '_blank' : '_self'
                        "
                      >
                        {{
                          withoutInvitedGuests.lead_committee_information.title
                            .toLowerCase()
                            .replace("committee on", "")
                            .toUpperCase()
                        }}
                      </a>
                    </div>
                  </h5>
                </div>

                <div>
                  <h6
                    class="ms-5 my-1 d-flex"
                    v-if="withoutInvitedGuests?.expanded_committee_information"
                  >
                    <div
                      v-if="withoutInvitedGuests?.other_expanded_committee_information"
                    >
                      (
                    </div>
                    <div>
                      <span class="fw-bold text-primary">
                        {{
                          withoutInvitedGuests?.expanded_committee_information?.title
                            .toLowerCase()
                            .replace("committee on", "")
                            .toUpperCase()
                        }}
                      </span>
                    </div>
                    <div
                      v-if="withoutInvitedGuests?.other_expanded_committee_information"
                      class="mx-1"
                    >
                      &
                    </div>
                    <div>
                      <span class="fw-bold text-primary">
                        {{
                          withoutInvitedGuests?.other_expanded_committee_information?.title
                            .toLowerCase()
                            .replace("committee on", "")
                            .toUpperCase()
                        }}
                      </span>
                    </div>
                    <div
                      v-if="withoutInvitedGuests?.other_expanded_committee_information"
                    >
                      )
                    </div>
                  </h6>
                </div>
                <p class="mb-1">
                  Chairman :
                  <span
                    :class="{
                      'highlight-record':
                        hightlightBoardMember ==
                        withoutInvitedGuests?.lead_committee_information.chairman,
                    }"
                  >
                    <strong>
                      {{
                        withoutInvitedGuests?.lead_committee_information
                          ?.chairman_information?.fullname
                      }}
                    </strong>
                  </span>
                </p>
                <p class="mb-1">
                  Vice Chairman:
                  <span
                    :class="{
                      'highlight-record':
                        hightlightBoardMember ==
                        withoutInvitedGuests?.lead_committee_information.vice_chairman,
                    }"
                  >
                    {{
                      withoutInvitedGuests?.lead_committee_information
                        ?.vice_chairman_information?.fullname
                    }}
                  </span>
                </p>
                <p class="mb-1">
                  Members:
                  <span
                    v-for="(member, index) in withoutInvitedGuests
                      ?.lead_committee_information?.members"
                    :key="member"
                  >
                    <span
                      v-for="person in member.sanggunian_member"
                      :key="person"
                      :class="{
                        'highlight-record': hightlightBoardMember == person.id,
                      }"
                    >
                      {{ person.fullname }}
                      <span
                        v-if="
                          index !==
                          withoutInvitedGuests?.lead_committee_information?.members
                            ?.length -
                            1
                        "
                      >
                        ,
                      </span>
                    </span>
                  </span>
                </p>
              </div>
            </div>
            <!-- end of content -->
          </div>
          <div
            class="tab-pane fade p-3"
            id="pills-contact"
            role="tabpanel"
            aria-labelledby="pills-session-tab"
          >
            <div class="d-flex align-items-center justify-content-center">
              <nav
                class="toolbar bg-primary d-flex align-items-center justify-content-between mb-2"
              >
                <div class="h4 fw-normal text-white">
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 13H5v-2h14z" />
                  </svg> -->
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="2em"
                    height="2em"
                    fill="currentColor"
                    class="bi bi-chevron-left cursor-pointer decrease-scale-btn ms-1"
                    viewBox="0 0 16 16"
                    @click="pagePrevious"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"
                    />
                  </svg>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    type="number"
                    class="text-center h4 fw-normal text-white"
                    v-model="newPage"
                    @keyup.enter="goToNewPage"
                    style="background: #00000080; width: 10%"
                    @click="highlightTextInsideInput"
                  />
                  <div class="h4 text-white fw-normal">
                    <strong class="mx-1">/</strong>{{ pages }}
                  </div>
                </div>
                <div class="h4 fw-normal text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    class="bi bi-chevron-right me-1 cursor-pointer increase-scale-btn"
                    width="2em"
                    height="2em"
                    viewBox="0 0 16 16"
                    @click="pageNext"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"
                    />
                  </svg>
                </div>
              </nav>
            </div>
            <div class="pdf-viewer">
              <VuePDF
                :pdf="pdf"
                :page="page"
                annotation-layer
                @annotation="onAnnotation"
                :scale="2.7"
              />
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.main-container {
  flex: 1;
  height: 100vh;
  overflow-y: auto;
}

.letter-spacing-0 {
  letter-spacing: 0.8px;
}
.letter-spacing-1 {
  letter-spacing: 2px;
}
.letter-spacing-2 {
  letter-spacing: 2.5px;
}

.scrollarea {
  overflow-y: auto;
  max-height: 95vh;
}

.nav-title {
  background: #0d9920;
}
.highlight-record {
  background: rgb(11, 81, 183);
  color: white;
  padding: 4px;
  border-radius: 5px;
  padding-left: 8px;
  transition: background-color 0.3s ease-in-out;
  animation: pulse 2s infinite;
  margin-right: 3px;
  margin-left: 3px;
  font-weight: bold;
}

@keyframes pulse {
  0% {
    background-color: rgb(11, 81, 183);
  }
  50% {
    background-color: rgb(11, 81, 183, 0.5);
  }
  100% {
    background-color: rgb(11, 81, 183);
  }
}

.lead-committee-title {
  border-bottom: 2px solid transparent;
  transition: border-bottom 0.3s ease-in-out;
}

.lead-committee-title:hover {
  border-bottom: 2px solid #004409;
}
</style>

<style scoped>
.page-container {
  margin: 0px auto;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
  border: none;
}

.increase-scale-btn {
  padding: 5px;
  border-radius: 50%;
  transition: background 0.3s ease;
}
.increase-scale-btn:hover {
  background: #9aa0a6;
}

.decrease-scale-btn {
  padding: 5px;
  border-radius: 50%;
  transition: background 0.3s ease;
}
.decrease-scale-btn:hover {
  background: #9aa0a6;
}

.cursor-pointer {
  cursor: pointer;
}

.toolbar {
  /* background: #0b51b7; */
  border-radius: 1px;
}

.pdf-viewer {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0px 10px;
  position: relative;
  margin: 0px auto;
}
</style>
