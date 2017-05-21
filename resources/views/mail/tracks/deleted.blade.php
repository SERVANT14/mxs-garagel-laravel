@component('mail::message')
A track was deleted.

@component('mail::button', ['url' => route('tracks.show', [$track])])
View Track
@endcomponent
@endcomponent
