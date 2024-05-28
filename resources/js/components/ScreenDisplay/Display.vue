<script setup>
import vSelect from "vue-select";
import { defineComponent, inject, ref } from "vue";
import axios from "axios";
import { Notyf } from "notyf";

const config = inject("$config");

const props = defineProps({
  sanggunianMembers: {
    type: Array,
    required: true,
  },
  id: {
    type: Number,
    required: true,
  },
  guest: {
    type: String,
  },
  selected: {
    type: Number,
  },
});

defineComponent({
  vSelect,
});
const display_page = ref();
const questionHourGuest = ref(props.guest || "");
const selectedMember = ref(parseInt(props.selected));
const currentDisplay = ref(localStorage.getItem("display_page"));

const updateDisplaySetting = () => {
  let selectedDisplay = document.querySelector("input[name='display_page']:checked")
    .value;
  localStorage.setItem("display_page", selectedDisplay);
  if (selectedDisplay === "committee_meeting") {
    new Notyf().success("Successfully changed the screen display to Committee Meeting!");
    config.socket.emit("SCREEN_DISPLAY_CHANGED", {
      id: props.id,
      url: `/screen/${props.id}`,
    });
  } else if (selectedDisplay === "order_of_business") {
    new Notyf().success("Successfully changed the screen display to Order of Business!");
    config.socket.emit("SCREEN_DISPLAY_CHANGED", {
      id: props.id,
      url: `/screen-order-of-business/${props.id}`,
    });
  } else if (selectedDisplay === "question_of_hour") {
    let formData = new FormData();
    formData.append("guest", questionHourGuest.value);
    axios.post(`/api/question-of-hour-guest`, formData).then(() => {
      new Notyf().success("Successfully changed the screen display to Question of Hour", {
        duration: 5000,
      });
      config.socket.emit("SCREEN_DISPLAY_CHANGED", {
        id: props.id,
        url: `/screen-question-of-hour/${props.id}`,
      });
    });
  } else if (selectedDisplay === "privilege_hour") {
    if (!selectedMember.value) {
      new Notyf().error("Please select a member!");
      return;
    }

    let formData = new FormData();
    formData.append("selectedMember", selectedMember.value);
    axios.post(`/api/privilege-hour-member`, formData).then(() => {
      new Notyf().success("Successfully changed the screen display to privilege hour!");
      config.socket.emit("SCREEN_DISPLAY_CHANGED", {
        id: props.id,
        url: `/screen-privilege-hour/${props.id}`,
      });
    });
  }
};
</script>
<template>
  <div>
    <h5 class="card-title text-dark mb-3">Display Page</h5>
    <div class="card-text">
      <div class="form-group">
        <input
          type="radio"
          value="order_of_business"
          class="me-2"
          :checked="currentDisplay == 'order_of_business' ? true : false"
          ref="display_page"
          name="display_page"
          id="orderOfBusiness"
        />
        <label class="form-check-label" for="orderOfBusiness">Order of Business</label>
        <p class="text-muted">
          This will display <strong>Order of Business</strong> on the screen.
        </p>
      </div>

      <div class="form-group">
        <input
          type="radio"
          value="committee_meeting"
          :checked="currentDisplay == 'committee_meeting' ? true : false"
          class="me-2"
          ref="display_page"
          name="display_page"
          id="committeeMeeting"
        />
        <label class="form-check-label" for="committeeMeeting">Committee Meeting</label>
        <p class="text-muted">
          This will display <strong>Committee Meeting</strong> on the screen.
        </p>
      </div>

      <input
        type="radio"
        value="question_of_hour"
        id="questionOfHour"
        :checked="currentDisplay == 'question_of_hour' ? true : false"
        class="me-2"
        ref="display_page"
        name="display_page"
      />
      <label class="form-check-label" for="questionOfHour">Question of Hour</label>
      <p class="text-muted">
        This will display a banner for <strong>Question of Hour</strong> on the screen.
      </p>

      <label for="prepared_by" class=""
        >Guest (For multiple Guests add "|" as separator it will automatically rendered as
        new line on the screen.)</label
      >
      <input
        type="text"
        class="form-control"
        placeholder="Enter Fullname"
        v-model="questionHourGuest"
      />

      <input
        type="radio"
        id="privilegeHour"
        ref="display_page"
        value="privilege_hour"
        :checked="currentDisplay == 'privilege_hour' ? true : false"
        class="me-2 mt-3"
        name="display_page"
      />
      <label class="form-check-label" for="privilegeHour">Privilege Hour</label>
      <p class="text-muted">
        This will display <strong>Privilege Hour</strong> on the screen.
      </p>

      <label for="member" class="">Display Member</label>
      <v-select
        class="text-uppercase"
        :options="sanggunianMembers"
        label="fullname"
        :reduce="(sanggunian) => sanggunian.id"
        v-model="selectedMember"
      >
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
