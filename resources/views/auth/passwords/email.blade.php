@extends('layouts.app')

@section('content')
    <v-container fluid>
        @include('partials.error-list')

        @if (session('status'))
            <v-alert success :value="true">
                {{ session('status') }}
            </v-alert>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <v-row class="mt-5">
                <v-col xs12 md7 offset-md3>
                    <v-card>
                        <v-card-row class="grey lighten-3">
                            <v-card-title>
                                <span>Reset Password</span>
                            </v-card-title>
                        </v-card-row>

                        <v-card-text>
                            <v-text-field
                                    label="Email"
                                    type="email"
                                    name="email"
                                    required
                                    autofocus
                                    value="{{ old('email') }}"
                                    prepend-icon="email"
                            ></v-text-field>

                            <v-btn primary type="submit">
                                Send Password Reset Link
                            </v-btn>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </form>
    </v-container>
@endsection
