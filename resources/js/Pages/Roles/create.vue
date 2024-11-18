<template>
    <v-row justify="center">
        <v-dialog persistent v-model="dialog" width="800">
            <!-- Header -->
            <v-card>
                <v-card-title class="text-h5">
                    Edit {{ title }}
                </v-card-title>
                <v-card-text>
                    <!-- Name Field -->
                    <v-row>
                        <v-col cols="12" md="12">
                            <v-text-field clearable label="Name" variant="outlined" v-model="form.name"
                                type="text"></v-text-field>
                        </v-col>
                    </v-row>

                    <!-- Permissions Section -->
                    <v-divider></v-divider>
                    <!-- Select All Checkbox -->
                    <v-row>
                        <v-col cols="12">
                            <v-checkbox v-model="selectAll" color="primary" label="Select All"
                                @change="toggleSelectAll"></v-checkbox>
                        </v-col>
                    </v-row>
                    <v-row v-for="(group, prefix) in permissions" :key="prefix">
                        <v-col cols="12">
                            <h2>{{ prefix }}</h2>
                        </v-col>
                        <v-col cols="3" md="3" v-for="permission in group">
                            <!-- Individual Permission Checkbox -->
                            <v-checkbox v-model="permission.has_permission" color="secondary"
                                :label="permission.name"></v-checkbox>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-btn variant="outlined" color="error" @click="close">Close</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn variant="outlined" color="primary" @click="submit">Submit</v-btn>
                </v-card-actions>
            </v-card>

            <!-- Snackbar -->
            <v-snackbar v-model="snackbar">
                {{ text }}
                <template v-slot:actions>
                    <v-btn color="pink" variant="text" @click="snackbar = false">Close</v-btn>
                </template>
            </v-snackbar>
        </v-dialog>
    </v-row>
</template>

<script>
import myForm from '@/Components/FormComponent.vue';
export default {
    props: {
        modelRoute: String,
        title: String
    },
    components: {
        myForm,
    },
    data() {
        return {
            dialog: false,
            loading: false,
            selectAll: false,
            snackbar: false,
            permissions: [],
            text: 'Created',
            form: {}
        }
    },
    mounted() {
        console.log(this.permissions);
    },
    methods: {
        toggleSelectAll() {
            // Toggle the selection state of all permissions based on selectAll value
            const newValue = this.selectAll;
            const updatedPermissions = JSON.parse(JSON.stringify(this.permissions));
            for (let groupKey in updatedPermissions) {
                const group = updatedPermissions[groupKey];
                for (let permission of group) {
                    permission.has_permission = newValue;
                }
            }
            // Update the permissions data with the new values
            this.permissions = updatedPermissions;
        },


        async getPermission(id) {
            this.loading = true;

            try {
                const response = await axios.get(`permissions/${id}`);
                this.permissions = response.data
                console.log("🚀 ~ dispatch ~ response:", response)
            } catch (error) {
                console.log("🚀 ~ axios.get ~ error:", error);
            } finally {
                this.loading = false;
            }
        },
        submit() {
            const selectedPermissionIds = [];
            for (let groupKey in this.permissions) {
                const group = this.permissions[groupKey];
                for (let permission of group) {
                    if (permission.has_permission) {
                        selectedPermissionIds.push(permission.id);
                    }
                }
            }

            this.loading = true

            this.form.permissions = selectedPermissionIds;

            this.$inertia.post(`/${this.modelRoute}`, this.form, {
                onError: () => {
                    this.loading = false
                    this.text = 'Something went wrong';
                    this.snackbar = true
                },
                onSuccess: () => {
                    this.text = 'Created';

                    this.loading = false
                    this.snackbar = true
                    // this.$refs.snackBarModal.show('Created')
                    console.log('success');
                }
            })

            setTimeout(() => {
                this.loading = false
            }, 5000);
        },

        show() {
            this.dialog = true
            this.getPermission(0)
        },
        close() {
            this.dialog = false
        }
    },
}
</script>
