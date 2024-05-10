<script setup>
import { inject, defineComponent, provide, ref, watch } from "vue";
import Layout from "@pages/Layout.vue";
import ResolutionHeader from "@components/Resolution/Header.vue";
import ResolutionMembers from "@components/Resolution/Members.vue";
import { VuePDF, usePDF } from "@tato30/vue-pdf";

defineComponent({
  ResolutionHeader,
  ResolutionMembers,
});

const props = defineProps({
  schedule: {
    type: Object,
    required: true,
  },
});
const config = inject("$config");

const addBody = () => {
  config.socket.emit("WRITE_RESO");
};

const page = ref(1);
const { pdf, pages } = usePDF("");

config.socket.on("UPDATE_RESO_DOCX_TO_PDF_COMPLETE", (data) => {
  page.value = 1;

  const { pdf: newPDFToLoad, pages: newPages } = usePDF(`/legislations/${data.pdfPath}`);

  watch(newPDFToLoad, () => {
    pdf.value = newPDFToLoad.value;
  });

  watch(newPages, () => {
    pages.value = newPages.value;
  });
});

function onAnnotation(value) {
  console.log(value);
  if (value.type === "link") {
    window.open(value.data.url, "_blank");
  } else if (value.type === "form-button") {
    alert(`Button Clicked : ${value.data.fieldName}`);
  }
}

provide("schedule", ref(props.schedule));
</script>

<template>
  <div>
    <layout>
      <ResolutionHeader />
      <ResolutionMembers />

      <div class="w-100 p-0 m-0" v-for="page in pages" :key="page">
        <VuePDF
          :pdf="pdf"
          :page="page"
          annotation-layer
          text-layer
          fit-parent
          @annotation="onAnnotation"
        />
      </div>

      <div class="add-attachment-body">
        <button @click="addBody" class="btn btn-primary mb-2 btn-lg fw-medium">
          ADD RESOLUTION / ORDINANCE BODY
        </button>
      </div>
    </layout>
  </div>
</template>
<style scoped>
.add-attachment-body {
  height: 50vh;
  background-color: #f4f4f4;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e5e5;
}
</style>
