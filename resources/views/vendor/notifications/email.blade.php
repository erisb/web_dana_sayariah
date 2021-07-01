<img src="/img/logo.png" alt="">
<hr>
<h2>Atur Ulang Kata Sandi<b>Dana Syariah</b> </h2>


{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach
<br>
{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'green';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset