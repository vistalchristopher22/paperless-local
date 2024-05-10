<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
  records: {
    required: true,
  },
  link: {
    required: true,
  },
});

const fetchRecords = (url) => {
  if (url) {
    router.visit(url, {
      preserveScroll: true,
      preserveState: true,
    });
  }
};
</script>
<template>
  <div>
    <nav aria-label="Page navigation" v-if="records?.data?.length !== 0">
      <ul class="pagination justify-content-end me-2">
        <li class="page-item" :class="{ disabled: !records.prev_page_url }">
          <a class="page-link" href="#" @click="fetchRecords(records.prev_page_url)">
            Previous
          </a>
        </li>
        <li
          class="page-item"
          v-for="page in records.last_page"
          :key="page"
          :class="{ active: page === records.current_page }"
        >
          <a class="page-link" href="#" @click="fetchRecords(`${link}?page=${page}`)">
            {{ page }}
          </a>
        </li>
        <li class="page-item" :class="{ disabled: !records.next_page_url }">
          <a class="page-link" href="#" @click="fetchRecords(records.next_page_url)">
            Next
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>
