<script>
import { inject } from "vue";
export default {
  props: ["agendas"],
  components: {},
  setup(props) {
    const displayAgenda = inject("DISPLAY_AGENDA");
    return {
      displayAgenda,
    };
  },
};
</script>

<template>
  <div>
    <div
      class="offcanvas offcanvas-end"
      :class="{ show: displayAgenda }"
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
            <h5 class="text-uppercase fw-bolder ms-2" id="offCanvasAgendasTitle">
              <slot name="title"></slot>
            </h5>
          </div>
          <div>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              data-bs-dismiss="offcanvas"
              aria-label="Close"
              @click="displayAgenda = false"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="offcanvas-body h-100 d-flex justify-content-between flex-column pb-0">
        <div class="overflow-auto">
          <div class="mb-3">
            <h6 class="fw-bold bg-dark p-3 text-white mb-0">
              Chairman in Agenda's [ {{ agendas?.chairman?.length }} ]
            </h6>
            <ul class="list-group">
              <li
                v-for="(chairmanInAgenda, index) in agendas?.chairman"
                :key="chairmanInAgenda.id"
                class="list-group-item"
              >
                <span class="fw-bold">{{ index + 1 }}.</span>
                {{ chairmanInAgenda.title }}
              </li>
            </ul>
          </div>

          <div class="mb-3">
            <h6 class="fw-bold bg-dark p-3 text-white mb-0">
              Vice Chairman in Agenda's [ {{ agendas?.vice_chairman?.length }} ]
            </h6>
            <ul class="list-group">
              <li
                v-for="(viceChairmanInAgenda, index) in agendas?.vice_chairman"
                :key="viceChairmanInAgenda.id"
                class="list-group-item"
              >
                <span class="fw-bold">{{ index + 1 }}.</span>
                {{ viceChairmanInAgenda.title }}
              </li>
            </ul>
          </div>

          <div class="mb-3">
            <h6 class="fw-bold bg-dark p-3 text-white mb-0">
              Member in Agenda's [ {{ agendas?.member?.length }} ]
            </h6>
            <ul class="list-group">
              <li
                v-for="(memberInAgenda, index) in agendas?.member"
                :key="memberInAgenda.id"
                class="list-group-item"
              >
                <span class="fw-bold">{{ index + 1 }}.</span>
                {{ memberInAgenda?.agenda?.title }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
