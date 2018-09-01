<template>
    <div>
        <b-form @submit.prevent="sendData">
            <b-form-group label="Gist description:"
                label-for="newGistDescription"
                description="Short description for gist">
                <b-form-textarea id="newGistDescription"
                    v-model="data.description"
                    :rows="3"
                    :max-rows="7"
                    required
                    placeholder="Gist desription">
                </b-form-textarea>
            </b-form-group>

            <b-card v-for="(file, index) in data.files" 
                :key="`file-${index}`"
                class="mb-2">
                <div slot="header">
                    <b-form-group label="File name:"
                        description="File name with extansion">
                        <b-form-input type="text"
                            v-model="file.name"
                            required
                            placeholder="File name">
                        </b-form-input>
                    </b-form-group>
                </div>

                <div slot="footer">
                    <b-button variant="danger"
                        @click="removeFile(index)">
                        <i class="fa fa-trash"></i> Remove
                    </b-button>
                </div>

                <div>
                    <codemirror v-model="file.content" :options="cmOptions"></codemirror>
                </div>
            </b-card>

            <b-button @click="addFile"><i class="fa fa-plus"></i> Add file</b-button>

            <b-button variant="success" 
                type="submit"
                class="w-100 mt-3">
            Create Gist
            </b-button>
        </b-form>
    </div>
</template>

<script>
export default {
    data(){
        return {
            data: {
                description: null,
                public: true,
                files: [],
            },
            cmOptions: {
                mode: 'text/javascript'
            },
        }
    },

    methods: {
        sendData() {
            let gist = this.prepareData();
        },

        addFile() {
            this.data.files.push({name: null, content: null});
        },

        removeFile(index) {
            this.data.files.splice(index, 1);
        },

        prepareData() {
            let gist = {
                description: this.data.description,
                public: this.data.public,
                files: {}
            };

            this.data.files.forEach(file => gist.files[file.name] = {content: file.content});
            return JSON.stringify(gist);
        }
    }
}
</script>
