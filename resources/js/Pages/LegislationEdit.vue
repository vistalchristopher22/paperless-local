<script>
import { ref, reactive, onMounted } from "vue";
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AllFields from "@components/AllFields.vue";
import { Link, Head } from "@inertiajs/vue3";
import vSelect from "vue-select";
import { Notyf } from "notyf";
import {
  getBaseURL,
  removeFileExtension,
  getIconByFileName,
  removeTimestampPrefix,
  getFileBaseName,
} from "@common/helpers";

export default {
  layout: Layout,
  props: ["spMembers", "types", "classifications", "legislation", "coAuthor", "sponsors"],
  components: {
    Link,
    vSelect,
    FullScreenLoader,
    AllFields,
    Head,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });

    const processing = ref(false);
    const errors = ref({});
    const form = reactive({
      sessionDate: "",
      classification: "",
      reference_no: "",
      title: "",
      type: "",
      description: "",
      author: "",
      co_author: "",
      sponsors: [],
      attachment: "",
    });

    onMounted(() => {
      form.sessionDate = props.legislation.legislable.session_date;
      form.classification = props.legislation.classification;
      form.reference_no = props.legislation.reference_no;
      form.title = props.legislation.title;
      form.type = props.legislation.legislable.type;
      form.description = props.legislation.description;
      form.author = props.legislation.author;
      form.author = parseInt(props.legislation.legislable.author);
      form.co_author = parseInt(props.coAuthor);
      form.sponsors = props.legislation.sponsors.map((sponsor) => parseInt(sponsor.id));
      form.attachment = props.legislation.attachment;
    });

    const onUploadFile = (event) => {
      form.attachment = event.target.files[0];
    };

    const onSubmitRecord = () => {
      processing.value = true;
      let formData = new FormData();
      formData.append("sessionDate", form.sessionDate);
      formData.append("classification", form.classification);
      formData.append("reference_no", form.reference_no);
      formData.append("title", form.title);
      formData.append("type", form.type);
      formData.append("description", form.description);
      formData.append("author", form.author);
      formData.append("co_author", form.co_author);
      formData.append("sponsors", JSON.stringify(form.sponsors));
      formData.append("attachment", form.attachment);

      axios
        .post(`/administrator/update-legislation/${props.legislation.id}`, formData)
        .then((response) => {
          if (response.status === 200) {
            processing.value = false;
            errors.value = {};
            notyf.success("Legislation / Resolution created successfully.");
          }
        })
        .catch((error) => {
          processing.value = false;
          if (error?.response.status === 422) {
            errors.value = error.response.data.errors;
          }
        });
    };

    return {
      form,
      errors,
      processing,
      getBaseURL,
      removeFileExtension,
      getIconByFileName,
      removeTimestampPrefix,
      getFileBaseName,
      onUploadFile,
      onSubmitRecord,
    };
  },
};
</script>

