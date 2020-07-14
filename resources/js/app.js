import VueRouter from 'vue-router';
import HeaderComponent from './components/HeaderComponent.vue';
import PostListComponent from './components/PostListComponent.vue';
import PostShowComponent from './components/PostShowComponent.vue';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

 Vue.use(VueRouter);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('header-component', HeaderComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/laravel-news-spa/',
            name: 'post.list',
            component: PostListComponent
        },
        {
            path: '/laravel-news-spa/posts/:postId',
            name: 'post.show',
            component: PostShowComponent,
            props: true
        },
    ]
});

const app = new Vue({
    el: '#app',
    router
});
