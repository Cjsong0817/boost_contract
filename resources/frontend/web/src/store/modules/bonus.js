const state = {
    static_bonus: [],
    dynamic_bonus: [],
    sponsor_bonus: [],
    matching_bonus: [],
};

const getters = {
    getS: state => state.static_bonus,
    getD: state => state.dynamic_bonus,
    getSo: state => state.sponsor_bonus,
    getM: state => state.matching_bonus,
};

const actions = {
    updateSB({ commit }, data) { commit("storeSB", data); },
    updateDB({ commit }, data) { commit("storeDB", data); },
    updateSoB({ commit }, data) { commit("storeSoB", data); },
    updateMB({ commit }, data) { commit("storeMB", data); },
};

const mutations = {
    storeSB(state, data) { state.static_bonus = data; },
    storeDB(state, data) { state.dynamic_bonus = data; },
    storeSoB(state, data) { state.sponsor_bonus = data; },
    storeMB(state, data) { state.matching_bonus = data; },
};

export default {
    state,
    getters,
    actions,
    mutations
};
