import _ from 'lodash'

export class ValidationErrors {
    /**
     * Constructor.
     *
     * @param {Array} errorList
     */
    constructor (errorList) {
        this._setErrorList(errorList)
    }

    /**
     * Gives you the list of error messages as an array.
     *
     * @returns {Array}
     */
    toArray () {
        return this.errorList
    }

    /**
     * Sets the list of error messages.
     *
     * @param errorList
     * @private
     */
    _setErrorList (errorList) {
        this.errorList = []

        _.toArray(errorList)
            .forEach(fieldSet => this._addErrorList(fieldSet))
    }

    /**
     * Add a list of errors to the error list.
     *
     * @param list
     * @private
     */
    _addErrorList (list) {
        if (_.isArray(list)) {
            list.forEach(message => this.errorList.push(message))
        } else {
            this.errorList.push(list)
        }
    }

    /**
     * Do we have any errors?
     *
     * @returns {boolean}
     */
    hasErrors () {
        return this.errorList.length > 0
    }

    /**
     * Builds a validation errors object based on given response.
     *
     * @param response
     *
     * @returns {ValidationErrors|null}
     */
    static fromResponse (response) {
        let list = []

        if (ValidationErrors.responseHasValidationErrors(response)) {
            list = response.data
        }

        return new ValidationErrors(list)
    }

    /**
     * Does the response contain validation errors?
     *
     * @param response
     *
     * @returns {boolean}
     * @private
     */
    static responseHasValidationErrors (response) {
        return response.status == 422
    }
}