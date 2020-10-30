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
const TechStackContentIndex  = () => import('./views/tech-stack/content/Index');
const TechStackContentCreate = () => import('./views/tech-stack/content/Create');
const TechStackContentEdit   = () => import('./views/tech-stack/content/Edit');

/**
 * Tech Stack Item
 */
const TechStackItemIndex  = () => import('./views/tech-stack/item/Index');
const TechStackItemCreate = () => import('./views/tech-stack/item/Create');
const TechStackItemEdit   = () => import('./views/tech-stack/item/Edit');

/**
 * Passion
 */
const PassionIndex  = () => import('./views/passion/Index');
const PassionEdit   = () => import('./views/passion/Edit');

/**
 * Contact
 */
const ContactIndex  = () => import('./views/contact/Index');
const ContactCreate = () => import('./views/contact/Create');
const ContactEdit   = () => import('./views/contact/Edit');

/**
 * Projects
 */
const ProjectsIndex  = () => import('./views/projects/Index');
const ProjectsCreate = () => import('./views/projects/Create');
const ProjectsView   = () => import('./views/projects/View');
const ProjectsEdit   = () => import('./views/projects/Edit');

/**
 * Sample Page Images
 */
const SamplePageImages   = () => import('./views/projects/sample-page-images/Index');

/**
 * Blogs
 */
const BlogsIndex  = () => import('./views/blogs/Index');
const BlogsCreate = () => import('./views/blogs/Create');
// const ProjectsView   = () => import('./views/projects/View');
// const ProjectsEdit   = () => import('./views/projects/Edit');

/**
 * Category
 */
const CategoryIndex  = () => import('./views/categories/Index');
const CategoryCreate = () => import('./views/categories/Create');
const CategoryEdit   = () => import('./views/categories/Edit');

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
        { path: '/tech-stack-content', name: 'tech-stack-content.index', component: TechStackContentIndex },
        { path: '/tech-stack-content/create', name: 'tech-stack-content.create', component: TechStackContentCreate },
        { path: '/tech-stack-content/:id/edit', name: 'tech-stack-content.edit', component: TechStackContentEdit },

        // Tech Stack Items
        { path: '/tech-stack-item', name: 'tech-stack-item.index', component: TechStackItemIndex },
        { path: '/tech-stack-item/create', name: 'tech-stack-item.create', component: TechStackItemCreate },
        { path: '/tech-stack-item/:id/edit', name: 'tech-stack-item.edit', component: TechStackItemEdit },

        // Passions
        { path: '/passion', name: 'passion.index', component: PassionIndex },
        { path: '/passion/:id/edit', name: 'passion.edit', component: PassionEdit },

        // Contact
        { path: '/contact', name: 'contact.index', component: ContactIndex },
        { path: '/contact/create', name: 'contact.create', component: ContactCreate },
        { path: '/contact/:id/edit', name: 'contact.edit', component: ContactEdit },

        // Projects
        { path: '/projects', name: 'projects.index', component: ProjectsIndex },
        { path: '/projects/create', name: 'projects.create', component: ProjectsCreate },
        { path: '/projects/:id', name: 'projects.view', component: ProjectsView },
        { path: '/projects/:id/edit', name: 'projects.edit', component: ProjectsEdit },

        // Sample Page Image
        { path: '/sample-page-image/project/:id', name: 'sample-page-image.edit', component: SamplePageImages },

        // Blogs
        { path: '/blogs', name: 'blogs.index', component: BlogsIndex },
        { path: '/blogs/create', name: 'blogs.create', component: BlogsCreate },
        // { path: '/projects/:id', name: 'projects.view', component: ProjectsView },
        // { path: '/projects/:id/edit', name: 'projects.edit', component: ProjectsEdit },

        // Categories
        { path: '/categories', name: 'category.index', component: CategoryIndex },
        { path: '/categories/create', name: 'category.create', component: CategoryCreate },
        { path: '/categories/:id/edit', name: 'category.edit', component: CategoryEdit },
    ]
});
