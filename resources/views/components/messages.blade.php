@if (session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-2" role="alert">
        <strong class="font-bold">{{ session('success') }}</strong>
    </div>
@endif

@if (session()->has('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2" role="alert">
        <strong class="font-bold">{{ session('error') }}</strong>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2" role="alert">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li class="font-bold">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
