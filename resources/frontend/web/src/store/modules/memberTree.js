const state = {
    sponsorTree: [],
    isChild: false,
    isPChild: false,
    selectedPlacement: null
};

const getters = {
    getSponsorTree: state => state.sponsorTree,
    getChild: state => state.isChild,
    getPChild: state => state.isPChild,
    getSelectedP: state => state.selectedPlacement,
};

const actions = {
    changeSponsorTree({ commit }, data) {
        commit("updateSponsorTree", data);
    },
    changeS({ commit }, data) {
        commit("updateChild", data);
    },
    changePlaceS({ commit }, data) {
        commit("updatePChild", data);
    },
    changeSelectedP({ commit }, data) {
        commit("updateSelectedP", data);
    },
};

const mutations = {
    updateSponsorTree(state, data) {
        state.sponsorTree = data;
    },
    updateChild(state, data) {
        state.isChild = data;
    },
    updatePChild(state, data) {
        state.isPChild = data;
    },
    updateSelectedP(state, data) {
        state.selectedPlacement = data;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
