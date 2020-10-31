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
        <data-table :pluralName="pluralName" v-if="ifReady">
          <template v-slot:thead>
            <tr>
              <th scope="col" class="ideal-font">Title</th>
              <th scope="col" class="ideal-font">Author</th>
              <th scope="col" class="ideal-font">Category</th>
              <th scope="col" class="ideal-font">Options</th>
            </tr>
          </template>
          <template v-slot:tbody v-bind:data="$data">
            <tr :id="item.id" v-for="item in data.data" :key="item.id">
              <td class="ideal-font">{{ item.title }}</td>
              <td class="ideal-font">{{ item.author }}</td>
              <td class="ideal-font">{{ item.category.name }}</td>
              <td>
                <data-table-row-action
                  :apiPath="apiPath"
                  :toastMessage="toastMessage"
                  :routePrefixName="routePrefixName"
                  :disableView="false"
                  :singularName="singularName"
                  :object="item"
                  :tbObject="item"
                ></data-table-row-action>
              </td>
            </tr>
          </template>
        </data-table>
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: null,
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
          this.data.data = res.data.data;
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
  },
};
</script>