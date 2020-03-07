export default {
    props: {
        formErrors: {
            type: Object,
            default: () => ({})
        },
        formFilled: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            validated: false,
            error: '',
        }
    },
    methods: {
        validate: function (value) {
            this.validated = true;
            this.formFilled[this.name] = true;
            const entries = Object.entries(this.validationRules);
            for (let i in entries) {
                const fn = entries[i][0] + 'Validator';
                const error = this[fn](value, (entries[i][1] || {}));
                if (error) {
                    if (!this.formErrors[this.name]) {
                        this.formErrors[this.name] = [];
                    }
                    this.formErrors[this.name] = error;
                    this.error = error;
                    return;
                }
            }
            this.formErrors[this.name] = '';
            this.error = '';
        },
        requiredValidator: function (inputValue, {message = 'Required Field'}) {
            if (inputValue.length === 0) {
                return message;
            }
        },
        minValidator: function (intputValue, {min = 0, message}) {
            if (intputValue.length < min) {
                return message || `Field length must be at least ${min}`;
            }
        }
    }
};