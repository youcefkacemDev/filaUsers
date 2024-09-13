@props(['title', 'name'])
<div
    class="fixed z-50 inset-0"
    x-data = "{show : false, name : '{{ $name }}' }"
    x-show = "show"
    x-on:open_modal.window = "show = ($event.detail.name === name)"
    style="display: none"
    x-on:close_modal.window = "show = false"
    x-transition
    >
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <div x-on:click="$dispatch('close_modal')" class="fixed inset-0 bg-sky-300 opacity-40 blur-3xl"></div>
    <div class="bg-white rounded-xl m-auto fixed inset-0 max-w-2xl p-5" style="max-height: 500px">
        <div>
            <h1 class="text-center font-bold text-3xl m-3">{{ $title }}</h1>
        </div>
        <div>
            {{ $body }}
        </div>
    </div>
</div>
