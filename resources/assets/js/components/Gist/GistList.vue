<template>
    <div>
        <ApolloQuery :query="require('../../resources/queries/gists.graphql')"
                     :variables="{ folder }">
            <template slot-scope="{ result: { loading, error, data } }">
                <div v-if="loading" class="loading apollo">Loading...</div>

                <div v-else-if="error">An error occured</div>

                <div v-else-if="data">
                    <gist-list-item v-for="gist in data.gists"
                                    :key="gist.gist"
                                    :gist="gist">
                    </gist-list-item>
                </div>

                <div v-else>Loading...</div>
            </template>
        </ApolloQuery>
    </div>
</template>

<script>
import GistListItem from './GistListItem';

export default {
    components: {
        'gist-list-item': GistListItem,
    },

    props: {
        folder: {
            type: Number,
            default: null
        }
    },

    methods: {
        removeGistFromStore(id) {
            this.$store.dispatch('loadGists', id);
        }
    },
}
</script>