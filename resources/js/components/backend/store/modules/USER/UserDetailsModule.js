import myMixin from '../../../Mixin/myMixin'
const state = {
    users: [],
    roles: [],
    permissions: [],
    form: {

    },

};
const getters = {
    getFormData(state) {
        return state.form
    },
    getUserData(state) {
        return state.users
    },
};
const actions = {};
const mutations = {
    reset: () => {},
    loadUserData() {
        // var localStorageToken = this.getWithExpiry('token')
        // axios.defaults.headers.common['Authorization'] = `Bearer ${localStorageToken}`;
        // var loggedInToken = localStorage.getItem("token")
        // var item = JSON.parse(loggedInToken)
        // console.log(item)
        var localStorageToken = myMixin.methods.getWithExpiry("token")
        var loggedIn = (localStorageToken == null ? false : true);
        // console.log(item)
        // return 0;
        // if (loggedIn) {
        axios.get("users")
            .then(({ data }) => {
                // console.log(data)
                state.users = data.users;
                state.roles = data.roles;
                state.permissions = data.permissions;
            })
            .catch(() => {
                console.log("Error...");
            });
        // }
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}