@component('mail::message')
A track was added to the website.

@component('mail::button', ['url' => route('tracks.show', [$track])])
View Track
@endcomponent
@endcomponent
