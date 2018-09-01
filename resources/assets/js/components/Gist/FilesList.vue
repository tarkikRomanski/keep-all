<template>
    <b-list-group>
        <b-list-group-item v-for="file in files"
                           :key="file.id"
                           :href="file.rawUrl"
                           target="_blank"
                           class="d-flex justify-content-between align-items-center">
            {{ file.name }}
            <b-badge variant="info">{{ file.size }}</b-badge>
        </b-list-group-item>
    </b-list-group>
</template>

<script>
    export default {
        props: {
            files: {
                type: Array,
                required: true
            }
        }
    }
</script>