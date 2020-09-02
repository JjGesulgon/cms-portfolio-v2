<template>
  <form v-on:submit.prevent="create()">
    <div v-if="$parent.ifReady">
      <slot></slot>
    </div>
    <div v-else>
      <div class="progress">
        <div
          class="progress-bar progress-bar-striped progress-bar-animated"
          role="progressbar"
          aria-valuenow="100"
          aria-valuemin="0"
          aria-valuemax="100"
          style="width: 100%;"
        ></div>
      </div>
    </div>
    <br />
    <button v-if="$parent.ifReady" type="submit" class="btn btn-primary btn-sm">
      <i class="fas fa-plus"></i>
      &nbsp; Save {{ singularName }}
    </button>
    <slot name="other-buttons"></slot>
  </form>
</template>

<script>
export default {
  props: {
    apiPath: String,
    routePrefixName: String,
    singularName: String,
    fieldColumns: null,
    toastMessage: String,
    isDisabled: {
      type: Boolean,
      required: false,
      default: false,
    },
  },

  watch: {
    isDisabled: function (newValue, oldValue) {
      //
    },
  },

  methods: {
    create() {
      this.$parent.ifReady = false;

      axios
        .post(`${this.apiPath}`, this.fieldColumns)
        .then(() => {
          Broadcast.$emit("ToastMessage", {
            message: `${this.toastMessage} created successfully.`,
          });

          this.$router.push({ name: `${this.routePrefixName}.index` });
        })
        .catch((err) => {
          console.log(err);
          this.$parent.ifReady = true;
        });
    },
  },
};
</script>
