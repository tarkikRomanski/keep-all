<template>
    <div>

        <ApolloQuery
                :query="require('../../resources/queries/gists.graphql')"
        >
            <template slot-scope="{ result: { loading, error, data } }">
                <div v-if="loading" class="loading apollo">Loading...</div>

                <div v-else-if="error">An error occured</div>

                <div v-else-if="data">
                    <gist-list-item :gists="data.gists"></gist-list-item>
                </div>

                <div v-else>Loading...</div>
            </template>
        </ApolloQuery>
    </div>
</template>

<script>
import gql from 'graphql-tag';
import GistListItem from './GistListItem';

export default {
    components: {
        'gist-list-item': GistListItem,
    },

    methods: {
        gistDelete(id) {
            this.$apollo.mutate({
                mutation: gql`mutation ($gist: ID!) {
                    deleteGist(gist: $gist) {
                        gist
                    }
                }`,

                variables: {
                    gist: id
                }
            })
                .then(
                    this.$swal(
                        'Gist has been deleted!',
                        `You are deleted the gist (${id})`,
                        'success'
                    )
                );
        },

        removeGistFromStore(id) {
            this.$store.dispatch('loadGists', id);
        }
    }
}
</script>