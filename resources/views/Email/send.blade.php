@component('mail::message')
# Introduction

{{ $data['message'] }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks, GML Test<br>
{{ config('app.name') }}
@endcomponent
