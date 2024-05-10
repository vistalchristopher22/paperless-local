<script>
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link } from "@inertiajs/vue3";
export default {
  layout: Layout,
  components: {
    FullScreenLoader,
    Link,
  },
  props: {
    divisions: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    return {};
  },
};
</script>
<template>
  <div>
    <div>
      <!-- <FullScreenLoader :processing="processing" /> -->
      <div class="d-flex align-items-center justify-content-between mb-2">
        <div>
          <h5 class="fw-bolder text-uppercase">
            no. of records [ {{ divisions.length }} ]
          </h5>
        </div>
        <div class="">
          <Link href="/division/create" class="btn btn-dark shadow"
            >Add New Division</Link
          >
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-bordered border">
          <thead>
            <tr>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Name
              </th>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Description
              </th>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Division Chief
              </th>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="division in divisions" :key="division.index">
              <td class="text-center text-uppercase">{{ division.name }}</td>
              <td class="text-center text-uppercase">{{ division.description }}</td>
              <td class="text-start text-uppercase">
                <img
                  class="img-fluid rounded"
                  style="width: 2vw"
                  :src="`/storage/user-images/${division?.board_member?.profile_picture}`"
                />
                {{ division?.board_member?.fullname }}
              </td>
              <td class="align-middle text-center">
                <Link
                  :href="`/division/${division.id}/edit/`"
                  class="btn btn-soft-success"
                >
                  <i class="mdi mdi-pencil-outline"></i>
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<style></style>
