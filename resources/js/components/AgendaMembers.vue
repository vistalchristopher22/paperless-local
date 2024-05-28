<script>
import { ref, reactive, computed, watch } from "vue";

export default {
  props: ["displayMembers", "fetchedMembers"],
  emits: ["close-display"],
  setup(props, { emit }) {
    const close = () => {
      emit("close-display");
    };
    return {
      close,
    };
  },
};
</script>
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
            <span class="fw-bold letter-spacing-1">{{
              fetchedMembers?.title?.toLowerCase().replace("committee on", "")
            }}</span>
          </h5>
        </div>
        <div>
          <button
            type="button"
            class="btn btn-danger btn-sm"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
            @click="close"
          >
            <i class="mdi mdi-close"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
      <div class="overflow-auto">
        <h5 class="letter-spacing-1 bg-dark text-white d-flex p-2 mb-1">Chairman</h5>
        <div class="card mb-3">
          <div class="card-body text-center">
            <div class="user-avatar">
              <img
                class="w-25"
                :src="`/storage/user-images/${fetchedMembers?.chairman_information?.profile_picture}`"
              />
            </div>
            <span class="fw-bold text-uppercase letter-spacing-1">{{
              fetchedMembers?.chairman_information?.fullname
            }}</span>
          </div>
        </div>
        <h5 class="letter-spacing-1 fw-medium bg-dark text-white d-flex p-2 mb-1">
          Vice-chairman
        </h5>
        <div class="card mb-3">
          <div class="card-body text-center">
            <div class="user-avatar">
              <img
                class="w-25"
                :src="`/storage/user-images/${fetchedMembers?.vice_chairman_information?.profile_picture}`"
              />
            </div>
            <span class="fw-bold text-uppercase letter-spacing-1">{{
              fetchedMembers?.vice_chairman_information?.fullname
            }}</span>
          </div>
        </div>
        <h5 class="bg-dark text-white d-flex p-2 mb-1">Members</h5>
        <div class="card mb-3" v-for="(member, key) in fetchedMembers.members" :key="key">
          <div class="card-body text-center">
            <div class="user-avatar">
              <img
                class="w-25"
                :src="`/storage/user-images/${member?.sanggunian_member[0]?.profile_picture}`"
              />
            </div>
            <span class="fw-bold text-uppercase letter-spacing-1">{{
              member?.sanggunian_member[0]?.fullname
            }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.letter-spacing-1 {
  letter-spacing: 1px;
}
</style>
