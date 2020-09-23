<template>
  <div>
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
          <div class="modal-body">Are you sure you want to delete this {{ singularName }}?</div>
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

    <div
      class="modal fade"
      id="not-delete-modal-table"
      tabindex="-1"
      role="dialog"
      aria-labelledby="delete-modal-title"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="delete-modal-title">
              <strong class="text-danger">Forbidden:</strong> Unable to delete selected {{singularName}}.
            </h5>
          </div>
          <div class="modal-body">The only existing {{ singularName }} cannot be deleted.</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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