<script>
import Layout from "@pages/Layout.vue";
import { Link, router, Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { getBaseURL, strLimit } from "@common/helpers";
import vSelect from "vue-select";
import axios from "axios";

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
    filter: {
      required: false,
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
    Head,
    vSelect,
  },
  setup(props) {
    const displayFilter = ref(props.filter || false);
    const displayDownloadSpinner = ref(false);
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
      fetchLegislations(
        `${baseURL}/administrator/legislation?${searchParams}&filter=${displayFilter.value}`
      );
    });

    const filterDisplay = () => {
      if (displayFilter.value) {
        router.visit("/administrator/legislation");
      } else {
        displayFilter.value = true;
      }
    };

    const downloadFile = (legislation) => {
      displayDownloadSpinner.value = true;
      axios
        .get(`/administrator/legislation/download/${legislation.id}`, {
          responseType: "blob",
        })
        .then((response) => {
          const blob = new Blob([response.data], { type: "application/pdf" }); // Specify the MIME type for PDF
          const link = document.createElement("a");
          link.href = URL.createObjectURL(blob);
          link.download = `${legislation.no}.pdf`;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          URL.revokeObjectURL(link.href);
          displayDownloadSpinner.value = false;
        })
        .catch(console.error);
    };

    return {
      displayDownloadSpinner,
      downloadFile,
      filterDisplay,
      displayFilter,
      baseURL,
      fromDate,
      toDate,
      type,
      classification,
      filterAuthor,
      fetchLegislations,
      strLimit,
    };
  },
};
</script>

<template>
  <Head title="Complete Listing of Ordinance & Resolution" />
  <div>
    <div class="card mt-3 rounded-0" v-if="displayFilter">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-2">
            <label for="daterange" class="form-label text-dark fw-bold">Start Date</label>
            <div class="input-group">
              <input type="date" class="form-control" v-model="fromDate" />
            </div>
          </div>
          <div class="col-lg-2">
            <label for="daterange" class="form-label text-dark fw-bold">End Date</label>
            <div class="input-group">
              <input type="date" class="form-control" v-model="toDate" />
            </div>
          </div>
          <div class="col-lg-3">
            <label for="author" class="form-label text-dark fw-bold">Author</label>
            <v-select
              class="border text-uppercase"
              :options="spMembers"
              label="fullname"
              v-model="filterAuthor"
              :reduce="(spMembers) => spMembers.id"
            ></v-select>
          </div>
          <div class="col-lg-2">
            <label for="type" class="form-label text-dark fw-bold">Type</label>
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
            <label for="classification" class="form-label text-dark fw-bold"
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

    <div class="btn-group my-2 float-end mt-3">
      <button class="btn btn-primary" @click="filterDisplay">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="currentColor"
          class="bi bi-funnel-fill"
          viewBox="0 0 16 16"
        >
          <path
            d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"
          />
        </svg>
        Filter
      </button>
      <button class="btn btn-dark">
        <Link href="/administrator/legislation/create" class="text-white">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-file-earmark-plus-fill"
            viewBox="0 0 16 16"
          >
            <path
              d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0"
            />
          </svg>
          Add New Ordinance / Resolution
        </Link>
      </button>
    </div>

    <table class="table table-hover border" id="legislationTable" width="100%">
      <thead>
        <tr class="bg-light">
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-start"
          >
            No
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Ref No.
          </th>
          <th
            class="border text-white bg-dark border border-dark text-uppercase text-center"
          >
            Title
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
          <td class="fw-bold">{{ legislation.no }}</td>
          <td class="text-start">{{ legislation.reference_no }}</td>
          <td class="text-start">{{ strLimit(legislation.title, 30, "...") }}</td>
          <td class="text-uppercase text-start">
            {{ legislation?.legislable?.author_information?.fullname }}
          </td>
          <td class="text-uppercase text-start">
            {{ legislation?.legislable?.co_author_information?.fullname }}
          </td>
          <td class="text-uppercase text-center">
            <div v-if="legislation?.classification?.toLowerCase() === 'resolution'">
              <span class="badge bg-primary me-2">
                {{ legislation?.classification }}
              </span>

              <span class="badge bg-warning">{{
                legislation?.legislable?.record_type?.name
              }}</span>
            </div>

            <div v-else>
              <span class="badge bg-success me-2">
                {{ legislation?.classification }}
              </span>
              <span class="badge bg-warning">{{
                legislation?.legislable?.record_type?.name
              }}</span>
            </div>
          </td>
          <td class="text-center">{{ legislation?.legislable?.session_date }}</td>
          <td class="text-center">
            <div class="btn-group">
              <Link
                :href="`/administrator/legislation/${legislation.id}/edit`"
                class="btn btn-success"
              >
                Edit
              </Link>

              <button
                @click="downloadFile(legislation)"
                class="btn btn-primary"
                :disabled="displayDownloadSpinner"
              >
                <div
                  class="spinner-border text-light spinner-border-sm"
                  role="status"
                  v-if="displayDownloadSpinner"
                >
                  <span class="sr-only">Loading...</span>
                </div>
                <div v-else>Download</div>
              </button>

              <a class="btn btn-info" target="_blank"> View </a>
            </div>
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
