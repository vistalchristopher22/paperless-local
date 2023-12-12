<script>
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link, router } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import { ref } from "vue";

export default {
  props: {},
  layout: Layout,
  components: {
    Link,
    FullScreenLoader,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const displayAgenda = ref(false);
    const agendas = ref([]);
    const processing = ref(false);
    const selectedMember = ref(null);

    return {
      processing,
    };
  },
};
</script>

<template>
  <div>
    <FullScreenLoader :processing="processing" />
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div>
        <h5 class="fw-bolder text-uppercase">total records [ Entries ]</h5>
      </div>
      <div>
        <Link href="#" class="btn btn-dark shadow">
          <i class="mdi mdi-plus-circle me-1"></i>
          Add New Order of Business
        </Link>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover border" id="members-table">
        <thead>
          <tr class="bg-light">
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              Order Business Title
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Regular Session
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Filename
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Created At
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              Actions
            </th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</template>
