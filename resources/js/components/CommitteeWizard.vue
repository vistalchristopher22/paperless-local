<script>
import { ref } from "vue";
export default {
  components: {},
  setup() {
    const activeTab = ref("step1");

    const toggleTab = (tab) => {
      activeTab.value = tab;
    };

    return {
      activeTab,
      toggleTab,
    };
  },
};
</script>
<template>
  <div>
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a
              class="nav-link cursor-pointer"
              :class="{ active: activeTab === 'step1' }"
              @click="toggleTab('step1')"
              >Committee Information</a
            >
          </li>
          <li class="nav-item">
            <a
              class="nav-link cursor-pointer"
              :class="{ active: activeTab === 'step2' }"
              @click="toggleTab('step2')"
              >Schedule Information</a
            >
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content">
          <div
            id="step1"
            v-auto-animate
            class="tab-pane fade"
            :class="activeTab === 'step1' ? ['show', 'active'] : ''"
          >
            <slot name="step1"></slot>
          </div>
          <div
            id="step2"
            v-auto-animate
            class="tab-pane fade"
            :class="activeTab === 'step2' ? ['show', 'active'] : ''"
          >
            <slot name="step2"></slot>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- <CommitteeWizard>
    <template #step1>
      <div>
        <form @submit.prevent="" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name" class="form-label required">Name</label>
            <input id="name" readonly type="text" class="form-control" name="name" />
          </div>

          <div class="form-group mt-3">
            <label for="lead_committee" class="form-label required">Lead Committee</label>
            <div>
              <v-select
                class="border-gray text-uppercase"
                :options="agendas"
                label="title"
                :reduce="(agendas) => agendas.id"
              ></v-select>
            </div>
          </div>

          <div class="form-group mt-3">
            <label for="expanded_committee" class="form-label">Expanded Committee</label>
            <div
              class="{{ $errors->has('expanded_committee') ? 'border border-danger rounded' : '' }}"
            >
              <v-select
                class="border-gray text-uppercase"
                :options="agendas"
                label="title"
                :reduce="(agendas) => agendas.id"
              ></v-select>
            </div>
          </div>

          <div class="form-group mt-3">
            <label for="file" class="form-label required">File</label>
            <input type="file" name="file" id="file" class="form-control" />
          </div>

          <div>
            <button type="submit" class="btn btn-dark btn-md shadow-dark float-end mt-3">
              Submit
            </button>
          </div>
        </form>
      </div>
    </template>
    <template #step2>
      <div>hello world2</div>
    </template>
  </CommitteeWizard> -->
</template>
