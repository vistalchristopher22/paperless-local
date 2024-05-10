<script setup>
import { usePDF, VuePDF } from "@tato30/vue-pdf";
import { defineComponent, watch, ref, onMounted } from "vue";
import { removeTimestampPrefix } from "@common/helpers";
import "@tato30/vue-pdf/style.css";

const props = defineProps({
  file: {
    type: String,
    required: true,
  },
  id: {
    required: true,
  },
  watermarkSchedule: {
    type: String,
    required: true,
  },
});

defineComponent({
  VuePDF,
});

const DEFAULT_SCALE_SIZE = 3.5;
const page = ref(1);
const pages = ref(0);
const { pdf } = usePDF("");
const fileName = ref(props.file);
const scale = ref(DEFAULT_SCALE_SIZE);
const pdfView = ref({});
const newPage = ref(1);
const pageScale = ref(scale.value);
const parentWidth = ref(scale.value * 20);
page.value = 1;

const { pdf: newPDFToLoad, pages: newPages } = usePDF(
  `/storage/committees/${props.file}`
);

watch(newPDFToLoad, () => {
  pdf.value = newPDFToLoad.value;
});

watch(newPages, () => {
  pages.value = newPages.value;
});

const goToNewPage = () => {
  if (newPage.value && typeof newPage.value == "number") {
    if (newPage.value > pages.value) {
      page.value = pages.value;
    }
    page.value = newPage.value;
  }
};

const pagePrevious = () => {
  page.value = page.value > 1 ? page.value - 1 : page.value;
  newPage.value = page.value;
};

const pageNext = () => {
  page.value = page.value < pages.value ? page.value + 1 : page.value;
  newPage.value = page.value;
};

const handleKeyDown = (e) => {
  if (e.key === "ArrowRight") {
    pageNext();
  } else if (e.key === "ArrowLeft") {
    pagePrevious();
  }
};

const onAnnotation = (value) => {
  if (value.type === "link") {
    window.open(value.data.url, "_blank");
  }
};

const highlightTextInsideInput = (e) => {
  e.target.select();
};

const changeScale = () => {
  if (pageScale.value >= 7) {
    return;
  }
  scale.value = pageScale.value;
  parentWidth.value = scale.value * 20;
  pdfView.value.reload();
};

const increaseScale = () => {
  if (scale.value >= 5) {
    return;
  }
  scale.value = scale.value + 0.25;
  pageScale.value = scale.value;
  parentWidth.value = scale.value * 20;
  pdfView.value.reload();
};

const decreaseScale = () => {
  if (scale.value <= 1) {
    return;
  }

  scale.value = scale.value - 0.25;
  pageScale.value = scale.value;
  parentWidth.value = scale.value * 20;
  pdfView.value.reload();
};

const presentationMode = () => {
  if (parentWidth.value >= 97) {
    parentWidth.value = scale.value * 20;
  } else {
    parentWidth.value = 97;
  }
  pdfView.value.reload();
};

onMounted(() => {
  window.addEventListener("keydown", handleKeyDown);
});
</script>

