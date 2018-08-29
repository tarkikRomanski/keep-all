<template>
    <div>
        <b-card v-for="gist in gists" :key="gist.id"
            border-variant="dark" 
            :title="gist.description"
            class="mb-3"
        >
            <div slot="footer">
                <p><strong>Created: </strong>{{ gist.created_at }}</p>
                <p>
                    <strong>Author: </strong>
                    <a target="_blank" :href="gist.owner.html_url">{{ gist.owner.login }}</a>
                    <img :src="gist.owner.avatar_url" alt="logo" class="userLogo">
                </p>
            </div>

            <b-list-group>
                <b-list-group-item v-for="file in gist.files" 
                    :key="file.id" 
                    :href="file.raw_url" 
                    target="_blank"
                    class="d-flex justify-content-between align-items-center">
                   {{ file.filename }}
                   <b-badge variant="info">{{ humanFileSize(file.size) }}</b-badge>
                </b-list-group-item>
            </b-list-group>
        </b-card>
    </div>
</template>

<script>
import GistResource from '../../resources/gistResource';

export default {
    data() {
        return {
            gistResource: new GistResource(),
            gists: null
        }
    },

    mounted() {
        console.log('mounted');
        this.gistResource.list(response => this.gists = response.data);
    },
}
</script>

<style scoped>
    .userLogo {
        border-radius: 50%;
        max-width: 40px;
    }
</style>
