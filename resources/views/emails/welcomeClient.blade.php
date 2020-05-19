@component('mail::message')
# Hola {{$client->name}}

Bienvenido a ECOLAB ya eres parte del equipo.
¡Esperamos tu contribución y dedicación con el resto del equipo!

Gracias,<br>
{{ config('app.name') }}
@endcomponent
