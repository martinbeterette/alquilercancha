@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
{{-- <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo"> --}}
<img src="{{ config('app.url') }}/images/shoot.png" class="logo" alt="Mi App">

@else
{{ $slot }}
@endif
</a>
</td>
</tr>
