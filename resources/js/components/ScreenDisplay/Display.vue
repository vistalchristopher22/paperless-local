<script setup>
import vSelect from "vue-select";
import { defineComponent } from "vue";

const props = defineProps({
  sanggunianMembers: {
    type: Array,
    required: true,
  },
});
defineComponent({
  vSelect,
});

const updateDisplaySetting = () => {
  alert("update display setting");
};
</script>
<template>
  <div>
    <h5 class="card-title text-dark mb-3">Display Page</h5>
    <div class="card-text">
      <div class="form-group">
        <input
          type="radio"
          value="committee_meeting"
          class="me-2"
          name="display_page"
          id="committeeMeeting"
        />
        <label class="form-check-label" for="committeeMeeting">Committee Meeting</label>
        <p class="text-muted">This will display committee meeting on the screen.</p>
      </div>

      <input
        type="radio"
        value="question_of_hour"
        id="questionOfHour"
        class="me-2"
        name="display_page"
      />
      <label class="form-check-label" for="questionOfHour">Question of Hour</label>
      <p class="text-muted">
        This will display a banner for Question of Hour on the screen.
      </p>

      <label for="prepared_by" class="">Guest</label>
      <input type="text" class="form-control" placeholder="Enter Fullname" />

      <input type="radio" id="privilegeHour" class="me-2 mt-3" name="display_page" />
      <label class="form-check-label" for="privilegeHour">Privilege Hour</label>
      <p class="text-muted">This will display committee meeting on the screen.</p>

      <label for="member" class="">Display Member</label>
      <v-select class="text-uppercase" :options="sanggunianMembers" label="fullname">
        <template #option="{ fullname, profile_picture }">
          <div class="d-flex my-3 align-items-center justify-content-start">
            <div>
              <img
                class="img-fluid rounded"
                :src="`/storage/user-images/${profile_picture}`"
                style="width: 3vw"
                alt=""
              />
            </div>
            <div class="d-flex flex-column ms-2">
              <span class="fw-bold">{{ fullname }}</span>
            </div>
          </div>
        </template>
      </v-select>
      <p class="text-muted">
        This will display a banner for Privilege Hour on the screen.
      </p>
    </div>

    <div class="float-end">
      <input
        type="submit"
        value="Update"
        class="btn btn-soft-success border"
        @click="updateDisplaySetting"
      />
    </div>
  </div>
</template>
