import Vue from 'vue';
import Vuex from 'vuex';
import GistResource from './resources/gistResource';

Vue.use(Vuex);

const data = {
    gistResource: new GistResource(),
};

const store = new Vuex.Store({
    state: {
        gists: null,        
    },

    getters: {
        getGists: state => state.gists
    },

    actions: {
        loadGists(context) {
            data.gistResource.list(
                response => context.commit('loadGists', response.data)
            );
        }
    },

    mutations: {
        loadGists(state, payload) {
            state.gists = payload;
        }
    }
});

export default store;