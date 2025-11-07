@props(['success', 'message'])

<div id="message" class="absolute top-5 left-5 right-5 text-white {{ $success ? "bg-green-300" : "bg-red-400" }} p-2 rounded shadow">
    <p class="font-bold">{{ $message }}</p>
</div>
