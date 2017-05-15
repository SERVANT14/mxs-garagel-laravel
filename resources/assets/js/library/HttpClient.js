import { ValidationErrors } from './ValidationErrors'
import { eventHub } from '../eventHub'

export class HttpClient {
    constructor (endPoint) {
        this.endPoint = endPoint
        this.params = {}
    }

    setParams (params) {
        this.params = params

        return this
    }

    post () {
        eventHub.$emit('http-request-started')
        
        return this._handleResponse(
            axios.post(Laravel.appUrl + '/' + this.endPoint, this.params)
        )
    }

    _handleResponse (promise) {
        return promise.catch(error => {
            if (ValidationErrors.responseHasValidationErrors(error.response)) {
                error = ValidationErrors.fromResponse(error.response)
            }

            eventHub.$emit('http-error-occurred', error)

            throw error
        })
    }
}