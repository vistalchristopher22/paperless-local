<script>
export default {
  props : [
    'text', 'data'
  ],
  components: {
  },
 
};
</script>

<template>
    <div class="card report-card bg-dark">
        <div class="card-body">
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <p class="text-white mb-0 fw-semibold">{{ text }}</p>
                    <h3 class="m-0 text-white">{{ data }}</h3>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped></style>
