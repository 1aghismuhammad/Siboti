@props(['name', 'show' => false, 'maxWidth' => '2xl'])

<div
    x-data="{ show: @js($show) }"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="modal"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    <div class="modal__overlay" x-on:click="show = false"></div>
    <div class="modal__dialog modal__dialog--{{ $maxWidth }}">
        {{ $slot }}
    </div>
</div>
