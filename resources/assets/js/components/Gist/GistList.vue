<template>
    <div>
        <b-card v-for="gist in gists" :key="gist.gist"
            border-variant="dark" 
            :title="gist.description"
            class="mb-3"
        >
            <div slot="footer">
                <!--<p><strong>Created: </strong>{{ gist.created_at }}</p>-->
                <!--<p>-->
                    <!--<strong>Author: </strong>-->
                    <!--<a target="_blank" :href="gist.owner.html_url">{{ gist.owner.login }}</a>-->
                    <!--<img :src="gist.owner.avatar_url" alt="logo" class="userLogo">-->
                <!--</p>-->

                <b-button-group>
                    <b-button variant="info"><i class="fa fa-pencil"></i> Edit</b-button>
                    <b-button @click="gistDelete(gist.gist)"
                        variant="danger">
                        <i class="fa fa-trash"></i> Delete
                        </b-button>
                </b-button-group>
            </div>

            <!--<b-list-group>-->
                <!--<b-list-group-item v-for="file in gist.files" -->
                    <!--:key="file.id" -->
                    <!--:href="file.raw_url" -->
                    <!--target="_blank"-->
                    <!--class="d-flex justify-content-between align-items-center">-->
                   <!--{{ file.filename }}-->
                   <!--<b-badge variant="info">{{ humanFileSize(file.size) }}</b-badge>-->
                <!--</b-list-group-item>-->
            <!--</b-list-group>-->
        </b-card>
    </div>
</template>

<script>
import GistResource from '../../resources/gistResource';
import gql from 'graphql-tag';

export default {
    apollo: {
        gists: gql`{
            gists {
                gist
                description
            }
        }`,
    },

    data() {
        return {
            gistResource: new GistResource(),
        }
    },

    // computed: {
    //     gists() {
    //             return this.$store.getters.getGists;
    //     }
    // },
    //
    // created() {
    //     this.$store.dispatch('loadGists');
    // },

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

<style scoped>
    .userLogo {
        border-radius: 50%;
        max-width: 40px;
    }
</style>
