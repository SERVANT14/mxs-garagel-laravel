import { AuthApi } from '../../api/AuthApi'
import { forwardTo } from '../../library/helpers'

export default {
    props: {
        resetPasswordUrl: {
            type: String,
            required: true
        }
    },

    data () {
        return {
            loggingIn: false,
            loggedIn: false,

            formData: {
                email: '',
                password: '',
                remember: false
            }
        }
    },

    methods: {
        /**
         * Submit the form.
         */
        submitForm () {
            this.onLoginStart()

            AuthApi.login(this.formData)
                .then(() => this.onLoginSuccess())
                .catch(error => this.onLoginError(error))
        },

        /**
         * Actions to perform when a login attempt is beginning.
         */
        onLoginStart () {
            this.loggingIn = true
            this.loggedIn = false
        },

        /**
         * Actions to perform when a login was successful.
         */
        onLoginSuccess () {
            this.loggingIn = false
            this.loggedIn = true

            forwardTo('/')
        },

        /**
         * Actions to perform when a login failed.
         */
        onLoginError (error) {
            this.loggingIn = false
            this.loggedIn = false
        }
    }
}
