<template>
  <div>
    <label class="text-danger clickableText ideal-font" @click.prevent="openDeleteModalTable()">
      <i class="fas fa-trash-alt"></i>&nbsp;
      <strong>Delete</strong>
    </label>
    <span v-if="!disableView && ! disableEdit">&nbsp; | &nbsp;</span>
    <router-link
      v-if="!disableView"
      class="text-secondary ideal-font"
      :to="{ name: `${routePrefixName}.view`, params: { id: object.id }}"
    >
      <i class="fas fa-eye"></i>
      &nbsp;
      <strong>View</strong>
    </router-link>
    <span v-if="disableView && ! disableEdit">&nbsp; | &nbsp;</span>
    <router-link
      v-if="! disableEdit"
      class="text-secondary ideal-font"
      :to="{ name: `${routePrefixName}.edit`, params: { id: object.id }}"
    >
      <i class="fas fa-edit"></i>
      &nbsp;
      <strong>Edit</strong>
    </router-link>
    <slot></slot>
    <div
      class="modal fade"
      id="delete-modal-table"
      tabindex="-1"
      role="dialog"
      aria-labelledby="delete-modal-title"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="delete-modal-title">
              <strong class="text-danger">WARNING:</strong> You're about to delete this.
            </h5>
          </div>
          <div class="modal-body">Are you sure you want to delete {{ singularName }}?</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              @click.prevent="deleteItem()"
            >Confirm Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    routePrefixName: String,
    apiPath: String,
    singularName: String,
    object: Object,
    toastMessage: String,
    disableView: {
      type: Boolean,
      required: false,
      default: false,
    },
    disableEdit: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

  methods: {
    openDeleteModalTable() {
      $("#delete-modal-table").modal("show");
    },

    deleteItem() {
      $("#delete-modal-table").modal("hide");

      this.$parent.ifReady = false;

      axios
        .delete(`${this.apiPath}/${this.object.id}`)
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
