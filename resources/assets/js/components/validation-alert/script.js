import { ValidationErrors } from '../../library/ValidationErrors'

export default {
    props: {
        validationErrors: {
            type: ValidationErrors,
            required: true
        }
    },
    
    computed: {
        errorList () {
            return this.validationErrors.toArray()
        }
    }
}
