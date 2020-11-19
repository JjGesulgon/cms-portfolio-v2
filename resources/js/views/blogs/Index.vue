<template>
  <div>
    <breadcrumbs
      :routePrefixName="routePrefixName"
      :action="action"
      :singularName="singularName"
      :pluralName="pluralName"
      :useName="useName"
    ></breadcrumbs>

    <div class="card">
      <div class="card-body">
        <form-title
          :routePrefixName="routePrefixName"
          :title="formTitle"
          :apiPath="apiPath"
          :singularName="singularName"
          :pluralName="pluralName"
          v-bind:showRightSide="true"
          :parameters="getParameters()"
        ></form-title>
        <hr />
        <div class="card-columns" v-if="ifReady">
          <div class="card" v-for="blog in blogs" :key="blog.id">
            <div class="card-header clearfix">
              <router-link class="btn btn-outline-primary btn-sm float-right ideal-font" :to="{ name: 'blogs.edit', params: { id: blog.id }}">
                <i class="fas fa-edit"></i>&nbsp; Edit
              </router-link>

              <router-link class="btn btn-outline-dark btn-sm float-right ideal-font mr-1" :to="{ name: 'blogs.view', params: { id: blog.id }}">
                <i class="fas fa-eye"></i>&nbsp; View
              </router-link>

              <label
                class="btn btn-outline-danger btn-sm mr-1 ideal-font float-right"
                @click.prevent="openDeleteModalTable(blog)"
              >
                <i class="fas fa-trash-alt"></i>&nbsp;
                <span class="ideal-font">Delete</span>
              </label>
            </div>
            <div v-if="blog.header_image" class="text-center">
              <img class="img-fluid mw-50 h-auto" :src="'storage/images/' + blog.header_image" alt />
            </div>
            <div class="card-body"> 
              <h5 class="card-title">{{ blog.title }}</h5>
              <h6 class="card-title">#{{ blog.category.name}}</h6>
              <h6 class="card-title">{{ blog.author }}</h6>
            </div>
          </div>
        </div>
        <div v-else>
          <div class="progress">
            <div
              class="progress-bar progress-bar-striped progress-bar-animated"
              role="progressbar"
              aria-valuenow="100"
              aria-valuemin="0"
              aria-valuemax="100"
              style="width: 100%"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <br />

    <pagination
      v-if="data"
      :routeName="routeName"
      :meta="data.meta"
      :links="data.links"
      :parameters="getParameters()"
    ></pagination>

    <search-modal
      v-if="data"
      :routeName="routeName"
      idAttribute="search-modal"
      ref="searchModal"
      :title="singularName"
      :parameters="getParameters()"
      @ClearParameters="clearParameters()"
    >
      <template v-bind:data="$data">
        <div class="row">
          <div class="col-md-12 form-group">
            <label for="title">Title</label>
            <input
              id="title"
              type="text"
              class="form-control"
              v-model="$data.title"
              autocomplete="off"
            />
          </div>
          <div class="col-md-6 form-group">
            <label for="author">Author</label>
            <input
              id="type"
              type="text"
              class="form-control"
              v-model="$data.author"
              autocomplete="off"
              maxlength="255"
            />
          </div>
          <div class="col-md-6 form-group">
            <label for="category">Category</label>
            <vue-select
              class="form-control"
              v-model="$data.category"
              label="name"
              :options="categories"
            ></vue-select>
          </div>
        </div>
      </template>
    </search-modal>

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
              <strong class="text-danger">WARNING:</strong> You're about to
              delete this.
            </h5>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this image?
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
</template>

<script>
export default {
  data() {
    return {
      data: null,
      blogs: null,
      blog: null,
      action: "View",
      formTitle: "Blogs",
      pluralName: "Blogs",
      singularName: "Blog",
      apiPath: "/api/blogs",
      routeName: "blogs.index",
      routePrefixName: "blogs",
      toastMessage: "Blog",
      useName: "plural",
      title: "",
      author: "",
      category_id: "",
      category:"",
      order_by: "desc",
      error: null,
      showProgress: false,
      pageNumbers: [],

      categories:[],

      selectedItem: null,
      showButtons: true,
      hasContent: false,
      ifReady: false,
      showSearch: true,
      tinyMCEReady: false,
    };
  },

  mounted() {
    let promise = new Promise((resolve, reject) => {
      axios
        .get(`/api/categories/getAll`)
        .then((res) => {
          this.categories = res.data.category;
          this.ifReady = true;
          resolve();
        })
        .catch((err) => {
          reject();
        });
    });

    promise.then(() => {
      this.ifReady = true;
    });
  },

  beforeRouteEnter(to, from, next) {
    if (to.query.per_page == null) {
      next((vm) =>
        vm.getData({
          page: to.query.page,
          per_page: 15,
          title: to.query.title,
          author: to.query.author,
          category_id: to.query.category_id,
          order_by: to.query.order_by,
        })
      );
    } else {
      next((vm) =>
        vm.getData({
          page: to.query.page,
          per_page: to.query.per_page,
          title: to.query.title,
          author: to.query.author,
          category_id: to.query.category_id,
          order_by: to.query.order_by,
        })
      );
    }
  },

  beforeRouteUpdate(to, from, next) {
    this.getData({
      page: to.query.page,
      per_page: this.data.meta.per_page,
      title: this.title,
      author: this.author,
      category_id: this.category == undefined ? this.category : this.category.id,
      order_by: this.order_by,
    });

    next();
  },

  methods: {
    getData(params) {
      this.showProgress = true;
      this.title = params.title;
      this.author = params.author;
      this.category_id = params.category_id;

      typeof params.order_by === "undefined" || params.order_by == "desc"
        ? (this.order_by = "desc")
        : (this.order_by = "asc");

      axios
        .get(this.apiPath, { params })
        .then((res) => {
          this.data = res.data;
          this.blogs = res.data.data;
          this.showProgress = false;
          this.ifReady = true;
        })
        .catch((error) => {
          if (error.response.status == 401) {
            location.reload();
          }

          if (error.response.status == 500) {
            alert("Kindly report this issue to the devs.");
          }
        });
    },
    getParameters() {
      return {
        title: this.title,
        author: this.author,
        category: this.category,
        order_by: this.order_by,
      };
    },
    clearParameters() {
      this.title = "";
      this.author = "";
      this.category_id = "";
      this.category = "";
      this.order_by = "desc";
    },
    openDeleteModalTable(item) {
      this.blog = item;
      console.log(this.blog);
      $("#delete-modal-table").modal("show");
    },
    deleteItem() {
      $("#delete-modal-table").modal("hide");
      this.ifReady = false;

      axios
        .delete(`${this.apiPath}/${this.blog.id}`)
        .then(() => {
          Broadcast.$emit("ToastMessage", {
            message: `${this.toastMessage} deleted successfully.`,
          });

          this.ifReady = true;

          const index = this.blogs.indexOf(this.blog);
          this.blogs.splice(index, 1);
        })
        .catch((err) => {
          console.log(err);
          this.$parent.ifReady = true;
        });
    },

    initFunction() {
      this.tinyMCEReady = true;
    },
  },
};
</script>