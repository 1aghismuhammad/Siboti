@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'dropdown-panel'])

<div class="dropdown" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open" class="dropdown-menu dropdown-menu--{{ $align }}" style="display: none;" @click="open = false">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