<template>
  <div>
    <nav class="toolbar d-flex align-items-center justify-content-between">
      <div class="fw-medium">
        <h6 class="text-white h6">{{ removeTimestampPrefix(fileName) }}</h6>
      </div>
      <div class="d-flex align-items-center justify-content-center">
        <input
          type="number"
          class="text-center h6 fw-normal text-white"
          v-model="newPage"
          @keyup.enter="goToNewPage"
          style="background: #00000080; width: 5%"
          @click="highlightTextInsideInput"
        />
        <div class="h6 text-white fw-normal">
          <strong class="mx-1">/</strong>{{ pages }}
        </div>
        <div class="h6 fw-normal mx-3" style="color: rgb(112 115 117)">
          <strong>|</strong>
        </div>
        <div class="h5 fw-normal text-white">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="2em"
            height="2em"
            class="cursor-pointer decrease-scale-btn"
            viewBox="0 0 24 24"
            @click="decreaseScale"
          >
            <path fill="currentColor" d="M19 13H5v-2h14z" />
          </svg>
          <input
            type="number"
            class="text-center h6 fw-normal text-white mx-2"
            v-model="pageScale"
            @keyup.enter="changeScale"
            style="background: #00000080; width: 20%"
          />
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="2em"
            height="2em"
            class="cursor-pointer increase-scale-btn"
            viewBox="0 0 24 24"
            @click="increaseScale"
          >
            <path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z" />
          </svg>

          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="2em"
            height="2em"
            viewBox="0 0 24 24"
            class="ms-1 cursor-pointer fullscreen-btn"
            @click="presentationMode"
          >
            <path
              fill="currentColor"
              d="M7 14H5v5h5v-2H7zm-2-4h2V7h3V5H5zm12 7h-3v2h5v-5h-2zM14 5v2h3v3h2V5z"
            />
          </svg>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-center">
        <a :href="`/order-business-file/download/${id}`" class="text-white">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="3em"
            height="3em"
            viewBox="0 0 24 24"
            class="cursor-pointer download-btn"
          >
            <path fill="currentColor" d="M5 20h14v-2H5zM19 9h-4V3H9v6H5l7 7z" />
          </svg>
        </a>
      </div>
    </nav>
    <div class="w-100 main-container">
      <div class="page-container" :style="`width : ${parentWidth}vw`">
        <div>
          <VuePDF
            :watermark-text="watermarkSchedule?.toUpperCase()"
            :pdf="pdf"
            :page="page"
            annotation-layer
            ref="pdfView"
            text-layer
            @annotation="onAnnotation"
            class="pdf-viewer"
            fit-parent
          />
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.main-container {
  background: #4e5255;
  padding-left: 15px;
  padding-right: 15px;
  padding-top: 8px;
  padding-bottom: 8px;
  min-height: 100vh;
}

.page-container {
  margin: 0px auto;
}

.pdf-viewer {
  border-radius: 1px;
  position: relative;
  margin-top: 60px;
}
.page-container > span {
  font-size: 1.5rem;
  padding: 20px;
  font-weight: bold;
  color: #07073d;
}

/* remove the style arrow up and down of type number in input */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
  border: none;
}

.download-btn {
  padding: 5px;
  border-radius: 50%;
  transition: background 0.3s ease;
}
.download-btn:hover {
  background: #9aa0a6;
}

.increase-scale-btn {
  padding: 5px;
  border-radius: 50%;
  transition: background 0.3s ease;
}
.increase-scale-btn:hover {
  background: #9aa0a6;
}

.decrease-scale-btn {
  padding: 5px;
  border-radius: 50%;
  transition: background 0.3s ease;
}
.decrease-scale-btn:hover {
  background: #9aa0a6;
}
.fullscreen-btn {
  padding: 5px;
  border-radius: 50%;
  transition: background 0.3s ease;
}
.fullscreen-btn:hover {
  background: #9aa0a6;
}

