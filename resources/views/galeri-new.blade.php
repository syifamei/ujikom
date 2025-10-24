@extends('layouts.app')

@section('title', 'Galeri - SMKN 4 BOGOR')

@push('styles')
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-b from-blue-500 to-blue-400 text-white text-center py-16">
        <div class="flex justify-center mb-4">
            <div class="bg-white/20 p-4 rounded-full">
                <i class="fa-solid fa-camera text-4xl"></i>
            </div>
        </div>
        <h1 class="text-4xl font-bold flex justify-center items-center gap-2">
            <i class="fa-solid fa-camera-retro"></i> Galeri Foto Sekolah
        </h1>
        <p class="mt-3 text-lg opacity-90">
            Jelajahi berbagai momen berharga dan kegiatan sekolah kami
        </p>
    </div>

    <!-- Filter -->
    <div class="max-w-6xl mx-auto -mt-10 bg-white rounded-2xl shadow-lg p-6">
        <div class="text-center mb-5">
            <h2 class="text-gray-700 font-semibold text-xl flex justify-center items-center gap-2">
                <i class="fa-solid fa-filter text-blue-500"></i> Filter Kategori
            </h2>
        </div>

        <div x-data="{ active: 'Semua' }" class="flex flex-wrap justify-center gap-3">
            @php
                $categories = [
                    ['icon' => 'fa-th-large', 'name' => 'Semua'],
                    ['icon' => 'fa-users', 'name' => 'Classmeet'],
                    ['icon' => 'fa-trophy', 'name' => 'Lomba Kemerdekaan'],
                    ['icon' => 'fa-moon', 'name' => 'Moontour'],
                    ['icon' => 'fa-star', 'name' => 'P5'],
                    ['icon' => 'fa-music', 'name' => 'Pensi'],
                ];
            @endphp

            @foreach ($categories as $cat)
                <button 
                    @click="active = '{{ $cat['name'] }}'"
                    :class="active === '{{ $cat['name'] }}' ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-700 hover:bg-blue-200'" 
                    class="flex items-center gap-2 px-5 py-2 rounded-full transition font-medium">
                    <i class="fa {{ $cat['icon'] }}"></i> {{ $cat['name'] }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Gallery -->
    <div x-data="{ activeCategory: 'Semua', openComment: false, selectedPhoto: null }" class="max-w-6xl mx-auto grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 mt-10 pb-16 px-4">
        @foreach ($galeri as $item)
        <div 
            x-show="activeCategory === 'Semua' || activeCategory === '{{ $item->kategori }}'"
            class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col"
        >
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-56 object-cover">
            <div class="p-4 flex flex-col flex-grow">
                <p class="text-blue-500 text-sm font-medium flex items-center gap-1">
                    <i class="fa-solid fa-folder"></i> {{ $item->kategori }}
                </p>
                <h3 class="font-semibold text-gray-800 text-lg mt-1 flex-grow">{{ $item->judul }}</h3>

                <!-- Action buttons -->
                <div class="flex justify-between items-center mt-3">
                    <!-- Like -->
                    <button 
                        x-data="{ liked: false, count: {{ $item->likes ?? 0 }} }"
                        @click="liked = !liked; liked ? count++ : count--"
                        class="flex items-center gap-1 text-gray-600 hover:text-red-500 transition">
                        <i :class="liked ? 'fa-solid fa-heart text-red-500' : 'fa-regular fa-heart'"></i>
                        <span x-text="count"></span>
                    </button>

                    <!-- Comment -->
                    <button 
                        @click="openComment = true; selectedPhoto = '{{ $item->judul }}'" 
                        class="flex items-center gap-1 text-gray-600 hover:text-blue-500 transition">
                        <i class="fa-regular fa-comment"></i> Komentar
                    </button>

                    <!-- Download -->
                    <a href="{{ asset('storage/' . $item->gambar) }}" download class="flex items-center gap-1 text-gray-600 hover:text-green-500 transition">
                        <i class="fa-solid fa-download"></i> Unduh
                    </a>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Modal Komentar -->
        <div 
            x-show="openComment" 
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" 
            x-transition
        >
            <div class="bg-white w-96 rounded-2xl shadow-lg p-6 relative">
                <button @click="openComment = false" class="absolute top-2 right-3 text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <h2 class="text-lg font-semibold text-gray-800 mb-3">
                    Komentar untuk <span class="text-blue-500" x-text="selectedPhoto"></span>
                </h2>

                <textarea rows="3" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200 outline-none" placeholder="Tulis komentar kamu..."></textarea>

                <div class="text-right mt-3">
                    <button @click="openComment = false" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Kirim
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




