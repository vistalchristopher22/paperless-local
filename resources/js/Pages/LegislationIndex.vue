<script>
import Layout from "@pages/Layout.vue";
import { Link, router } from "@inertiajs/vue3";
import { reactive, ref, watch } from "vue";
import { getBaseURL } from "@common/helpers";
import vSelect from "vue-select";

export default {
  props: {
    legislations: {
      type: Object,
      required: true,
    },
    types: {
      type: Array,
      required: true,
    },
    spMembers: {
      type: Array,
      required: true,
    },
    classifications: {
      type: Array,
      required: true,
    },
    author: {
      type: String,
    },
    classification: {
      type: String,
    },
    type: {
      type: String,
    },
    fromDate: {
      type: String,
    },
    toDate: {
      type: String,
    },
  },
  layout: Layout,
  components: {
    Link,
    vSelect,
  },
  setup(props) {
    const baseURL = getBaseURL();
    const fetchLegislations = (url) => router.visit(url, { preserveScroll: true });

    const fromDate = ref("");
    const toDate = ref("");
    const type = ref("");
    const classification = ref("");
    const filterAuthor = ref("");

    fromDate.value = props.fromDate;
    toDate.value = props.toDate;
    classification.value = props.classification;
    filterAuthor.value = props.spMembers.find((member) => member.id == props.author);
    type.value = props.types.find((type) => type.id == props.type);

    watch([fromDate, toDate, type, classification, filterAuthor], () => {
      const params = {
        from_date: fromDate.value,
        to_date: toDate.value,
        type: typeof type.value === "object" ? type?.value?.id : type.value,
        classification: classification.value,
        author:
          typeof filterAuthor.value === "object"
            ? filterAuthor?.value?.id
            : filterAuthor.value,
      };

      Object.keys(params).forEach((key) => params[key] == null && delete params[key]);

      const searchParams = new URLSearchParams(params).toString();
      fetchLegislations(`${baseURL}/administrator/legislation?${searchParams}`);
    });

    return {
      baseURL,
      fromDate,
      toDate,
      type,
      classification,
      filterAuthor,
      fetchLegislations,
    };
  },
};
</script>

<template>
  <div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-2">
            <label for="daterange" class="form-label text-dark">Start Date</label>
            <div class="input-group">
              <input type="date" class="form-control" v-model="fromDate" />
            </div>
          </div>
          <div class="col-lg-2">
            <label for="daterange" class="form-label text-dark">End Date</label>
            <div class="input-group">
              <input type="date" class="form-control" v-model="toDate" />
            </div>
          </div>
          <div class="col-lg-3">
            <label for="author" class="form-label text-dark">Author</label>
            <v-select
              class="border text-uppercase"
              :options="spMembers"
              label="fullname"
              v-model="filterAuthor"
              :reduce="(spMembers) => spMembers.id"
            ></v-select>
          </div>
          <div class="col-lg-2">
            <label for="type" class="form-label text-dark">Type</label>
            <v-select
              name="type"
              id="type"
              v-model="type"
              class="text-uppercase"
              :options="types"
              label="name"
              :reduce="(type) => type.id"
            >
            </v-select>
          </div>
          <div class="col-lg-3">
            <label for="classification" class="form-label text-dark"
              >Classification</label
            >
            <v-select
              name="classification"
              id="classification"
              v-model="classification"
              class="text-uppercase"
              :options="classifications"
              label="id"
            >
            </v-select>
          </div>
        </div>

        <!-- <div class="row mt-2">
          <div class="col-lg-12">
            <label for="sponsors" class="form-label text-dark">Sponsors</label>
            <v-select
              name="sponsors"
              id="sponsors"
              class="text-uppercase"
              v-model="filterSponsors"
              :options="spMembers"
              :reduce="(member) => member.id"
              multiple
              label="fullname"
            >
            </v-select>
          </div>
        </div> -->
      </div>
    </div>

    <Link href="/administrator/legislation/create" class="btn btn-dark my-2 float-end"
      >Add New Ordinance / Resolution</Link
    >
    <table class="table table-hover border" id="legislationTable" width="100%">
      <thead>
        <tr class="bg-light">
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            No
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Reference No.
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Title
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Type
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Author
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Co-Author
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Description
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Classification
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Session Date
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="legislation in legislations.data" :key="legislation.id">
          <td class="text-center fw-bold">{{ legislation.no }}</td>
          <td class="text-center">{{ legislation.reference_no }}</td>
          <td>{{ legislation.title }}</td>
          <td class="text-uppercase text-center">
            <span class="badge bg-warning">{{
              legislation?.legislable?.record_type?.name
            }}</span>
          </td>
          <td class="text-uppercase text-start">
            {{ legislation?.legislable?.author_information?.fullname }}
          </td>
          <td class="text-uppercase text-start">
            {{ legislation?.legislable?.co_author_information?.fullname }}
          </td>
          <td>{{ legislation?.description }}</td>
          <td class="text-uppercase text-center">
            <span
              class="badge bg-primary"
              v-if="legislation?.classification?.toLowerCase() === 'resolution'"
            >
              {{ legislation?.classification }}
            </span>
            <span class="badge bg-success" v-else>
              {{ legislation?.classification }}
            </span>
          </td>
          <td class="text-center">{{ legislation?.legislable?.session_date }}</td>
          <td class="text-center">
            <Link
              :href="`/administrator/legislation/${legislation.id}/edit`"
              class="btn btn-soft-success"
            >
              <i class="mdi mdi-pencil"></i>
            </Link>

            <a
              :href="`/administrator/legislation/download/${legislation.id}`"
              class="btn btn-soft-primary mx-2"
              download
            >
              <i class="mdi mdi-download"></i>
            </a>

            <a class="btn btn-soft-info" target="_blank">
              <i class="mdi mdi-eye"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-end me-2">
        <li class="page-item" :class="{ disabled: !legislations.prev_page_url }">
          <a
            class="page-link"
            href="#"
            @click="fetchLegislations(legislations.prev_page_url)"
          >
            Previous
          </a>
        </li>
        <li
          class="page-item"
          v-for="page in legislations.last_page"
          :key="page"
          :class="{ active: page === legislations.current_page }"
        >
          <a
            class="page-link"
            href="#"
            @click="
              fetchLegislations(`${baseURL}/administrator/legislation?page=${page}`)
            "
          >
            {{ page }}
          </a>
        </li>
        <li class="page-item" :class="{ disabled: !legislations.next_page_url }">
          <a class="page-link" href="#"> Next </a>
        </li>
      </ul>
    </nav>
  </div>
</template>
<style scoped></style>
