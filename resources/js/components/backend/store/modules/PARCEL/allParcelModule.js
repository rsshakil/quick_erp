const state = {
    form: {
        search: null,
        per_page: 15,
        page: 1,
        merchant: [],
        status: 'All',
    },
};
const getters = {
    getFormData(state) {
        return state.form
    },
};
const actions = {};
const mutations = {
    reset: () => {},
    updateFormValue(state, { target, value }) {
        state.form[target] = value;
    },
    // formValuesStore(state, payload) {
    //     state.form = payload;
    // },
    // formValuesStoreBYRID(state, byr_buyer_id) {
    //     state.form.byr_buyer_id = byr_buyer_id;
    // },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}