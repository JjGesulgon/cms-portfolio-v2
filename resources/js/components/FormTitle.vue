<template>
  <div class="row clearfix">
    <div class="col-md-6 text-left">
      <h3 class="font-weight-light">
        {{ title }}
        <slot name="title-small"></slot>
      </h3>
    </div>

    <div class="col-md-6 text-right">
      <slot name="right-items">
        <div v-if="$parent.showBack && $parent.ifReady">
          <router-link
            v-if="!altRoute"
            class="btn btn-outline-secondary btn-sm"
            :to="{ name: `${routePrefixName}.index` }"
          >
            <i class="fas fa-chevron-left"></i> &nbsp;Back
          </router-link>
          <router-link
            v-else
            class="btn btn-outline-secondary btn-sm"
            :to="{
              name: `${routePrefixName}.edit`,
              params: { id: $route.params.id },
            }"
          >
            <i class="fas fa-chevron-left"></i> &nbsp;Back
          </router-link>
          <button
            v-if="$parent.isSamplePageImage"
            type="button"
            class="btn btn-primary btn-sm"
            @click.prevent="$parent.openModal('#create-modal')"
          >
            <i class="fas fa-plus"></i>
            &nbsp; Create {{ toastMessage }}
          </button>
        </div>
        <div v-if="$parent.ifReady">
          <div v-if="$parent.showButtons">
            <router-link
              v-if="!$parent.hasContent"
              class="btn btn-primary btn-sm"
              :to="{ name: `${routePrefixName}.create` }"
            >
              <i class="fas fa-plus"></i>
              &nbsp; Create New {{ singularName }}
            </router-link>
            <div v-else-if="$parent.showDelete && $parent.hasContent">
              <button
                type="button"
                class="btn btn-danger btn-sm"
                @click.prevent="openModal('#delete-modal')"
              >
                <i class="fas fa-trash-alt"></i>
                &nbsp; Delete {{ singularName }}
              </button>

              <router-link
                class="btn btn-primary btn-sm"
                :to="{
                  name: `${routePrefixName}.edit`,
                  params: { id: moduleID },
                }"
              >
                <i class="fas fa-edit"></i>
                &nbsp; Edit {{ singularName }}
              </router-link>
            </div>

            <button
              type="button"
              class="btn btn-sm btn-dark mr-1"
              v-if="$parent.showSearch"
              @click.prevent="$parent.$refs.searchModal.openSearchModal()"
            >
              <i class="fas fa-search"></i>
              &nbsp; Search {{ pluralName }}
            </button>

            <button
              v-if="showClearSearch"
              type="button"
              class="btn btn-sm btn-light"
              @click.prevent="clearSearch()"
            >
              <i class="fas fa-eraser"></i>
              &nbsp; Clear Search
            </button>
          </div>
        </div>
      </slot>
      <slot name="other-buttons"></slot>

      <div
        class="modal fade"
        id="delete-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="delete-modal-title"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="delete-modal-title">
                <strong class="text-danger">WARNING:</strong> You're about to
                delete this.
              </h5>
            </div>
            <div class="modal-body">
              Are you sure you want to delete {{ singularName }}?
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
              >
                Cancel
              </button>
              <button
                type="button"
                class="btn btn-danger btn-sm"
                @click.prevent="deleteItem()"
              >
                Confirm Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    apiPath: String,
    moduleID: Number,
    toastMessage: String,
    routePrefixName: {
      type: String,
      required: false,
    },
    title: {
      type: String,
      required: true,
    },
    singularName: {
      type: String,
      required: false,
    },
    pluralName: {
      type: String,
      required: false,
    },
    showRightSide: {
      type: Boolean,
      required: false,
    },
    parameters: {
      type: Object,
      required: false,
    },
    altRoute: {
      type: String,
      required: false,
      default: null,
    },
  },

  data() {
    return {
      showClearSearch: false,
    };
  },

  watch: {
    parameters: function () {
      let checker = false;
      let queryParams = {};

      for (const [key, value] of Object.entries(this.$route.query)) {
        queryParams[key] = value;
      }

      if (queryParams["order_by"] == "asc") {
        console.log("order by is true");
        checker = true;
      }

      delete queryParams.order_by;
      delete queryParams.page;
      delete queryParams.per_page;

      let parameters = Object.entries(queryParams);

      for (const [key, value] of Object.entries(parameters)) {
        if (value[1] !== "") {
          checker = true;
        }
      }

      setTimeout(() => {
        this.showClearSearch = checker;
      }, 100);
    },
  },

  methods: {
    clearSearch() {
      this.$parent.$refs.searchModal.clearParameters();

      setTimeout(() => {
        this.$parent.$refs.searchModal.search();
      }, 100);
    },

    deleteItem() {
      $("#delete-modal").modal("hide");

      this.$parent.ifReady = false;

      axios
        .delete(`${this.apiPath}/${this.moduleID}`)
        .then(() => {
          Broadcast.$emit("ToastMessage", {
            message: `${this.toastMessage} deleted successfully.`,
          });

          this.$router.go();
        })
        .catch((err) => {
          console.log(err);
          this.$parent.ifReady = true;
        });
    },
  },
};
</script>
