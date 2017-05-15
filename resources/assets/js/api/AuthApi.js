import { HttpClient } from '../library/HttpClient'

export class AuthApi {
    static login ({email, password, remember}) {
        return new HttpClient('login')
            .setParams({email, password, remember})
            .post()
    }

    static register ({name, email, password, password_confirmation}) {
        return new HttpClient('register')
            .setParams({name, email, password, password_confirmation})
            .post()
    }
}