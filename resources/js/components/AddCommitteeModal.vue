<script setup>

import CommitteeCreateForm from "@components/CommitteeCreateForm.vue";

const props = defineProps({
    agendas: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div>
        <div
            class="modal fade"
            id="addNewCommittee"
            tabindex="-1"
            aria-labelledby="addNewCommitteeTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5
                            class="modal-title text-uppercase letter-spacing-1"
                            id="addNewCommitteeTitle"
                        >
                            Add New Committee
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <committee-create-form :agendas="agendas"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
