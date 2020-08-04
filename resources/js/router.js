import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const Overview = () => import('./views/Overview');

/**
 * Users
 */
const UsersIndex  = () => import('./views/users/Index');
const UsersCreate = () => import('./views/users/Create');
const UsersView   = () => import('./views/users/View');
const UsersEdit   = () => import('./views/users/Edit');

/**
 * About Me
 */
const AboutMeIndex  = () => import('./views/about-me/Index');
const AboutMeCreate = () => import('./views/about-me/Create');
const AboutMeEdit   = () => import('./views/about-me/Edit');

/**
 * Tech Stack Content
 */
// const AboutMeIndex  = () => import('./views/about-me/Index');
const TechStackContentCreate = () => import('./views/tech-stack/content/Create');
// const AboutMeEdit   = () => import('./views/about-me/Edit');

export default new Router({
    mode: 'history',
    routes: [
        // Overiew
        { path: '/', name: 'overview', component: Overview },

        // Users
        { path: '/users', name: 'users.index', component: UsersIndex },
        { path: '/users/create', name: 'users.create', component: UsersCreate },
        { path: '/users/:id', name: 'users.view', component: UsersView },
        { path: '/users/:id/edit', name: 'users.edit', component: UsersEdit },

        // About Me
        { path: '/about-me', name: 'about-me.index', component: AboutMeIndex },
        { path: '/about-me/create', name: 'about-me.create', component: AboutMeCreate },
        { path: '/about-me/:id/edit', name: 'about-me.edit', component: AboutMeEdit },

        // Tech Stack Content
        // { path: '/about-me', name: 'about-me.index', component: AboutMeIndex },
        { path: '/tech-stack-content/create', name: 'tech-stack-content.create', component: TechStackContentCreate },
        // { path: '/about-me/:id/edit', name: 'about-me.edit', component: AboutMeEdit }
    ]
});
