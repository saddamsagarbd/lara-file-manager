/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Form from 'vform';

window.Form = Form;
// Vue.component(HasError.name, HasError);
// Vue.component(AlertError.name, AlertError);

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'

let options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'left',
    inverse: false
  }
  
Vue.use(VueProgressBar, options)

import Swal from 'sweetalert2'
window.Swal = Swal;

let Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast = Toast;

window.Fire = new Vue();

let routes = [
    { path: '/dashboard', component: require('./components/DashboardComponent.vue').default },
    { path: '/user-manage', component: require('./components/UserManageComponent.vue').default },
    { path: '/file-manage', component: require('./components/FileManageComponent.vue').default },
    { path: '/file-manager', component: require('./components/FileManagerComponent.vue').default },
    { path: '/file-upload', component: require('./components/FileUploadComponent.vue').default },
    { path: '/folder', name:'folder', component: require('./components/DirectoryComponent.vue').default, props: true },
]

const router = new VueRouter({
    mode: 'history',
    routes
})
  

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
