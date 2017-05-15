import { AuthApi } from '../../api/AuthApi'
import { forwardTo } from '../../library/helpers'

export default {
    data () {
        return {
            registering: false,
            registered: false,

            formData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        }
    },

    methods: {
        /**
         * Submit the form.
         */
        submitForm () {
            this.onRegisterStart()

            AuthApi.register(this.formData)
                .then(() => this.onRegisterSuccess())
                .catch(error => this.onRegisterError(error))
        },

        /**
         * Actions to perform when a registration attempt is beginning.
         */
        onRegisterStart () {
            this.registering = true
            this.registered = false
        },

        /**
         * Actions to perform when registration was successful.
         */
        onRegisterSuccess () {
            this.registering = false
            this.registered = true

            forwardTo('/')
        },

        /**
         * Actions to perform when registration failed.
         */
        onRegisterError () {
            this.registering = false
            this.registered = false
        }
    }
}
