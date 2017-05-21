@component('mail::message')
A track was modified on website.

@component('mail::button', ['url' => route('tracks.show', [$track])])
View Track
@endcomponent
@endcomponent
