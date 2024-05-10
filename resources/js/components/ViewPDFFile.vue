<script setup>
import { usePDF, VuePDF } from "@tato30/vue-pdf";
import { defineComponent, onMounted, ref, watch, watchEffect } from "vue";
import { getBaseURL, getName } from "@common/helpers";
import { removeTimestampPrefix } from "../common/helpers";
import "@tato30/vue-pdf/style.css";

const page = ref(1);
const pages = ref(0);
const windowWidth = ref(window.innerWidth);
const { pdf } = usePDF("");

defineComponent({
  VuePDF,
});

const props = defineProps({
  file: {
    type: String,
    required: true,
  },
});

const getExtension = (filename) => {
  const parts = filename.split(".");
  return parts[parts.length - 1];
};

watchEffect(() => {
  if (props.file !== "") {
    page.value = 1;
    let extension = getExtension(props.file);

    const { pdf: newPDFToLoad, pages: newPages } = usePDF(
      `/storage/committees/${props.file.replace(extension, "pdf")}`
    );

    watch(newPDFToLoad, () => {
      pdf.value = newPDFToLoad.value;
    });

    watch(newPages, () => {
      pages.value = newPages.value;
    });
  }
});
const pagePrevious = () => {
  page.value = page.value > 1 ? page.value - 1 : page.value;
};

const pageNext = () => {
  page.value = page.value < pages.value ? page.value + 1 : page.value;
};

const handleKeyDown = (e) => {
  if (e.key === "ArrowRight") {
    pageNext();
  } else if (e.key === "ArrowLeft") {
    pagePrevious();
  }
};

function onAnnotation(value) {
  if (value.type === "link") {
    window.open(value.data.url, "_blank");
  }
}

onMounted(() => {
  window.addEventListener("keydown", handleKeyDown);
});
</script>

<template>
  <div class="d-flex align-items-center justify-content-center">
    <div
      class="modal fade"
      id="viewFileModal"
      tabindex="-1"
      aria-labelledby="viewFileModalTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" style="max-width: 95vw">
        <div class="modal-content">
          <div class="modal-header bg-dark d-flex flex-row justify-content-between">
            <div>
              <h5 class="modal-title" id="viewFileModalTitle">
                <span class="letter-spacing-1"
                  >FILE PREVIEW OF
                  <span class="fw-bolder">
                    {{ removeTimestampPrefix(getName(file || "_")) }}
                  </span>
                </span>
              </h5>
            </div>
          </div>
          <div class="modal-body p-0 d-flex justify-content-between">
            <button class="border px-2" @click="pagePrevious">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="currentColor"
                class="bi bi-chevron-left"
                viewBox="0 0 16 16"
              >
                <path
                  fill-rule="evenodd"
                  d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"
                />
              </svg>
            </button>
            <div class="d-flex flex-column justify-content-center">
              <h3 class="text-center fw-bold text-dark">{{ page }} / {{ pages }}</h3>
              <div style="position: relative">
                <VuePDF
                  :pdf="pdf"
                  :page="page"
                  annotation-layer
                  text-layer
                  scale="2"
                  @annotation="onAnnotation"
                />
              </div>
            </div>
            <button class="border px-2" @click="pageNext">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="currentColor"
                class="bi bi-chevron-right"
                viewBox="0 0 16 16"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.letter-spacing-1 {
  letter-spacing: 1px;
}
</style>
