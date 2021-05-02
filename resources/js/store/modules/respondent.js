const state = {
  selected: {
    id_class: null,
    id_course: null,
    id_test: null,
  },
};

const mutations = {
  SET_ID_CLASS: (state, id_class) => {
    state.selected.id_class = id_class;
  },
  SET_ID_COURSE: (state, id_course) => {
    state.selected.id_course = id_course;
  },
  SET_ID_TEST: (state, id_test) => {
    state.selected.id_test = id_test;
  },
  SET_SELECTED: (state, selected) => {
    state.selected = selected;
  },
};

const actions = {
  setIdClass({ commit }, id_class) {
    commit('SET_ID_CLASS', id_class);
  },
  setIdCourse({ commit }, id_course) {
    commit('SET_ID_COURSE', id_course);
  },
  setIdTest({ commit }, id_test) {
    commit('SET_ID_TEST', id_test);
  },
  setSelected({ commit }, selected) {
    commit('SET_SELECTED', selected);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};

