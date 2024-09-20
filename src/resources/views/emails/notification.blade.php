@component('mail::message')
# Reseからのお知らせ

{{ $messageContent}}

@component('mail::button', ['url' => route('home')])
ページに移動する
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
