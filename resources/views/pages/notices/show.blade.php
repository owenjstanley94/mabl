@extends('layouts.app')

@section('title', $notice->title)

@section('content')
<flux:container>
    @if($notice->image)
        <div class="w-full h-[400px] mb-8 rounded-lg overflow-hidden">
            <img src="{{ asset('storage/' . ($notice->hero_image ?? $notice->image)) }}" class="w-full h-full object-cover" alt="{{ $notice->title }}" />
        </div>
    @endif
    
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">{{ $notice->title }}</h1>
        <p class="text-gray-500 mb-8">By {{ $notice->author }}</p>
        
        <div class="prose max-w-none">
            {!! $notice->body !!}
        </div>
    </div>
</flux:container>
@endsection 