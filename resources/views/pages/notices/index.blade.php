@extends('layouts.app')

@section('title', 'Notice Board')

@section('content')
<flux:container>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($notices as $notice)
            <flux:card class="cursor-pointer transition hover:shadow-lg h-48 flex flex-row" onclick="window.location='{{ route('notices.show', $notice) }}'">
                <div class="p-4 flex-1 flex flex-col">
                    <h2 class="text-lg font-bold mb-1">{{ $notice->title }}</h2>
                    <p class="text-sm text-gray-500 mb-2">By {{ $notice->author }}</p>
                    <p class="text-gray-700 line-clamp-2 flex-1 overflow-hidden">{{ Str::limit(strip_tags($notice->body), 150) }}</p>
                </div>
                @if($notice->image)
                    <div class="w-48 flex-shrink-0">
                        <img src="{{ asset('storage/' . $notice->image) }}" class="w-full h-full object-cover rounded-r" style="object-fit: cover;" />
                    </div>
                @endif
            </flux:card>
        @endforeach
    </div>
</flux:container>
@endsection 