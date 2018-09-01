<template>
    <div>
        <b-card v-for="gist in gists" :key="gist.gist"
                border-variant="dark"
                :title="gist.description"
                class="mb-3"
        >
            <div slot="footer">
                <p><strong>Created: </strong>{{ gist.createdAt }}</p>
                <p>
                <strong>Author: </strong>
                <a target="_blank" :href="gist.owner.url">{{ gist.owner.login }}</a>
                <img :src="gist.owner.avatar" alt="logo" class="userLogo">
                </p>

                <b-button-group>
                    <b-button variant="info"><i class="fa fa-pencil"></i> Edit</b-button>
                    <b-button @click="gistDelete(gist.gist)"
                              variant="danger">
                        <i class="fa fa-trash"></i> Delete
                    </b-button>
                </b-button-group>
            </div>

            <files-list :files="gist.files"></files-list>
        </b-card>
    </div>
</template>

<script>
    import FilesList from './FilesList';

    export default {
        props: {
            gists: {
                type: Array,
                required: true,
                default: []
            }
        },

        components: {
            'files-list': FilesList,
        }
    }
</script>

<style scoped>
    .userLogo {
        border-radius: 50%;
        max-width: 40px;
    }
</style>