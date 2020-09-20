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

    <delete-modal
      :routePrefixName="routePrefixName"
      :apiPath="apiPath"
      :singularName="singularName"
      :object="object"
      :tbObject="tbObject"
      :toastMessage="toastMessage"
      :isTabled ="true"
    ></delete-modal>
  </div>
</template>

<script>
export default {
  props: {
    routePrefixName: String,
    apiPath: String,
    singularName: String,
    object: Object,
    tbObject: Object,
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

  data() {
    return {
      ifReady: true
    };
  },

  watch: {
    ifReady: function (){
      if (!this.ifReady){
        this.$parent.ifReady = false
      }
      else {
        this.$parent.ifReady = true
      }
    }
  },

  methods: {
    openDeleteModalTable() {
      $("#delete-modal-table").modal("show");
    },
  },
};
</script>
