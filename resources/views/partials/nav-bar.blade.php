<v-toolbar class="indigo accent-3">
    <v-toolbar-title>
        <a href="{{ route('welcome') }}">MXS Garage</a>
    </v-toolbar-title>

    <v-toolbar-items>
        <v-toolbar-item ripple>
            Tracks
        </v-toolbar-item>
        <v-toolbar-item ripple>
            Models and Skins
        </v-toolbar-item>

        @if (Auth::guest())
            <v-toolbar-item ripple href="{{ route('login') }}">
                Login
            </v-toolbar-item>
            <v-toolbar-item ripple href="{{ route('register') }}">
                Register
            </v-toolbar-item>
        @else
            <v-menu>
                <v-btn slot="activator" flat dark>{{ Auth::user()->name }}</v-btn>
                <v-list>
                    <v-list-item>
                        <v-list-tile>
                            <v-list-tile-title onclick="document.getElementById('logout-form').submit();">
                                Logout
                            </v-list-tile-title>
                        </v-list-tile>
                    </v-list-item>
                </v-list>
            </v-menu>
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif
    </v-toolbar-items>
</v-toolbar>
