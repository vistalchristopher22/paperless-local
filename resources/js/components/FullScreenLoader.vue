<script>
export default {
  props: ["processing"],
  components: {},
};
</script>

<template>
  <div>
    <div
      class="d-flex justify-content-center align-items-center"
      v-if="processing"
      style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
      "
    >
      <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="spinner-border text-white" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="text-white fw-bolder letter-spacing-1">Loading</h5>
      </div>
    </div>
  </div>
</template>
<style scoped>
.letter-spacing-1 {
  letter-spacing: 1.5px;
}
</style>
