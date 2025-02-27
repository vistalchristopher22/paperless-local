<script>
import Layout from "@pages/Layout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";
import FullScreenLoader from "@components/FullScreenLoader.vue";
export default {
  props: {
    member: {
      required: true,
    },
  },
  layout: Layout,
  components: {
    Link,
    FullScreenLoader,
    Head,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const processing = ref(false);
    const errors = ref({});
    const sanggunian = reactive({
      fullname: props.member.fullname.replace("Hon. ", ""),
      district: props.member.district,
      sanggunian: props.member.sanggunian,
      official_title: props.member.official_title,
      image: "",
    });

    const updateSanggunian = () => {
      processing.value = true;
      const formData = new FormData();
      formData.append("fullname", sanggunian.fullname);
      formData.append("district", sanggunian.district);
      formData.append("sanggunian", sanggunian.sanggunian);
      formData.append("official_title", sanggunian.official_title || "");
      formData.append("image", sanggunian.image);
      formData.append("_method", "PUT");
      axios
        .post(`/sanggunian-members/${props.member.id}`, formData)
        .then((_) => {
          processing.value = false;
          notyf.success("Sanggunian Member Updated Successfully");
        })
        .catch((error) => {
          processing.value = false;
          if (error.response.status === 422) {
            errors.value = error.response.data.errors;
          }
        });
    };

    const onUploadImage = (event) => {
      sanggunian.image = event.target.files[0];
    };

    return {
      updateSanggunian,
      onUploadImage,
      sanggunian,
      errors,
      processing,
    };
  },
};
</script>

<template>
  <Head title="Edit Sanggunian Member" />
  <FullScreenLoader :processing="processing" />
  <AllFields />
  <div class="card mt-3">
    <div
      class="card-header bg-dark justify-content-between p-3 align-items-center d-flex bg-light"
    >
      <h6 class="card-title h6 fw-medium text-white">Edit Sanggunian Member</h6>
    </div>
    <div class="card-body">
      <form @submit.prevent="updateSanggunian">
        <div class="form-group mb-3" v-auto-animate>
          <label for="fullname" class="form-label">Fullname</label>
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1"> Hon. </span>
            <input
              type="text"
              class="form-control"
              name="fullname"
              id="fullname"
              autofocus
              v-model="sanggunian.fullname"
              :class="{ 'is-invalid': errors.fullname }"
            />
            <div class="invalid-feedback" v-if="errors.fullname">
              {{ errors.fullname[0] }}
            </div>
          </div>
          <div class="invalid-feedback" v-if="errors.fullname">
            {{ errors.fullname[0] }}
          </div>
        </div>

        <div class="form-group mb-3" v-auto-animate>
          <label for="district" class="form-label">District</label>
          <select
            class="form-select"
            v-model="sanggunian.district"
            name="district"
            id="district"
            :class="{ 'is-invalid': errors.district }"
          >
            <option value="1">First District</option>
            <option value="2">Second District</option>
          </select>
          <div class="invalid-feedback" v-if="errors.district">
            {{ errors.district[0] }}
          </div>
        </div>

        <div class="form-group mb-3" v-auto-animate>
          <label for="official_title" class="form-label">Official Title</label>
          <input
            type="text"
            name="official_title"
            id="official_title"
            class="form-control"
            :class="{ 'is-invalid': errors.official_title }"
            v-model="sanggunian.official_title"
          />
          <div class="invalid-feedback" v-if="errors.official_title">
            {{ errors.official_title[0] }}
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
            v-model="sanggunian.sanggunian"
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
            <button type="submit" class="btn btn-success shadow">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<style scoped></style>
