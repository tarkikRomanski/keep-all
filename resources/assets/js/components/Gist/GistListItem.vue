<template>
        <b-card border-variant="dark"
                :title="gist.description"
                class="mb-3"
        >
            <div slot="footer">
                <b-button-group>
                    <b-button variant="info"><i class="fa fa-pencil"></i> Edit</b-button>
                    <b-dropdown id="changeFolder"
                                text="Change a folder">
                        <b-dropdown-item v-for="folder in allFolders"
                                         :key="folder.id"
                                         @click="addToFolder(gist.gist, folder.id)">
                            {{ folder.name }}
                        </b-dropdown-item>
                    </b-dropdown>
                    <b-button @click="gistDelete(gist.gist)"
                              variant="danger">
                        <i class="fa fa-trash"></i> Delete
                    </b-button>
                </b-button-group>
            </div>

            <files-list :files="gist.files"></files-list>
        </b-card>
</template>

<script>
    import FilesList from './FilesList';
    import gql from 'graphql-tag';

    export default {
        props: {
            gist: {
                type: Object,
                required: true,
            }
        },

        components: {
            'files-list': FilesList,
        },

        computed: {
            allFolders: function () {
                return this.$store.getters.getFolders;
            }
        },

        methods: {
            addToFolder(gist, id) {
                this.$apollo.mutate({
                    mutation: gql`mutation ($gist: String!, $folder: ID!) {
                    updateGist(gist: $gist, folder: $folder) {
                        gist
                    }
                }`,

                    variables: {
                        gist: gist,
                        folder: id
                    }
                }).then(response => {
                    this.$router.push({name: 'gists.folder', params: {folder: id}});
                });
            },

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
        }
    }
</script>

<style scoped>
    .userLogo {
        border-radius: 50%;
        max-width: 40px;
    }
</style>