.toolbar {
  position: fixed;
  top: 0;
  z-index: 99999;
  left: 0%;
  right: 0%;
  width: 100%;
  box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.09), 0 4px 8px rgba(0, 0, 0, 0.06),
    0 1px 2px rgba(0, 0, 0, 0.3), 0 2px 6px rgba(0, 0, 0, 0.15);
  --google-red-100-rgb: 244, 199, 195;
  --google-red-100: rgb(var(--google-red-100-rgb));
  --google-red-700-rgb: 197, 57, 41;
  --google-red-700: rgb(var(--google-red-700-rgb));
  --google-green-100-rgb: 183, 225, 205;
  --google-green-100: rgb(var(--google-green-100-rgb));
  --google-yellow-700-rgb: 240, 147, 0;
  --google-yellow-700: rgb(var(--google-yellow-700-rgb));
  --paper-red-50: #ffebee;
  --paper-red-100: #ffcdd2;
  --paper-red-200: #ef9a9a;
  --paper-red-300: #e57373;
  --paper-red-400: #ef5350;
  --paper-red-500: #f44336;
  --paper-red-600: #e53935;
  --paper-red-700: #d32f2f;
  --paper-red-800: #c62828;
  --paper-red-900: #b71c1c;
  --paper-red-a100: #ff8a80;
  --paper-red-a200: #ff5252;
  --paper-red-a400: #ff1744;
  --paper-red-a700: #d50000;
  --paper-light-blue-50: #e1f5fe;
  --paper-light-blue-100: #b3e5fc;
  --paper-light-blue-200: #81d4fa;
  --paper-light-blue-300: #4fc3f7;
  --paper-light-blue-400: #29b6f6;
  --paper-light-blue-500: #03a9f4;
  --paper-light-blue-600: #039be5;
  --paper-light-blue-700: #0288d1;
  --paper-light-blue-800: #0277bd;
  --paper-light-blue-900: #01579b;
  --paper-light-blue-a100: #80d8ff;
  --paper-light-blue-a200: #40c4ff;
  --paper-light-blue-a400: #00b0ff;
  --paper-light-blue-a700: #0091ea;
  --paper-yellow-50: #fffde7;
  --paper-yellow-100: #fff9c4;
  --paper-yellow-200: #fff59d;
  --paper-yellow-300: #fff176;
  --paper-yellow-400: #ffee58;
  --paper-yellow-500: #ffeb3b;
  --paper-yellow-600: #fdd835;
  --paper-yellow-700: #fbc02d;
  --paper-yellow-800: #f9a825;
  --paper-yellow-900: #f57f17;
  --paper-yellow-a100: #ffff8d;
  --paper-yellow-a200: #ffff00;
  --paper-yellow-a400: #ffea00;
  --paper-yellow-a700: #ffd600;
  --paper-orange-50: #fff3e0;
  --paper-orange-100: #ffe0b2;
  --paper-orange-200: #ffcc80;
  --paper-orange-300: #ffb74d;
  --paper-orange-400: #ffa726;
  --paper-orange-500: #ff9800;
  --paper-orange-600: #fb8c00;
  --paper-orange-700: #f57c00;
  --paper-orange-800: #ef6c00;
  --paper-orange-900: #e65100;
  --paper-orange-a100: #ffd180;
  --paper-orange-a200: #ffab40;
  --paper-orange-a400: #ff9100;
  --paper-orange-a700: #ff6500;
  --paper-grey-50: #fafafa;
  --paper-grey-100: #f5f5f5;
  --paper-grey-200: #eeeeee;
  --paper-grey-300: #e0e0e0;
  --paper-grey-400: #bdbdbd;
  --paper-grey-500: #9e9e9e;
  --paper-grey-600: #757575;
  --paper-grey-700: #616161;
  --paper-grey-800: #424242;
  --paper-grey-900: #212121;
  --paper-blue-grey-50: #eceff1;
  --paper-blue-grey-100: #cfd8dc;
  --paper-blue-grey-200: #b0bec5;
  --paper-blue-grey-300: #90a4ae;
  --paper-blue-grey-400: #78909c;
  --paper-blue-grey-500: #607d8b;
  --paper-blue-grey-600: #546e7a;
  --paper-blue-grey-700: #455a64;
  --paper-blue-grey-800: #37474f;
  --paper-blue-grey-900: #263238;
  --dark-divider-opacity: 0.12;
  --dark-disabled-opacity: 0.38;
  --dark-secondary-opacity: 0.54;
  --dark-primary-opacity: 0.87;
  --light-divider-opacity: 0.12;
  --light-disabled-opacity: 0.3;
  --light-secondary-opacity: 0.7;
  --light-primary-opacity: 1;
  --google-blue-50-rgb: 232, 240, 254;
  --google-blue-50: rgb(var(--google-blue-50-rgb));
  --google-blue-100-rgb: 210, 227, 252;
  --google-blue-100: rgb(var(--google-blue-100-rgb));
  --google-blue-200-rgb: 174, 203, 250;
  --google-blue-200: rgb(var(--google-blue-200-rgb));
  --google-blue-300-rgb: 138, 180, 248;
  --google-blue-300: rgb(var(--google-blue-300-rgb));
  --google-blue-400-rgb: 102, 157, 246;
  --google-blue-400: rgb(var(--google-blue-400-rgb));
  --google-blue-500-rgb: 66, 133, 244;
  --google-blue-500: rgb(var(--google-blue-500-rgb));
  --google-blue-600-rgb: 26, 115, 232;
  --google-blue-600: rgb(var(--google-blue-600-rgb));
  --google-blue-700-rgb: 25, 103, 210;
  --google-blue-700: rgb(var(--google-blue-700-rgb));
  --google-blue-800-rgb: 24, 90, 188;
  --google-blue-800: rgb(var(--google-blue-800-rgb));
  --google-blue-900-rgb: 23, 78, 166;
  --google-blue-900: rgb(var(--google-blue-900-rgb));
  --google-green-50-rgb: 230, 244, 234;
  --google-green-50: rgb(var(--google-green-50-rgb));
  --google-green-200-rgb: 168, 218, 181;
  --google-green-200: rgb(var(--google-green-200-rgb));
  --google-green-300-rgb: 129, 201, 149;
  --google-green-300: rgb(var(--google-green-300-rgb));
  --google-green-400-rgb: 91, 185, 116;
  --google-green-400: rgb(var(--google-green-400-rgb));
  --google-green-500-rgb: 52, 168, 83;
  --google-green-500: rgb(var(--google-green-500-rgb));
  --google-green-600-rgb: 30, 142, 62;
  --google-green-600: rgb(var(--google-green-600-rgb));
  --google-green-700-rgb: 24, 128, 56;
  --google-green-700: rgb(var(--google-green-700-rgb));
  --google-green-800-rgb: 19, 115, 51;
  --google-green-800: rgb(var(--google-green-800-rgb));
  --google-green-900-rgb: 13, 101, 45;
  --google-green-900: rgb(var(--google-green-900-rgb));
  --google-grey-50-rgb: 248, 249, 250;
  --google-grey-50: rgb(var(--google-grey-50-rgb));
  --google-grey-100-rgb: 241, 243, 244;
  --google-grey-100: rgb(var(--google-grey-100-rgb));
  --google-grey-200-rgb: 232, 234, 237;
  --google-grey-200: rgb(var(--google-grey-200-rgb));
  --google-grey-300-rgb: 218, 220, 224;
  --google-grey-300: rgb(var(--google-grey-300-rgb));
  --google-grey-400-rgb: 189, 193, 198;
  --google-grey-400: rgb(var(--google-grey-400-rgb));
  --google-grey-500-rgb: 154, 160, 166;
  --google-grey-500: rgb(var(--google-grey-500-rgb));
  --google-grey-600-rgb: 128, 134, 139;
  --google-grey-600: rgb(var(--google-grey-600-rgb));
  --google-grey-700-rgb: 95, 99, 104;
  --google-grey-700: rgb(var(--google-grey-700-rgb));
  --google-grey-800-rgb: 60, 64, 67;
  --google-grey-800: rgb(var(--google-grey-800-rgb));
  --google-grey-900-rgb: 32, 33, 36;
  --google-grey-900: rgb(var(--google-grey-900-rgb));
  --google-grey-900-white-4-percent: #292a2d;
  --google-purple-200-rgb: 215, 174, 251;
  --google-purple-200: rgb(var(--google-purple-200-rgb));
  --google-purple-900-rgb: 104, 29, 168;
  --google-purple-900: rgb(var(--google-purple-900-rgb));
  --google-red-300-rgb: 242, 139, 130;
  --google-red-300: rgb(var(--google-red-300-rgb));
  --google-red-500-rgb: 234, 67, 53;
  --google-red-500: rgb(var(--google-red-500-rgb));
  --google-red-600-rgb: 217, 48, 37;
  --google-red-600: rgb(var(--google-red-600-rgb));
  --google-yellow-50-rgb: 254, 247, 224;
  --google-yellow-50: rgb(var(--google-yellow-50-rgb));
  --google-yellow-100-rgb: 254, 239, 195;
  --google-yellow-100: rgb(var(--google-yellow-100-rgb));
  --google-yellow-200-rgb: 253, 226, 147;
  --google-yellow-200: rgb(var(--google-yellow-200-rgb));
  --google-yellow-300-rgb: 253, 214, 51;
  --google-yellow-300: rgb(var(--google-yellow-300-rgb));
  --google-yellow-400-rgb: 252, 201, 52;
  --google-yellow-400: rgb(var(--google-yellow-400-rgb));
  --google-yellow-500-rgb: 251, 188, 4;
  --google-yellow-500: rgb(var(--google-yellow-500-rgb));
  --cr-card-background-color: white;
  --cr-shadow-key-color_: color-mix(in srgb, var(--cr-shadow-color) 30%, transparent);
  --cr-shadow-ambient-color_: color-mix(in srgb, var(--cr-shadow-color) 15%, transparent);
  --cr-elevation-1: var(--cr-shadow-key-color_) 0 1px 2px 0,
    var(--cr-shadow-ambient-color_) 0 1px 3px 1px;
  --cr-elevation-2: var(--cr-shadow-key-color_) 0 1px 2px 0,
    var(--cr-shadow-ambient-color_) 0 2px 6px 2px;
  --cr-elevation-3: var(--cr-shadow-key-color_) 0 1px 3px 0,
    var(--cr-shadow-ambient-color_) 0 4px 8px 3px;
  --cr-elevation-4: var(--cr-shadow-key-color_) 0 2px 3px 0,
    var(--cr-shadow-ambient-color_) 0 6px 10px 4px;
  --cr-elevation-5: var(--cr-shadow-key-color_) 0 4px 4px 0,
    var(--cr-shadow-ambient-color_) 0 8px 12px 6px;
  --cr-card-shadow: var(--cr-elevation-2);
  --cr-checked-color: var(--google-blue-600);
  --cr-focused-item-color: var(--google-grey-300);
  --cr-form-field-label-color: var(--google-grey-700);
  --cr-hairline-rgb: 0, 0, 0;
  --cr-iph-anchor-highlight-color: rgba(var(--google-blue-600-rgb), 0.1);
  --cr-menu-background-color: white;
  --cr-menu-background-focus-color: var(--google-grey-400);
  --cr-menu-shadow: 0 2px 6px var(--paper-grey-500);
  --cr-separator-color: rgba(0, 0, 0, 0.06);
  --cr-title-text-color: rgb(90, 90, 90);
  --cr-toolbar-background-color: white;
  --cr-button-edge-spacing: 12px;
  --cr-controlled-by-spacing: 24px;
  --cr-default-input-max-width: 264px;
  --cr-icon-ripple-size: 36px;
  --cr-icon-ripple-padding: 8px;
  --cr-icon-size: 20px;
  --cr-icon-button-margin-start: 16px;
  --cr-icon-ripple-margin: calc(var(--cr-icon-ripple-padding) * -1);
  --cr-section-min-height: 48px;
  --cr-section-two-line-min-height: 64px;
  --cr-section-padding: 20px;
  --cr-section-vertical-padding: 12px;
  --cr-section-indent-width: 40px;
  --cr-section-indent-padding: calc(
    var(--cr-section-padding) + var(--cr-section-indent-width)
  );
  --cr-section-vertical-margin: 21px;
  --cr-centered-card-max-width: 680px;
  --cr-centered-card-width-percentage: 0.96;
  --cr-hairline: 1px solid rgba(var(--cr-hairline-rgb), 0.14);
  --cr-separator-height: 1px;
  --cr-separator-line: var(--cr-separator-height) solid var(--cr-separator-color);
  --cr-toolbar-overlay-animation-duration: 150ms;
  --cr-toolbar-height: 56px;
  --cr-container-shadow-height: 6px;
  --cr-container-shadow-margin: calc(-1 * var(--cr-container-shadow-height));
  --cr-container-shadow-max-opacity: 1;
  --cr-card-border-radius: 8px;
  --cr-disabled-opacity: 0.38;
  --cr-form-field-bottom-spacing: 16px;
  --cr-form-field-label-font-size: 0.625rem;
  --cr-form-field-label-height: 1em;
  --cr-form-field-label-line-height: 1;
  --iron-icon-height: 20px;
  --iron-icon-width: 20px;
  --viewer-icon-ink-color: rgb(189, 189, 189);
  --viewer-pdf-toolbar-background-color: rgb(50, 54, 57);
  --viewer-text-input-selection-color: rgba(255, 255, 255, 0.3);
  --cr-fallback-color-outline: rgb(116, 119, 117);
  --cr-fallback-color-primary: rgb(11, 87, 208);
  --cr-fallback-color-on-primary: rgb(255, 255, 255);
  --cr-fallback-color-primary-container: rgb(211, 227, 253);
  --cr-fallback-color-on-primary-container: rgb(4, 30, 73);
  --cr-fallback-color-secondary-container: rgb(194, 231, 255);
  --cr-fallback-color-on-secondary-container: rgb(0, 29, 53);
  --cr-fallback-color-neutral-container: rgb(242, 242, 242);
  --cr-fallback-color-neutral-outline: rgb(199, 199, 199);
  --cr-fallback-color-surface: rgb(255, 255, 255);
  --cr-fallback-color-on-surface-rgb: 31, 31, 31;
  --cr-fallback-color-on-surface: rgb(var(--cr-fallback-color-on-surface-rgb));
  --cr-fallback-color-surface-variant: rgb(225, 227, 225);
  --cr-fallback-color-on-surface-variant: rgb(68, 71, 70);
  --cr-fallback-color-on-surface-subtle: rgb(71, 71, 71);
  --cr-fallback-color-inverse-primary: rgb(168, 199, 250);
  --cr-fallback-color-inverse-surface: rgb(48, 48, 48);
  --cr-fallback-color-inverse-on-surface: rgb(242, 242, 242);
  --cr-fallback-color-tonal-container: rgb(211, 227, 253);
  --cr-fallback-color-on-tonal-container: rgb(4, 30, 73);
  --cr-fallback-color-tonal-outline: rgb(168, 199, 250);
  --cr-fallback-color-error: rgb(179, 38, 30);
  --cr-fallback-color-divider: rgb(211, 227, 253);
  --cr-fallback-color-state-hover-on-prominent_: rgba(253, 252, 251, 0.1);
  --cr-fallback-color-state-on-subtle-rgb_: 31, 31, 31;
  --cr-fallback-color-state-hover-on-subtle_: rgba(
    var(--cr-fallback-color-state-on-subtle-rgb_),
    0.06
  );
  --cr-fallback-color-state-ripple-neutral-on-subtle_: rgba(
    var(--cr-fallback-color-state-on-subtle-rgb_),
    0.08
  );
  --cr-fallback-color-state-ripple-primary-rgb_: 124, 172, 248;
  --cr-fallback-color-state-ripple-primary_: rgba(
    var(--cr-fallback-color-state-ripple-primary-rgb_),
    0.32
  );
  --cr-fallback-color-base-container: rgba(105, 145, 214, 0.12);
  --cr-fallback-color-disabled-background: rgba(
    var(--cr-fallback-color-on-surface-rgb),
    0.12
  );
  --cr-fallback-color-disabled-foreground: rgba(
    var(--cr-fallback-color-on-surface-rgb),
    var(--cr-disabled-opacity)
  );
  --cr-hover-background-color: var(
    --color-sys-state-hover,
    rgba(var(--cr-fallback-color-on-surface-rgb), 0.08)
  );
  --cr-hover-on-prominent-background-color: var(
    --color-sys-state-hover-on-prominent,
    var(--cr-fallback-color-state-hover-on-prominent_)
  );
  --cr-hover-on-subtle-background-color: var(
    --color-sys-state-hover-on-subtle,
    var(--cr-fallback-color-state-hover-on-subtle_)
  );
  --cr-active-background-color: var(
    --color-sys-state-pressed,
    rgba(var(--cr-fallback-color-on-surface-rgb), 0.12)
  );
  --cr-active-on-primary-background-color: var(
    --color-sys-state-ripple-primary,
    var(--cr-fallback-color-state-ripple-primary_)
  );
  --cr-active-neutral-on-subtle-background-color: var(
    --color-sys-state-ripple-neutral-on-subtle,
    var(--cr-fallback-color-state-ripple-neutral-on-subtle_)
  );
  --cr-focus-outline-color: var(
    --color-sys-state-focus-ring,
    var(--cr-fallback-color-primary)
  );
  --cr-primary-text-color: var(
    --color-primary-foreground,
    var(--cr-fallback-color-on-surface)
  );
  --cr-secondary-text-color: var(
    --color-secondary-foreground,
    var(--cr-fallback-color-on-surface-variant)
  );
  --cr-link-color: var(--color-link-foreground-default, var(--cr-fallback-color-primary));
  --cr-button-height: 36px;
  --cr-shadow-color: var(--color-sys-shadow, rgb(0, 0, 0));
  font-family: "Segoe UI", Tahoma, sans-serif;
  font-size: 81.25%;
  line-height: 154%;
  --viewer-pdf-sidenav-width: 300px;
  --viewer-pdf-toolbar-height: 56px;
  --pdf-toolbar-text-color: rgb(241, 241, 241);
  --active-button-bg: rgba(255, 255, 255, 0.24);
  align-items: center;
  background-color: var(--viewer-pdf-toolbar-background-color);
  color: #fff;
  display: flex;
  height: var(--viewer-pdf-toolbar-height);
  padding: 0 16px;
}

.cursor-pointer {
  cursor: pointer;
}
</style>
