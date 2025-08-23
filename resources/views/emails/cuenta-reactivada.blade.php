@component('mail::message')
# ¡Hola {{ $user->name }}!

Tu cuenta fue reactivada.  
Para volver a usarla, por favor confirma haciendo clic en el siguiente botón:

@component('mail::button', ['url' => route('verification.notice')])
Confirmar mi cuenta
@endcomponent

Gracias,  
El equipo de {{ config('app.name') }}
@endcomponent