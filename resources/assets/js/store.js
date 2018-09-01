import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const data = {
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
            // data.gistResource.list(
            //     response => context.commit('loadGists', response.data)
            // );
        },

        removeGist(context, id) {
            context.commit('removeGist', id)
        }
    },

    mutations: {
        loadGists(state, payload) {
            state.gists = payload;
        },

        removeGist(state, id) {
            state.gists.forEach(gist => {
                if (gist.id === id) {
                    let index = state.gists.indexOf(gist);
                    state.gists.splice(index, 1);
                }
            });
        }
    }
});

export default store;