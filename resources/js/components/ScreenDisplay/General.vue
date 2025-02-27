<script setup>
import { ref, inject } from "vue";
import { Notyf } from "notyf";
const props = defineProps({
  settings: {
    type: Object,
    required: true,
  },
});

const getValueByName = (key) => {
  return props.settings.find((setting) => setting.name === key);
};
const config = inject("$config");
const generalSettings = ref({
  announcement_running_speed: getValueByName("announcement_running_speed")?.value,
  announcement: getValueByName("display_announcement")?.value,
});

const updateGeneralSetting = () => {
  let formData = new FormData();
  formData.append("announcement", generalSettings.value.announcement);
  formData.append(
    "announcement_running_speed",
    generalSettings.value.announcement_running_speed
  );

  axios.post("/api/announcement", formData).then((response) => {
    if (response.data.success) {
      new Notyf().success("General settings updated successfully.");
      config.socket.emit("TRIGGER_REFRESH");
    }
  });
};

const refreshClients = () => {
  config.socket.emit("TRIGGER_REFRESH");
};
</script>

<template>
  <div>
    <h5 class="card-title text-dark">Screen Display</h5>
    <div class="card-text">
      <div class="form-group row mt-3">
        <label for="prepared_by" class="col-md-2 col-form-label text-md-right"
          >Running Text Speed</label
        >
        <div class="col-md-10">
          <input
            type="text"
            name="announcement_running_speed"
            id="announcement_running_speed"
            class="form-control"
            v-model="generalSettings.announcement_running_speed"
            placeholder="Enter speed e.g 5"
          />
        </div>
      </div>

      <div class="form-group row mt-2">
        <label for="prepared_by" class="col-md-2 col-form-label text-md-right"
          >Announcement</label
        >
        <div class="col-md-10">
          <textarea
            name="announcement"
            v-model="generalSettings.announcement"
            class="form-control"
            cols="30"
            rows="10"
          >
          </textarea>
        </div>
      </div>
    </div>

    <hr class="border-dashed" />

    <h5 class="card-title text-dark">Connectivity</h5>
    <div class="card-text">
      <div class="form-group row mt-2">
        <label for="announcement" class="col-md-2 col-form-label text-md-right"
          >Refresh Clients</label
        >
        <div class="col-md-10">
          <button
            class="btn bg-dark text-white fw-medium"
            type="button"
            id="refreshClients"
            @click="refreshClients"
          >
            Refresh Clients
          </button>
          <p class="text-muted">
            This feature allows you to instantly update all connected clients with the
            latest data available on the server.
          </p>
        </div>
      </div>
    </div>

    <div class="float-end">
      <input
        type="submit"
        value="Update"
        class="btn btn-soft-success border"
        @click="updateGeneralSetting"
      />
    </div>
  </div>
</template>
