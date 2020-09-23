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
          :title="title"
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
              <th scope="col" class="ideal-font">Name</th>
              <th scope="col" class="ideal-font">Email</th>
              <th scope="col" class="ideal-font">Options</th>
            </tr>
          </template>
          <template v-slot:tbody v-bind:data="$data">
            <tr :id="item.id" v-for="item in data.data" :key="item.id">
              <td class="ideal-font">{{ item.name }}</td>
              <td class="ideal-font">{{ item.email }}</td>
              <td>
                <data-table-row-action
                  :apiPath="apiPath"
                  :toastMessage="toastMessage"
                  :routePrefixName="routePrefixName"
                  :disableView="true"
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
              style="width: 100%;"
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
          <div class="col-md-6 form-group">
            <label for="name">Name</label>
            <input
              id="name"
              type="text"
              class="form-control"
              v-model="$data.name"
              autocomplete="off"
            />
          </div>
          <div class="col-md-6 form-group">
            <label for="email">Email</label>
            <input
              id="email"
              type="text"
              class="form-control"
              v-model="$data.email"
              autocomplete="off"
              maxlength="255"
            />
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
      title: "User",
      pluralName: "Users",
      singularName: "User",
      apiPath: "/api/users",
      routeName: "users.index",
      routePrefixName: "users",
      toastMessage: "User",
      useName: "plural",
      name: null,
      email: null,
      order_by: "desc",
      error: null,
      showProgress: false,
      pageNumbers: [],

      showButtons: true,
      hasContent: false,
      ifReady: true,
      showSearch: true,
    };
  },

  beforeRouteEnter(to, from, next) {
    if (to.query.per_page == null) {
      next((vm) =>
        vm.getData({
          page: to.query.page,
          per_page: 15,
          name: to.query.name,
          email: to.query.email,
          order_by: to.query.order_by,
        })
      );
    } else {
      next((vm) =>
        vm.getData({
          page: to.query.page,
          per_page: to.query.per_page,
          name: to.query.name,
          email: to.query.email,
          order_by: to.query.order_by,
        })
      );
    }
  },

  beforeRouteUpdate(to, from, next) {
    this.getData({
      page: to.query.page,
      per_page: this.data.meta.per_page,
      name: this.name,
      email: this.email,
      order_by: this.order_by,
    });

    next();
  },

  methods: {
    getData(params) {
      this.showProgress = true;
      this.name = params.name;
      this.email = params.email;

      typeof params.order_by === "undefined" || params.order_by == "desc"
        ? (this.order_by = "desc")
        : (this.order_by = "asc");

      axios
        .get(this.apiPath, { params })
        .then((res) => {
          this.data = res.data;
          this.data.data = res.data.data;
          this.showProgress = false;
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
        name: this.name,
        email: this.email,
        order_by: this.order_by,
      };
    },
    clearParameters() {
      this.name = "";
      this.email = "";
      this.order_by = "desc";
    },
  },
};
</script>