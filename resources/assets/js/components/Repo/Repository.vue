<template>
    <div>
        <folder-list :folder="folder"></folder-list>
        <gists-list :folder="folder"></gists-list>
    </div>
</template>

<script>
    import FolderList from '../Folder/FolderList';
    import GistsList from '../Gist/GistList';

    export default {
        components: {
            'folder-list': FolderList,
            'gists-list': GistsList,
        },

        props: {
            folder: {
                type: Number,
                default: null
            }
        }
    }
</script>