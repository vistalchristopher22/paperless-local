<script setup>
import Layout from "@pages/Layout.vue";
import { ref } from "vue";
import { saveNewSetting } from "@services/SettingsApi";
import { Notyf } from "notyf";

const props = defineProps({
  settings: {
    required: true,
  },
});

const options = ref(props.settings);

const submitSettings = () => {
  saveNewSetting(options.value)
    .then((response) => {
      if (response.status === 200) {
        new Notyf().success("Settings has been updated successfully.");
      }
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>
<template>
  <layout>
    <div>
      <div class="card">
        <div class="card-header bg-dark py-3">
          <h6 class="fw-medium card-title h3 text-white">Application Settings</h6>
        </div>
        <div class="card-body">
          <form method="POST" @submit.prevent="submitSettings">
            <h5 class="card-title text-dark">Document</h5>
            <div class="form-group row">
              <label for="libre_office_path" class="col-md-2 col-form-label text-md-right"
                >Prepared By</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="libre_office_path"
                  id="libre_office_path"
                  class="form-control"
                  v-model="options.prepared_by"
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="presiding_officer" class="col-md-2 col-form-label text-md-right"
                >Presiding Officer</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="presiding_officer"
                  id="presiding_officer"
                  class="form-control"
                  v-model="options.presiding_officer"
                />
              </div>
            </div>

            <div class="form-group row mt-2">
              <label for="libre_office_path" class="col-md-2 col-form-label text-md-right"
                >Noted By</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="libre_office_path"
                  id="libre_office_path"
                  class="form-control"
                  v-model="options.noted_by"
                />
              </div>
            </div>
            <h5 class="card-title text-dark">Third-Parties</h5>
            <div class="form-group row">
              <label for="libre_office_path" class="col-md-2 col-form-label text-md-right"
                >Libreoffice Path</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="libre_office_path"
                  id="libre_office_path"
                  class="form-control"
                  v-model="options.libre_office_path"
                  placeholder="C:\ProgramFiles\LibreOffice\"
                />
              </div>
            </div>

            <hr class="border-dashed" />

            <h5 class="card-title text-dark">Actions</h5>
            <div class="form-group row mt-2">
              <label for="announcement" class="col-md-2 col-form-label text-md-right"
                >Refresh Clients</label
              >
              <div class="col-md-10">
                <button class="btn btn-primary" id="refreshClients">
                  Refresh Clients
                </button>
                <p class="text-dark">
                  This feature allows you to instantly update all connected clients with
                  the latest data available on the server.
                </p>
              </div>
            </div>

            <h5 class="card-title text-dark">Source Folder</h5>

            <div class="form-group row mt-2">
              <label
                for="unassigned_business"
                class="col-md-2 col-form-label text-md-right"
                >Path</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="source_folder"
                  id="source_folder"
                  class="form-control"
                  v-model="options.source_folder"
                />
              </div>
            </div>

            <div class="form-group row mt-2">
              <label
                for="unassigned_business"
                class="col-md-2 col-form-label text-md-right"
                >Network Source Path</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  class="form-control"
                  v-model="options.network_source_path"
                />
              </div>
            </div>

            <hr class="border-dashed" />

            <h5 class="card-title text-dark">Network Socket Connections</h5>

            <div class="form-group row mt-2">
              <label
                for="unassigned_business"
                class="col-md-2 col-form-label text-md-right"
                >Server Socket URL</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  class="form-control"
                  v-model="options.server_socket_url"
                />
              </div>
            </div>

            <div class="form-group row mt-2">
              <label
                for="unassigned_business"
                class="col-md-2 col-form-label text-md-right"
                >Local Socket URL</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="local_socket_url"
                  id="local_socket_url"
                  class="form-control"
                  v-model="options.local_socket_url"
                />
              </div>
            </div>

            <div class="form-group row mb-0 mt-3">
              <div class="col-md-10 text-end offset-md-2">
                <button type="submit" class="btn btn-primary btn-dark shadow-dark">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-send mx-1"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"
                    />
                  </svg>
                  Save Setting
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </layout>
</template>
<style></style>
