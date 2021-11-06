/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import 'es6-promise/auto'
import axios from 'axios'
import "nly-adminlte-vue/dist/adminlte/css/adminlte.css";
import "nly-adminlte-vue/dist/adminlte/fontawesome-free/css/all.css";
import "nly-adminlte-vue/dist/adminlte/icon/iconfont.css";
import "nly-adminlte-vue/dist/nly-adminlte-vue.css";
import { NlyAdminlteVue, NlyAdminlteVueIcons } from "nly-adminlte-vue";
require('../../../bootstrap');
// import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
// import auth from './auth'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
window.Vue = require('vue');
window.Fire = new Vue();
import VueRouter from 'vue-router';
// import vueselect from 'vue-select2';
//Routes
import { routes } from '../Routes/routes';
//Import Sweetalert2
import Swal from 'sweetalert2'
//Import v-from
import { Form, HasError, AlertError } from 'vform';
//Import vue multi select
import Multiselect from 'vue-multiselect';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import myMixin from '../Mixin/myMixin'
// import FlagIcon from 'vue-flag-icon'
import store from "../store/store";
// NlyTemplate

Vue.use(NlyAdminlteVue);
Vue.use(NlyAdminlteVueIcons);
// import { NlyBadge } from "nly-adminlte-vue";
// Vue.component("nly-badge", NlyBadge);
// import { badgePlugin } from "nly-adminlte-vue";
// Vue.use(badgePlugin);
//use new
// import moment from 'moment'
import VModal from 'vue-js-modal'
import Toasted from 'vue-toasted';
import VuejsDialog from 'vuejs-dialog';
import VuejsDialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min.js'; // only needed in custom components

// include the default style
import 'vuejs-dialog/dist/vuejs-dialog.min.css';
Vue.use(VModal)
Vue.use(Toasted)
Vue.use(VuejsDialog)
Vue.use(VuejsDialogMixin)

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)



// Excell
import JsonExcel from "vue-json-excel";
Vue.component("downloadExcel", JsonExcel);


Vue.component('pagination', require('laravel-vue-pagination'));
//use new

Vue.use(VueRouter);
const originalPush = VueRouter.prototype.push

VueRouter.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
}

// Install BootstrapVue
Vue.use(BootstrapVue)
    //     // Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
    // Vue.use(FlagIcon);
    // register globally
Vue.component('multiselect', Multiselect)
    // Vue.use(vueselect);
    //Pagination laravel-vue-pagination
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('TableContent', require('../Default/TableContent').default);
Vue.component('FormButton', require('../Default/FormButton').default);

import 'advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css'
Vue.use(require('advanced-laravel-vue-paginate'));
// spinner register
Vue.component('spinner', require('vue-simple-spinner'));
Vue.use(Loading)
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}api`
axios.interceptors.response.use(function(response) {
    // console.log(response)
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    if (response.data.status == 419 || response.data.status == 401) {
        return router.push({ name: 'admin_login' });
    }
    return response;
}, function(error) {
    if (error.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        //  console.log(error.response.data);
        //  console.log(error.response.status);
        //  console.log(error.response.headers);
        // console.log(error.response);
        if (error.response.status == 422) {
            Swal.fire({
                icon: "warning",
                title: "Error Occured",
                text: "Please Please check the page"
            });
            window.scrollTo(0, 0);
            return Promise.reject(error);
        }
    } else if (error.request) {
        // The request was made but no response was received
        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
        // http.ClientRequest in node.js
        // console.log('error rq');
        // console.log(error.request);
    } else {
        // Something happened in setting up the request that triggered an Error
        // console.log('Error', error.message);
    }
    // console.log(error.config);
    if (response.data.status == 419 || response.data.status == 401) {
        return router.push({ name: 'admin_login' });
    }
    // return router.push({ name: 'admin_login' });
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    return Promise.reject(error);
});

Vue.config.baseurl = process.env.BASE_URL
    // Vue.use(VueAuth, auth)

window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError);
// define a mixin object for global function
var vm = new Vue({
    mixins: [myMixin]
})
Vue.mixin(myMixin)

// Permission check directive
Vue.directive('can', function(el, binding, vnode) {
    var given_permission = binding.value;
    var localStoragePermissions = localStorage.getItem("Permissions")

    var Permissions = localStoragePermissions ? JSON.parse(localStoragePermissions) : [];
    if (Permissions.length > 0) {
        if (typeof given_permission == 'string') {
            given_permission = [given_permission]
        }
        if (given_permission) {
            var true_array = [];
            var false_array = [];
            for (let i = 0; i < given_permission.length; i++) {
                if (Permissions.indexOf(given_permission[i]) !== -1) {
                    true_array.push(true);
                } else {
                    false_array.push(false);
                }

            }
            if (true_array.length) {
                return vnode.elm.hidden = false;
            } else {
                return vnode.elm.hidden = true;
            }
        }
    }
});
// Role check directive
Vue.directive("role", function(el, binding, vnode) {
    var given_role = binding.value;
    var localStorageRoles = localStorage.getItem("Roles")
    var Roles = localStorageRoles ? JSON.parse(localStorageRoles) : [];
    if (typeof given_role == "string") {
        given_role = [given_role];
    }
    if (given_role) {
        var true_array = [];
        var false_array = [];
        for (let i = 0; i < given_role.length; i++) {
            if (Roles.indexOf(given_role[i]) !== -1) {
                true_array.push(true);
            } else {
                false_array.push(false);
            }
        }
        if (true_array.length) {
            return (vnode.elm.hidden = false);
        } else {
            return (vnode.elm.hidden = true);
        }
    }
});
var router = new VueRouter({
    routes: routes,
    linkActiveClass: "active", // active class for non-exact links.
    linkExactActiveClass: "active", // active class for *exact* links.
    mode: 'history',
    base: '/payra_soft/admin' //payra_soft
});

router.beforeEach((to, from, next) => {
        var localStoragePermissions = localStorage.getItem("Permissions")
        var Permissions = localStoragePermissions ? JSON.parse(localStoragePermissions) : [];
        // console.log(Permissions)
        var localStorageToken = vm.getWithExpiry('token')
        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorageToken}`;
        var loggedIn = (localStorageToken == null ? false : true);

        if (loggedIn) {
            if (to.name === 'admin_login') {
                return next({ name: 'admin_home' })
            }
        } else {
            if (to.name === 'admin_home') {
                return next({ name: 'admin_login' })
            }
        }
        if (Permissions.length > 0 && vm.getWithExpiry('token') != null) {
            if (to.name !== 'admin_home') {
                if (Permissions.indexOf(to.name) === -1) {
                    next({ name: 'admin_home' });
                } else {
                    next();
                }
            }
        }
        next();
    })
    // const App = () =>
    //     import ( /* webpackChunkName: "App" */ '../Default/app.vue')
import App from '../Default/app.vue'
new Vue({
    router: router,
    store,
    render: h => h(App)
}).$mount("#app_backend");