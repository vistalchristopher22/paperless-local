<script>
import Layout from "@pages/Layout.vue";
import Agenda from "@components/Agenda.vue";
import FullScreenLoader from "@components/FullScreenLoader.vue";
import { Link, router, Head } from "@inertiajs/vue3";
import { addNumberSuffix } from "@common/helpers";
import Widget from "@components/Widgets.vue";
import { Notyf } from "notyf";
import { ref, provide } from "vue";
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
    Head,
  },
  setup(props) {
    const notyf = new Notyf({
      duration: 4000,
    });
    const displayAgenda = ref(false);
    const agendas = ref([]);
    const processing = ref(false);
    const selectedMember = ref(null);
    provide("DISPLAY_AGENDA", displayAgenda);

    const deleteSanggunian = (id) => {
      alertify.prompt(
        "Authentication Require",
        "Are you sure you want to delete this Sanggunian Member?",
        "",
        function (_, value) {
          const formData = new FormData();
          formData.append("_method", "DELETE");
          formData.append("key", value);
          axios
            .post(`/sanggunian-members/${id}`, formData)
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
    <Head title="Complete Listing of Sanggunian Members" />

    <FullScreenLoader :processing="processing" />
    <Agenda :agendas="agendas">
      <template #title>
        <h5 class="fw-bolder text-uppercase">{{ selectedMember?.fullname }}</h5>
      </template>
    </Agenda>

    <div class="card bg-primary mt-3">
      <div class="card-body text-white d-flex align-items-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="currentColor"
          class="bi bi-info-circle-fill mx-2"
          viewBox="0 0 16 16"
        >
          <path
            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"
          />
        </svg>
        You can view the agenda information of a Sanggunian Member by clicking on the
        member's name.
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-2 mt-2">
      <div>
        <h5 class="fw-bolder text-uppercase">
          total records [ {{ members.length }} Entries ]
        </h5>
      </div>
      <div>
        <Link href="/sanggunian-members/create" class="btn btn-dark shadow">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-plus-circle-fill me-1"
            viewBox="0 0 16 16"
          >
            <path
              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"
            />
          </svg>
          Add New Member
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
              #
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              image
            </th>
            <th class="border text-white bg-dark border border-dark text-uppercase">
              Fullname
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              Title
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center text-uppercase"
            >
              Sanggunian
            </th>
            <th
              class="border text-white bg-dark border border-dark text-uppercase text-center"
            >
              District
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
                :src="`/storage/user-images/${member.profile_picture}`"
              />
            </td>
            <td
              class="text-dark fw-medium border cursor-pointer"
              @click="viewAgendaInformation(member.id)"
            >
              <span
                class="text-dark fw-bolder text-uppercase"
                style="letter-spacing: 0.9px"
              >
                {{ member.fullname }}
              </span>
            </td>
            <td class="text-dark fw-medium border cursor-pointer text-truncate">
              <span class="text-dark fw-bolder text-uppercase">
                {{ member.official_title }}
              </span>
            </td>
            <td class="text-dark text-center border">
              {{ addNumberSuffix(member.sanggunian) }} Sangguniang Panlalawigan Member
            </td>
            <td class="text-dark text-center border">
              <span v-if="member.district == 1"> First District </span>
              <span v-if="member.district == 2"> Second District </span>
            </td>
            <td class="text-dark text-center border">
              {{ member.created_at }}
            </td>
            <td class="text-dark text-center border">
              <div class="btn-group">
                <Link
                  :href="`/sanggunian-members/${member.id}/edit`"
                  class="btn btn-success text-white"
                  title="Edit Sanggunian Member"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  data-bs-original-title="Edit Sanggunian Member"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-pen-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"
                    />
                  </svg>
                  Edit
                </Link>
                <button
                  class="btn btn-danger text-white"
                  title="Remove Sanggunian Member"
                  @click="deleteSanggunian(member.id)"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  data-bs-original-title="Remove Sanggunian Member"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-trash-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"
                    />
                  </svg>
                  Delete
                </button>
              </div>
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
