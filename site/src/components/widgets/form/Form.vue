<template>
    <form @submit="submit">
        <text-field
                name="company"
                v-model="formData.name"
                label="Company Name"
                placeholder="Enter Company Name"
                description="The identification name for the company"
                :validation-rules="validationRules.company"
                :form-errors="errors"
                :form-filled="filled"
        >
        </text-field>
        <text-field
                name="address"
                v-model="formData.address"
                label="Company Address"
                placeholder="Enter Company Address"
                description="The identification name for the company"
                :validation-rules="validationRules.address"
                :form-errors="errors"
                :form-filled="filled"
        >
        </text-field>
        <hr/>
        <button type="submit" class="btn btn-primary" :disabled="!canSubmit">Submit</button>
    </form>
</template>

<script>
    import TextField from "./TextField";
    export default {
        name: 'form-widget',
        components: {TextField},
        data() {
            return {
                formData: {},
                validationRules: {
                    company: {
                        required: {},
                        min: {min: 3}
                    },
                    address: {
                        min: {min: 5}
                    }
                },
                filled: {},
                errors: {}
            }
        },
        methods: {
            submit: function(e) {
                console.log(this.errors);
                e.preventDefault();
            }
        },
        computed: {
            canSubmit: function () {
                return Object.values(this.errors).reduce((carry, current) => carry && current.length === 0, true) && Object.values(this.filled).reduce((carry, current) => carry && current, true);
            }
        },
        mounted: function() {
            for (let i in Object.keys(this.validationRules)) {
                this.$set(this.errors, Object.keys(this.validationRules)[i], []);
            }
            this.filled = Object.keys(this.validationRules).reduce((carry, current) => {
                carry[current] = false;
                return carry;
            }, {});
        }
    };
</script>

<style scoped="true">

</style>