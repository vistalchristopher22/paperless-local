<template>
  <div
    class="offcanvas offcanvas-end shadow"
    :class="{ show: displayMembers }"
    style="width: 380px"
    tabindex="-1"
    id="offCanvasAgendas"
    aria-labelledby="offCanvasAgendasTitle"
  >
    <div class="offcanvas-header position-relative py-1 mb-0">
      <div
        class="d-flex align-items-center justify-content-between w-100 border border-top-0 border-start-0 border-end-0"
      >
        <div>
          <h5 class="text-uppercase ms-2" id="offCanvasAgendasTitle">
            <span class="fw-medium">{{
              fetchedMembers?.title?.toLowerCase().replace("committee on", "")
            }}</span>
          </h5>
        </div>
        <div>
          <button
            type="button"
            class="btn btn-danger mb-2 rounded-0 btn-sm"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
            @click="displayMembers = false"
          >
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
      <div class="overflow-auto">
        <span class="lead fw-medium text-uppercase bg-dark text-white d-flex p-2 mb-1"
          >Chairman</span
        >
        <div class="card mb-3">
          <div class="card-body text-center">
            <div class="user-avatar">
              <img
                class="thumb-lg rounded-circle img-fluid"
                :src="`http://localhost:8000/storage/user-images/${fetchedMembers?.chairman_information?.profile_picture}`"
              />
            </div>
            <span class="fw-bold lead">{{
              fetchedMembers?.chairman_information?.fullname
            }}</span>
          </div>
        </div>
        <span class="lead fw-medium text-uppercase bg-dark text-white d-flex p-2 mb-1"
          >Vice-chairman</span
        >
        <div class="card mb-3">
          <div class="card-body text-center">
            <div class="user-avatar">
              <img
                class="thumb-lg rounded-circle img-fluid"
                :src="`http://localhost:8000/storage/user-images/${fetchedMembers?.vice_chairman_information?.profile_picture}`"
              />
            </div>
            <span class="fw-bold lead">{{
              fetchedMembers?.vice_chairman_information?.fullname
            }}</span>
          </div>
        </div>
        <span class="lead fw-medium text-uppercase bg-dark text-white d-flex p-2 mb-1"
          >Members</span
        >
        <div class="card mb-3" v-for="(member, key) in fetchedMembers.members" :key="key">
          <div class="card-body text-center">
            <div class="user-avatar">
              <img
                class="thumb-lg rounded-circle img-fluid"
                :src="`http://localhost:8000/storage/user-images/${member?.sanggunian_member[0]?.profile_picture}`"
              />
            </div>
            <span class="fw-bold lead">{{ member?.sanggunian_member[0]?.fullname }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, computed, watch } from "vue";

export default {
  props: ["displayMembers", "fetchedMembers"],
  setup(props) {
    return {};
  },
};
</script>

<style scoped></style>
