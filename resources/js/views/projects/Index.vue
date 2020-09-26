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
              <th scope="col" class="ideal-font">Type</th>
              <th scope="col" class="ideal-font">Date Deployed</th>
              <th scope="col" class="ideal-font">Options</th>
            </tr>
          </template>
          <template v-slot:tbody v-bind:data="$data">
            <tr :id="item.id" v-for="item in data.data" :key="item.id">
              <td class="ideal-font">{{ item.name }}</td>
              <td class="ideal-font">{{ item.type }}</td>
              <td class="ideal-font">{{ item.date_deployed }}</td>
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
          <div class="col-md-12 form-group">
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
            <label for="experience">Type</label>
            <input
              id="experience"
              type="text"
              class="form-control"
              v-model="$data.experience"
              autocomplete="off"
              maxlength="255"
            />
          </div>
          <div class="col-md-6 form-group">
            <label for="proficiency">Date Deployed</label>
            <input
              id="proficiency"
              type="text"
              class="form-control"
              v-model="$data.date_deployed"
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
      title: "Projects",
      pluralName: "Projects",
      singularName: "Project",
      apiPath: "/api/projects",
      routeName: "projects.index",
      routePrefixName: "projects",
      toastMessage: "Project",
      useName: "plural",
      name: null,
      type: null,
      date_deployed: null,
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
          type: to.query.experience,
          date_deployed: to.query.date_deployed,
          order_by: to.query.order_by,
        })
      );
    } else {
      next((vm) =>
        vm.getData({
          page: to.query.page,
          per_page: to.query.per_page,
          name: to.query.name,
          type: to.query.type,
          date_deployed: to.query.date_deployed,
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
      type: this.type,
      date_deployed: this.date_deployed,
      order_by: this.order_by,
    });

    next();
  },

  methods: {
    getData(params) {
      this.showProgress = true;
      this.name = params.name;
      this.type = params.type;
      this.date_deployed = params.date_deployed;

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
        type: this.type,
        date_deployed: this.date_deployed,
        order_by: this.order_by,
      };
    },
    clearParameters() {
      this.name = "";
      this.type = "";
      this.date_deployed = "";
      this.order_by = "desc";
    },
  },
};
</script>