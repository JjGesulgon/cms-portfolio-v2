<template>
    <div>
        <div class="sticky-top">
            <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'overview' }">Overview</router-link>
                </li>
            </ul>
        </div>

        <div class="sticky-top">
            <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
                <li class="nav-item">
                    <span class="nav-link">Content Management</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about" data-toggle="collapse" aria-expanded="false" aria-controls="about">
                        About <i class="float-right fas fa-caret-down"></i>
                    </a>
                </li>
                <div class="collapse" id="about">
                    <ul class="nav flex-column nav-sub-menu">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users.create' }">About Me</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users.index' }">Tech Stack</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users.index' }">Process / Workflow</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users.index' }">History</router-link>
                        </li>
                    </ul>
                </div>

                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'users.index' }">Projects</router-link>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'users.index' }">Contact Me</router-link>
                </li>
                
            </ul>
        </div>

        <div class="sticky-top">
            <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
                <li class="nav-item">
                    <span class="nav-link">User Management</span>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'users.index' }">Users</router-link>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link" href="#users" data-toggle="collapse" aria-expanded="false" aria-controls="users">
                        Users <i class="float-right fas fa-caret-down"></i>
                    </a>
                </li>
                <div class="collapse" id="users">
                    <ul class="nav flex-column nav-sub-menu">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users.create' }">Create New User</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users.index' }">View Users</router-link>
                        </li>
                    </ul>
                </div> -->
            </ul>
        </div>

        <div class="sticky-top">
            <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
                <li class="nav-item">
                    <span class="nav-link">Project Analytics</span>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'users.index' }">Projects</router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        }
    }
</script>
