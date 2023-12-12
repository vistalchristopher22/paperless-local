<script>
import Layout from "@pages/Layout.vue";
import Agenda from "@components/Agenda.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link, router } from "@inertiajs/vue3";
import { addNumberSuffix } from "@common/helpers";
import Widget from "@components/Widgets.vue";
import { Notyf } from "notyf";
import { ref } from "vue";
import axios from "axios";

export default {
  props: {
    members: {
      type: Array,
      required: true,
    },
    value: {
      required: false,
    },
  },
  layout: Layout,
  components: {
    Link,
    Agenda,
    FullScreenLoader,
    Widget,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const displayAgenda = ref(false);
    const agendas = ref([]);
    const processing = ref(false);
    const selectedMember = ref(null);

    const deleteSanggunian = (id) => {
      alertify.prompt(
        "Authentication",
        "Are you sure you want to delete this Sanggunian Member?",
        "",
        function (_, value) {
          axios
            .post(`/sanggunian-members/${id}`, {
              key: value,
              _method: "DELETE",
            })
            .then((_) => {
              notyf.success("Sanggunian Member Deleted Successfully");
              router.visit("/sanggunian-members", {
                preserveScroll: true,
              });
            })
            .catch((error) => {
              notyf.error(error.response.data.message);
            });
        },
        function () {}
      );
    };

    const viewAgendaInformation = (id) => {
      processing.value = true;
      displayAgenda.value = true;
      selectedMember.value = props.members.find((member) => member.id === id);
      axios.get(`/sanggunian-member/${id}/agendas/show`).then((response) => {
        agendas.value = response.data;
        processing.value = false;
      });
    };

    return {
      deleteSanggunian,
      viewAgendaInformation,
      addNumberSuffix,
      displayAgenda,
      agendas,
      processing,
      selectedMember,
    };
  },
};
</script>

<template>
  <div>
    <FullScreenLoader :processing="processing" />
    <Agenda :displayAgenda="displayAgenda" :agendas="agendas">
      <template #title>
        <h5 class="fw-bolder text-uppercase">{{ selectedMember?.fullname }}</h5>
      </template>
    </Agenda>
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div>
        <h5 class="fw-bolder text-uppercase">
          total records [ {{ members.length }} Entries ]
        </h5>
      </div>
      <div>
        <Link href="/sanggunian-members/create" class="btn btn-dark shadow"
          >Add New Member</Link
        >
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover border" id="members-table">
        <thead>
          <tr class="bg-light">
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              #
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              image
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Fullname
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              District
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              Sanggunian
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              Created At
            </th>
            <th
              class="border text-center text-white bg-dark border border-dark text-uppercase"
            >
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="member in members" :key="member.id">
            <td class="text-center">{{ member.id }}</td>
            <td class="text-center border" style="width: 3vw">
              <img
                class="img-fluid rounded"
                :src="`http://localhost:8000/storage/user-images/${member.profile_picture}`"
              />
            </td>
            <td
              class="text-dark fw-medium border cursor-pointer"
              @click="viewAgendaInformation(member.id)"
            >
              <span
                class="mx-5 text-dark fw-bolder text-uppercase"
                style="letter-spacing: 0.9px"
              >
                {{ member.fullname }}
              </span>
            </td>
            <td class="text-dark text-center border">{{ member.district }}</td>
            <td class="text-dark text-center border">
              {{ addNumberSuffix(member.sanggunian) }} Sangguniang Panlalawigan Member
            </td>
            <td class="text-dark text-center border">
              {{ member.created_at }}
            </td>
            <td class="text-dark text-center border">
              <Link
                :href="`/sanggunian-members/${member.id}/edit`"
                class="btn btn-soft-success text-white me-2"
                title="Edit Sanggunian Member"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-original-title="Edit Sanggunian Member"
              >
                <i class="mdi mdi-pencil-outline"></i>
              </Link>
              <button
                class="btn btn-soft-danger text-white"
                title="Remove Sanggunian Member"
                @click="deleteSanggunian(member.id)"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-original-title="Remove Sanggunian Member"
              >
                <i class="mdi mdi-trash-can-outline"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
