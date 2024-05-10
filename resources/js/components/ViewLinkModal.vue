<script setup>
const props = defineProps({
  link: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div>
    <div
      class="modal fade"
      id="viewLinkModal"
      tabindex="-1"
      aria-labelledby="viewLinkModalTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5
              class="modal-title text-uppercase letter-spacing-1"
              id="viewLinkModalTitle"
            >
              Public & Viewable Link
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body text-truncate text-center">
            <h5 class="">
              {{ link }}
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
