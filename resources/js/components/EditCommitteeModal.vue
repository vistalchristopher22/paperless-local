<script setup>
import CommitteeEditForm from "@components/CommitteeEditForm.vue";

const props = defineProps({
    agendas: {
        type: Array,
        required: true,
    },
    existingCommittee: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div
        class="modal fade"
        id="editCommitteeModal"
        tabindex="-1"
        aria-labelledby="editCommitteeModalTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5
                        class="modal-title text-uppercase fw-bold letter-spacing-1"
                        id="editCommitteeModalTitle"
                    >
                        Edit Committee
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <committee-edit-form
                        :agendas="agendas"
                        :existingCommittee="existingCommittee"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
