@extends('layouts.app')

@section('content')
    <v-container fluid>
        <mxs-login-form reset-password-url="{{ route('password.request') }}"></mxs-login-form>
    </v-container>
@endsection
