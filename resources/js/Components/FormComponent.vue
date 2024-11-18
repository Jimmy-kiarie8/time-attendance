<template>
    <v-row>
        <template v-for="item in formData" :key="item.model">
            <v-col :cols="item.col" :md="item.col" v-if="item.display">
                <v-radio-group v-model="form[item.model]" inline v-if="item.type == 'radio'" color="success">
                    <template v-slot:label>
                        <div>{{ item.label }}</div>
                    </template>
                    <v-radio :label="'Yes'" :value="true"></v-radio>
                    <v-radio :label="'No'" :value="false"></v-radio>
                </v-radio-group>

                <v-checkbox v-model="form[item.model]" :label="item.label"
                    v-else-if="item.type == 'checkbox'"></v-checkbox>

                <div v-else-if="item.type == 'header'">
                    <h3>{{ item.value }}</h3>
                    <br>
                    <v-divider></v-divider>
                </div>


                <v-textarea clearable :label="item.label" rows="3" variant="outlined" v-model="item.value"
                    v-else-if="item.type == 'long_text'" density="compact"></v-textarea>

                <div v-else-if="item.type == 'file'">
                    <v-file-input v-model="form[item.model]" :label="item.label" :multiple="item.multiple"
                        :accept="item.accept" :required="item.required" density="compact" variant="outlined"
                        @change="handleFileChange(item.model, $event)">
                        <template v-slot:selection="{ fileNames }">
                            <template v-for="fileName in fileNames" :key="fileName">
                                <v-chip size="small" label color="primary" class="me-2">
                                    {{ fileName }}
                                </v-chip>
                            </template>
                        </template>
                    </v-file-input>
                </div>

                <!-- Dynamic handling for guarantors -->
                <div v-else-if="item.type === 'array'">
                    <v-btn @click="addGuarantor(item)" color="primary">Add Guarantor</v-btn>
                    <br>
                    <br>
                    <v-row>
                        <template v-for="(guarantor, index) in form[item.model]" :key="index">
                            <v-col cols="5">
                                <v-select clearable :label="item.label" v-model="guarantor.id" density="compact"
                                    :items="guarantors" item-title="name" item-value="id" variant="outlined"></v-select>

                            </v-col>
                            <v-col cols="1">

                                <v-btn icon color="error" @click="removeGuarantor(index)" size="small">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </v-col>
                        </template>
                    </v-row>
                </div>

                <component :is="getComponentType(item.type)" v-model="form[item.model]" :label="item.label"
                    :items="item.items" density="compact" clearable variant="outlined"
                    :type="item.type === 'number' ? 'number' : (item.type === 'date') ? 'date' : 'text'"
                    :disabled="item.disabled" :multiple="item.type === 'select' && item.multiple" item-title="label"
                    item-value="value" chips v-else>
                </component>



            </v-col>
        </template>
    </v-row>
</template>

<script setup>
import axios from 'axios';
import { onMounted } from 'vue';
import { computed, watch, ref } from 'vue';

const props = defineProps({
    formData: {
        type: Array,
        required: true
    },
    form: {
        type: Object,
        required: true
    },
    guarantors: {
        type: Object,
        required: false
    }
});

// const guarantors = ref([]);

const emit = defineEmits(['update:form']);

const getComponentType = computed(() => (type) => {
    switch (type) {
        case 'text':
        case 'number':
        case 'date':
            return 'v-text-field';
        case 'select':
            return 'v-autocomplete';
        case 'radio':
            return 'v-radio-group';
        default:
            return 'v-text-field';
    }
});


function addGuarantor(item) {
    const newGuarantor = {
        id: '',
    };
    props.form[item.model].push(newGuarantor);
    // props.form[props.formData.find(item => item.type === 'array').model].push(newGuarantor);
}

function removeGuarantor(index) {
    props.form[props.formData.find(item => item.type === 'array').model].splice(index, 1);
}


function handleFileChange(model, files) {
    emit('update:form', { ...props.form, [model]: files });
}

// function getGuarantors() {
//     axios.get('guarantors?axios=true').then((res) => {
//         guarantors.value = res.data.data;
//     }).catch((error) => {
//         console.error(error);
//     })
// }

// Watch for changes in the form and emit updates
watch(() => props.form, (newValue) => {
    emit('update:form', newValue);
}, { deep: true });

// onMounted
onMounted(() => {
    // getGuarantors()

    setTimeout(() => {

        // console.log(guarantors.value);
    }, 2000);

});

</script>
