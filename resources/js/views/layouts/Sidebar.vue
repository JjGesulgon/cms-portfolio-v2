<template>
  <div class="mr-3 mr-md-0">
    <div class="">
      <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'overview' }"><span class="overview"> Overview </span></router-link>
        </li>
      </ul>
    </div>
    <div class="">
      <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
        <li class="nav-item">
          <span class="nav-link">Content Management</span>
        </li>

        <li class="nav-item">
          <a
            class="nav-link list-item"
            href="#about"
            data-toggle="collapse"
            aria-expanded="false"
            aria-controls="about"
          >
            About
            <i class="float-right fas fa-caret-down"></i>
          </a>
        </li>
        <div class="collapse" id="about">
          <ul class="nav flex-column nav-sub-menu">
            <li class="nav-item">
              <router-link class="nav-link list-item" :to="{ name: 'about-me.index' }">About Me</router-link>
            </li>
            <li class="nav-item">
              <a
                class="nav-link list-item"
                href="#techStack"
                data-toggle="collapse"
                aria-expanded="false"
                aria-controls="techStack"
              >
                Technology Stack
                <i class="float-right fas fa-caret-down"></i>
              </a>
              <div class="collapse" id="techStack">
                <ul class="nav flex-column nav-sub-menu">
                  <li class="nav-item pl-3">
                    <router-link class="nav-link list-item" :to="{ name: 'tech-stack-content.index' }">Content</router-link>
                  </li>
                  <li class="nav-item pl-3">
                    <router-link class="nav-link list-item" :to="{ name: 'tech-stack-item.index' }">Stack List</router-link>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <router-link class="nav-link list-item" :to="{ name: 'passion.index' }">Passion</router-link>
            </li>
          </ul>
        </div>

        <li class="nav-item">
          <router-link class="nav-link list-item" :to="{ name: 'projects.index' }">Projects</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link list-item" :to="{ name: 'contact.index' }">Contact Details</router-link>
        </li>
      </ul>
    </div>
    <div class="">
      <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
        <li class="nav-item">
          <span class="nav-link">Creative Content</span>
        </li>

        <li class="nav-item">
          <router-link class="nav-link list-item" :to="{ name: 'users.index' }">Personal Blog</router-link>
        </li>
      </ul>
    </div>
    <div class="">
      <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
        <li class="nav-item">
          <span class="nav-link">User Management</span>
        </li>

        <li class="nav-item">
          <router-link class="nav-link list-item" :to="{ name: 'users.index' }">Users</router-link>
        </li>
      </ul>
    </div>
    <div class="">
      <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
        <li class="nav-item">
          <span class="nav-link">Monitoring</span>
        </li>
        <li class="nav-item">
          <router-link class="nav-link list-item" :to="{ name: 'users.index' }">Website Analytics</router-link>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {},
};
</script>
<style scoped>
  .overview{
    color: rgba(0, 0, 0, 0.7);
    font-weight: 800;
    font-family: Raleway;
    font-size: 12.96px;
  }

  .list-item{
    color: rgba(0, 0, 0, 0.7) !important;
    font-family: Raleway !important;
    font-size: 12.96px !important;
  }
</style>