<template>
  <div>
    <Head title="Edit Legislation / Resolution" />
    <FullScreenLoader :processing="processing" />
    <AllFields />
    <div class="card">
      <div
        class="card-header bg-dark justify-content-between p-3 align-items-center d-flex bg-light"
      >
        <h6 class="card-title h6 fw-medium text-white">Edit Legislation / Resolution</h6>
      </div>
      <div class="card-body">
        <form @submit.prevent="onSubmitRecord" enctype="multipart/form-data">
          <div class="form-group mb-3" v-auto-animate>
            <label for="sessionDate" class="form-label required">Session Date</label>
            <input
              type="date"
              class="form-control"
              name="sessionDate"
              id="sessionDate"
              v-model="form.sessionDate"
              :class="{ 'is-invalid': errors.sessionDate }"
            />
            <div class="invalid-feedback" v-if="errors.sessionDate">
              {{ errors.sessionDate[0] }}
            </div>
          </div>
          <div class="form-group mb-3" v-auto-animate>
            <label for="classification" class="form-label required">Classification</label>
            <select
              name="classification"
              id="classification"
              v-model="form.classification"
              class="form-select text-uppercase"
              :class="{ 'is-invalid': errors.classification }"
            >
              <option
                :value="classification"
                v-for="(classification, index) in classifications"
                :key="index"
              >
                {{ classification }}
              </option>
            </select>

            <div class="invalid-feedback" v-if="errors.classification">
              {{ errors.classification[0] }}
            </div>
          </div>

          <div class="form-group mb-3" v-auto-animate>
            <label class="form-label" id="resolution_no">Reference No.</label>
            <input
              type="text"
              class="form-control"
              name="reference_no"
              v-model="form.reference_no"
              id="resolution_no"
              :class="{ 'is-invalid': errors.reference_no }"
            />

            <div class="invalid-feedback" v-if="errors.reference_no">
              {{ errors.reference_no[0] }}
            </div>
          </div>

          <div class="form-group mb-3">
            <label class="form-label required" for="title">Title</label>
            <textarea
              name="title"
              id="title"
              class="form-control"
              v-model="form.title"
              :class="{ 'is-invalid': errors.title }"
            ></textarea>
            <div class="invalid-feedback">
              {{ errors.title ? errors.title[0] : "" }}
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="type" class="form-label required">Type</label>
            <select
              class="form-select text-uppercase"
              name="type"
              v-model="form.type"
              id="type"
              :class="{ 'is-invalid': errors.type }"
            >
              <option :value="type.id" v-for="type in types" :key="type.id">
                {{ type.name }}
              </option>
            </select>
            <div class="invalid-feedback" v-if="errors.type">
              {{ errors.type[0] }}
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="form-label required" for="description">Description</label>
            <textarea
              type="text"
              class="form-control"
              name="description"
              v-model="form.description"
              id="description"
              :class="{ 'is-invalid': errors.description }"
            ></textarea>
            <div class="invalid-feedback" v-if="errors.description">
              {{ errors.description[0] }}
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="form-label" for="author">Author</label>
            <v-select
              class="border rounded"
              :class="{ 'border-danger': errors.author }"
              v-model="form.author"
              :options="spMembers"
              label="fullname"
              :reduce="(spMembers) => spMembers.id"
            ></v-select>
            <div class="invalid-feedback" v-if="errors.author">
              {{ errors.author[0] }}
            </div>
          </div>

          <div class="form-group">
            <div class="form-group mb-3">
              <label class="form-label" for="co_author">Co-Author</label>
              <v-select
                class="border rounded"
                :class="{ 'border-danger': errors.co_author }"
                v-model="form.co_author"
                :options="spMembers"
                :reduce="(spMembers) => spMembers.id"
                label="fullname"
              ></v-select>
              <div class="invalid-feedback" v-if="errors.co_author">
                {{ errors.co_author[0] }}
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label class="form-label" for="sponsors">Sponsors</label>
            <v-select
              class="border rounded"
              :class="{ 'border-danger': errors.co_author }"
              multiple
              v-model="form.sponsors"
              :options="spMembers"
              :reduce="(spMembers) => spMembers.id"
              label="fullname"
            ></v-select>
            <div class="invalid-feedback" v-if="errors.sponsors">
              {{ errors.sponsors[0] }}
            </div>
          </div>

          <img
            :src="`${getBaseURL()}${getIconByFileName(legislation.legislable.file)}`"
            style="width: 100px"
            alt="No Image"
          />
          <h6 class="fw-bold">
            {{
              removeTimestampPrefix(
                removeFileExtension(getFileBaseName(legislation.legislable.file))
              )
            }}
          </h6>

          <div class="form-group mb-3">
            <label class="form-label required">Attachment</label>
            <input
              type="file"
              @change="onUploadFile"
              class="form-control"
              name="attachment"
              id="attachment"
              :class="{ 'is-invalid': errors.attachment }"
            />
            <div class="invalid-feedback" v-if="errors.attachment">
              {{ errors.attachment[0] }}
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <Link
                class="text-decoration-underline fw-bold text-primary"
                href="/administrator/legislation"
                >Back</Link
              >
            </div>
            <div>
              <button type="submit" class="btn btn-success shadow-sm" id="btnSave">
                <i class="mdi mdi-send me-2"></i>
                Update Legislation
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
