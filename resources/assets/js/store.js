import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        folders: null,
    },

    getters: {
        getFolders: state => state.folders,
    },

    actions: {
        loadFolders(context, data) {
            context.commit('loadFolders', data);
        }
    },

    mutations: {
        loadFolders(state, payload) {
            state.folders = payload;
        }
    }
});

export default store;