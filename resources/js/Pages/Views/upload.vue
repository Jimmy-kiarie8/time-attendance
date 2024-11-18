<template>
    <v-row justify="center">
        <v-dialog persistent v-model="dialog" width="800">
            <v-card title="Upload products" subtitle="csv/xlsx">
                <v-card-text>
                    <v-file-input clearable label="File input" variant="solo-filled" ref="fileUpload"></v-file-input>
                </v-card-text>
                <v-card-actions>

                    <v-btn prepend-icon="mdi-close" variant="tonal" @click="close" color="error">
                        Close
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn prepend-icon="mdi-upload" variant="tonal" :loading="loading" @click="handleFileUpload"
                        color="primary">
                        Upload
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="snackbar">
            {{ text }}
        </v-snackbar>
    </v-row>
</template>
<script>
export default {
    props: {
        modelRoute: String,
    },
    components: {
    },
    data() {
        return {
            dialog: false,
            file: null, // This will hold the uploaded file
            form: {},
            loading: false,
            snackbar: false,
            text: 'Suppliers Created',
        }
    },
    mounted() {
    },
    methods: {

        handleFileUpload() {
            this.file = this.$refs.fileUpload.files[0];
            if (!this.file) return;
            this.loading = true;

            const formData = new FormData();
            formData.append('file', this.file);


            axios.post(`${this.modelRoute}-upload`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.loading = false;
                    // Handle response
                    console.log('File uploaded successfully', response);
                })
                .catch(error => {
                    this.loading = false;
                    // Handle error
                    console.error('Error uploading file', error);
                });
        },
        close() {
            this.dialog = false
        },
        show() {
            this.dialog = true
        }
    },
}
</script>
