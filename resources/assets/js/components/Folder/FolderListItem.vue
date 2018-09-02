<template>
        <li :class="'folderItem ' + (!haveElements ? 'folderItem-disabled' : '')"
            @click="haveElements > 0 ? openFolder(folder.id) : null"
            :style="'color:' + folder.color">
            <div class="folderItem__header">
                <p class="folderItem__name">
                    <i v-if="haveElements" class="fa fa-folder"></i>
                    <i v-else class="fa fa-folder-o"></i>
                    <span>{{ folder.name }}</span>
                </p>
                <div class="folderItem__badges">
                    <b-badge variant="primary">
                        <i class="fa fa-folder-o"></i> {{ folder.childrenQuantity }}
                    </b-badge>

                    <b-badge variant="dark">
                        <i class="fa fa-github"></i> {{ folder.gistsQuantity }}
                    </b-badge>
                </div>
            </div>
            <p class="folderItem__description"> {{ folder.description }} </p>
        </li>
</template>

<script>
    export default {
        props: {
            folder: {
                type: Object,
                required: true
            }
        },

        computed: {
            haveElements: function () {
                return this.folder.childrenQuantity > 0 || this.folder.gistsQuantity > 0;
            }
        },

        methods: {
            openFolder(id) {
                this.$router.push({name: 'gists.folder', params: {folder: id}});
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "~@styles/_variables.scss";

    .folderItem {
        transition: all 1s ease;
        padding: 10px;
        background: #fff;
        border-radius: 10px;
        margin-bottom: 15px;
        cursor: pointer;

        &-disabled {
            cursor: default;
            opacity: .5;
        }

        &:not(.folderItem-disabled):hover {
            box-shadow: 0px 0px 80px -14px rgba(0,0,0,0.75);
        }

        &__header {
            font-size: 1.5rem;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
        }

        &__name {
            font-weight: bold;
            margin-bottom: 3px;

            i.fa {
                margin-right: 15px;
            }
        }

        &__description {
            margin: {
                bottom: 5px;
                left: 10px;
            }
        }
    }
</style>