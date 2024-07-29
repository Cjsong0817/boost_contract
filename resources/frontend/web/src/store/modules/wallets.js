const state = {
  point1: 0,
  point2: 0,
  point3: 0,
  point4: 0,
  income: 0,
  total: 0,
  package: 0,
};

const getters = {
  getPoint1: state => state.point1,
  getPoint2: state => state.point2,
  getPoint3: state => state.point3,
  getPoint4: state => state.point4,
  getIncome: state => state.income,
  getTotal: state => state.total,
  getPackage: state => state.package
};

const actions = {
  updateP1({ commit }, data) {
    commit("storeP1", data);
  },
  updateP2({ commit }, data) {
    commit("storeP2", data);
  },
  updateP3({ commit }, data) {
    commit("storeP3", data);
  },
  updateP4({ commit }, data) {
    commit("storeP4", data);
  },
  updateIncome({ commit }, data) {
    commit("storeIncome", data);
  },
  updateTotal({ commit }, data) {
    commit("storeTotal", data);
  },
  updatePackage({ commit }, data) {
    commit("storePackage", data);
  },
};

const mutations = {
  storeP1(state, data) {
    state.point1 = data;
  },
  storeP2(state, data) {
    state.point2 = data;
  },
  storeP3(state, data) {
    state.point3 = data;
  },
  storeP4(state, data) {
    state.point4 = data;
  },
  storeIncome(state, data) {
    state.income = data;
  },
  storeTotal(state, data) {
    state.total = data;
  },
  storePackage(state, data) {
    state.package = data;
  },
};

export default {
  state,
  getters,
  actions,
  mutations
};
