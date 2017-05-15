import _ from 'lodash'
import { ValidationErrors } from './library/ValidationErrors'
import { eventHub } from './eventHub'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vue.use(require('vuetify'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components-registrar').registerAll(Vue)

const app = new Vue({
    el: '#app',

    data () {
        return {
            validationErrors: new ValidationErrors([]),
            genericErrors: []
        }
    },

    created () {
        eventHub.$on('http-request-started', this.resetValidationErrors)
        eventHub.$on('http-error-occurred', this.onHttpErrorOccurred)
    },

    methods: {
        resetValidationErrors () {
            this.validationErrors = new ValidationErrors([])
        },

        /**
         * Called when an HTTP error occurs.
         *
         * @param error
         */
        onHttpErrorOccurred (error) {
            if (error instanceof ValidationErrors) {
                this.validationErrors = error
                return
            }

            this.addGenericError(`An error occurred (${error.response.status} ${error.response.statusText})`)
        },

        /**
         * Add a generic error message to the stack.
         *
         * @param message
         */
        addGenericError (message) {
            this.genericErrors.push({message, visible: true})
        }
    }
});
