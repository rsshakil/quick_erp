import Vue from "vue";
import Vuex from "vuex";
import VuexReset from '@ianwalter/vuex-reset'
import UserDetailsModule from "./modules/USER/UserDetailsModule"
import allParcelModule from "./modules/PARCEL/allParcelModule"
Vue.use(Vuex);
const store = new Vuex.Store({
    plugins: [VuexReset()],
    modules: {
        UserDetailsModule,
        allParcelModule,
    },
    mutations: {
        reset: () => {},
    }
})
export default store;