<script>
import { ref, reactive, computed, watch } from "vue";
import Layout from "@pages/Layout.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import AgendaMembers from "@components/AgendaMembers.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
export default {
  layout: Layout,
  components: {
    FullScreenLoader,
    AgendaMembers,
    Link,
  },
  props: {
    agendas: {
      type: Array,
      required: true,
    },
    sanggunians: {
      required: true,
    },
  },
  setup(props) {
    const processing = ref(false);
    const displayMembers = ref(false);
    const fetchedMembers = ref([]);
    const showMembers = (committee) => {
      processing.value = true;
      axios.get(`/api/agenda-members/${committee.id}`).then((response) => {
        if (response.status === 200) {
          displayMembers.value = true;
          processing.value = false;
          fetchedMembers.value = response.data.agenda;
        }
      });
    };
    return {
      displayMembers,
      fetchedMembers,
      processing,
      showMembers,
    };
  },
};
</script>
<template>
  <div>
    <div>
      <FullScreenLoader :processing="processing" />
      <AgendaMembers :displayMembers="displayMembers" :fetchedMembers="fetchedMembers" />
      <div class="d-flex align-items-center justify-content-between mb-2">
        <div>
          <h5 class="fw-bolder text-uppercase">
            no. of committees [ {{ agendas.length }} ]
          </h5>
        </div>
        <div class="">
          <Link href="/agendas/create" class="btn btn-dark shadow"
            >Add New Agenda / Chairmanship</Link
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
                #
              </th>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Title / Committee
              </th>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Chairman
              </th>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Vice-chairman
              </th>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Members
              </th>
              <th
                class="border text-center text-white bg-dark border border-dark text-uppercase"
              >
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(committee, index) in agendas" :key="index">
              <td class="text-center">{{ committee.index }}</td>
              <td
                class="text-start fw-bolder text-capitalize text-decoration-underline"
                style="cursor: pointer"
                @click="showMembers(committee)"
              >
                {{ committee.title?.toLowerCase().replace("committee on", "") }}
              </td>
              <td class="text-start text-capitalize fw-bold" @click="so">
                {{ committee.chairman_information.fullname }}
              </td>
              <td class="text-start text-capitalize fw-bold">
                {{ committee.vice_chairman_information.fullname }}
              </td>
              <td class="text-center">
                <a
                  class="btn btn-sm btn-soft-primary text-center"
                  @click="showMembers(committee)"
                  v-html="`View Members - <strong>[${committee.members.length}]</strong>`"
                ></a>
              </td>
              <td class="text-center">
                <Link
                  class="btn btn-soft-success"
                  :href="`/agendas/${committee.id}/edit`"
                  title="Edit Agenda"
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
