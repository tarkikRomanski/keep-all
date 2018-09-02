<template>
    <div>
        <ApolloQuery :query="require('../../resources/queries/folders.graphql')"
                     :variables="{ folder, onlyRoot: true }">
            <template slot-scope="{ result: { loading, error, data } }">
                <div v-if="loading">Loading...</div>

                <div v-else-if="error">An error occured</div>

                <div v-else-if="data">
                    <ul class="folderList">
                        <folder-list-item v-for="folder in data.folders"
                                          :key="folder.id"
                                          :folder="folder">
                        </folder-list-item>
                    </ul>
                </div>

                <div v-else>Loading...</div>
            </template>
        </ApolloQuery>
    </div>
</template>

<script>
    import FolderListItem from './FolderListItem';

    export default {
        components: {
            'folder-list-item': FolderListItem
        },

        props: {
            folder: {
                type: Number,
                default: null
            }
        },

        created() {
            console.log(this.folder);
        }
    }
</script>

<style scoped lang="scss">
    @import "~@styles/_variables.scss";

    .folderList {
        list-style: none;
        display: flex;
        flex-direction: column;
        margin-top: 20px;
    }
</style>