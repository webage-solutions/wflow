<template>
    <div class="form-group">
        <label :for="inputId">{{ _label }}</label>
        <input
                type="text"
                class="form-control"
                :id="inputId"
                :aria-describedby="descId"
                :placeholder="_placeholder"
                :value="value"
                @input="updateInput($event.target.value)"
                @blur="validate($event.target.value)"
                @focus="validate($event.target.value)"
                @keyup="validate($event.target.value)"
                :class="validClass"
        />
        <small v-if="description" id="descId" class="form-text text-muted">{{ description }}</small>
        <div class="valid-feedback" v-if="validated && error.length === 0 && validFeedback.length > 0">
            {{ validFeedback }}
        </div>
        <div class="invalid-feedback" v-if="error.length > 0">
            {{ error }}
        </div>
    </div>
</template>

<script>
import FormFieldValidation from "../../../mixins/FormFieldValidation";

export default {
    name: 'text-field',
    mixins: [FormFieldValidation],
    props: {
        name: {
            required: true
        },
        label: {},
        placeholder: {},
        description: {},
        validFeedback: {
            default: ''
        },
        validationRules: {
            default: () => ({})
        },
        value: {}
    },
    methods: {
        updateInput: function (value) {
            this.$emit('input', value);
        }
    },
    computed: {
        validClass: function() {
            return {
                'is-valid': this.validated && this.error.length === 0,
                'is-invalid': this.validated && this.error.length > 0
            }
        },
        inputId: function () {
            return 'txt-' + this.name;
        },
        descId: function () {
            return 'desc-' + this.name;
        },
        _label: function() {
            return this.label || this.name;
        },
        _placeholder: function() {
            return this.placeholder || this.name;
        }

    }
};
</script>

<style scoped="true">

</style>