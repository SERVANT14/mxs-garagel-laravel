export function registerAll (Vue) {
    Vue.component('mxs-login-form', require('./components/login-form'))
    Vue.component('mxs-register-form', require('./components/register-form'))
    Vue.component('mxs-validation-alert', require('./components/validation-alert'))
}