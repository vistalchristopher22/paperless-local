<script>
import Layout from "@pages/Layout.vue";
import { Link } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";
import FullScreenLoader from "@components/FullScreenLoader.vue";

export default {
  props: {},
  layout: Layout,
  components: {
    Link,
    FullScreenLoader,
  },
  setup() {
    const notyf = new Notyf({
      duration: 4000,
    });
    const processing = ref(false);
    const errors = ref({});
    const sanggunian = reactive({
      fullname: "",
      district: "",
      sanggunian_number: "19",
      image: "",
    });

    const onUploadImage = (event) => {
      sanggunian.image = event.target.files[0];
    };

    const createSanggunian = () => {
      processing.value = true;
      const formData = new FormData();
      formData.append("fullname", sanggunian.fullname);
      formData.append("district", sanggunian.district);
      formData.append("sanggunian", sanggunian.sanggunian_number);
      formData.append("image", sanggunian.image);

      axios
        .post("/sanggunian-members", formData)
        .then((_) => {
          notyf.success("Sanggunian Member Created Successfully");
          processing.value = false;
          errors.value = {};
          sanggunian.value = {
            fullname: null,
            district: null,
            sanggunian_number: null,
            image: null,
          };
        })
        .catch((error) => {
          processing.value = false;
          if (error.response.status === 422) {
            errors.value = error.response.data.errors;
          }
        });
    };

    return {
      createSanggunian,
      onUploadImage,
      sanggunian,
      errors,
      processing,
    };
  },
};
</script>

<template>
  <FullScreenLoader :processing="processing" />
  <div class="card">
    <div
      class="card-header bg-dark justify-content-between p-3 align-items-center d-flex bg-light"
    >
      <h6 class="card-title h6 fw-medium text-white">New Sangguniang Member Form</h6>
    </div>
    <div class="card-body">
      <form @submit.prevent="createSanggunian">
        <div class="form-group mb-3" v-auto-animate>
          <label for="fullname" class="form-label">Fullname</label>
          <input
            type="text"
            name="fullname"
            id="fullname"
            autofocus
            v-model="sanggunian.fullname"
            class="form-control"
            :class="{ 'is-invalid': errors.fullname }"
          />
          <div class="invalid-feedback" v-if="errors.fullname">
            {{ errors.fullname[0] }}
          </div>
        </div>

        <div class="form-group mb-3" v-auto-animate>
          <label for="district" class="form-label">District</label>
          <select
            type="text"
            name="district"
            id="district"
            class="form-control"
            v-model="sanggunian.district"
            :class="{ 'is-invalid': errors.district }"
          >
            <option value="1">1st District</option>
            <option value="2">2nd District</option>
          </select>
          <div class="invalid-feedback" v-if="errors.district">
            {{ errors.district[0] }}
          </div>
        </div>

        <div class="form-group mb-3" v-auto-animate>
          <label for="sanggunian" class="form-label">Sanggunian</label>
          <input
            type="text"
            name="sanggunian"
            id="sanggunian"
            class="form-control"
            :class="{ 'is-invalid': errors.sanggunian }"
            v-model="sanggunian.sanggunian_number"
          />
          <div class="invalid-feedback" v-if="errors.sanggunian">
            {{ errors.sanggunian[0] }}
          </div>
        </div>

        <div class="form-group mt-3" v-auto-animate>
          <label for="image" class="form-label">Image</label>
          <input
            type="file"
            class="form-control"
            name="image"
            id="image"
            @change="onUploadImage"
            :class="{ 'is-invalid': errors.image }"
          />
          <div class="invalid-feedback" v-if="errors.image">
            {{ errors.image[0] }}
          </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            <Link
              href="/sanggunian-members"
              class="text-decoration-underline fw-bold text-primary"
              >Back</Link
            >
          </div>

          <div>
            <button type="submit" class="btn btn-dark shadow">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<style scoped></style>
