@if ($errors->count())
    <v-alert error :value="true">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </v-alert>
@endif