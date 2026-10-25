@extends('admin.layouts.app')

@section('title', 'Customer Reviews & Testimonials | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Customer Reviews & Testimonials
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Verify and curate client testimonials and verified Pakistani patron feedback.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] text-xs font-bold text-espresso-950 dark:text-white shadow-2xs">
                Average Rating: <span class="text-amber-500">★</span> {{ number_format($averageRating, 1) }} / 5.0
            </span>
        </div>
    </div>

    <!-- Reviews Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($reviews as $review)
            <div class="p-6 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-full bg-espresso-900 text-gold-400 border border-gold-400/30 font-bold text-xs flex items-center justify-center shrink-0">
                                {{ $review->initials ?: strtoupper(substr($review->author, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-bold text-sm text-espresso-950 dark:text-white">
                                    {{ $review->author }}
                                </div>
                                <div class="text-[10px] text-gray-400">
                                    {{ $review->city ?: 'Verified Patron' }}
                                </div>
                            </div>
                        </div>

                        <!-- Rating Stars -->
                        <div class="text-amber-500 font-bold text-sm">
                            @for($i = 0; $i < $review->rating; $i++)
                                ★
                            @endfor
                        </div>
                    </div>

                    <div class="text-xs font-bold text-espresso-900 dark:text-white mb-1">
                        "{{ $review->title }}"
                    </div>

                    <p class="text-xs text-[#6E6359] dark:text-[#C5B8AC] leading-relaxed line-clamp-3">
                        {{ $review->comment }}
                    </p>

                    <div class="text-[10px] text-tan-600 dark:text-gold-400 font-medium mt-3">
                        Purchased: {{ $review->product_name }}
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center justify-between">
                    <div>
                        @if($review->status === 'published')
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Published on Store
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Hidden / Pending
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.reviews.publish', $review) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1 rounded-lg text-[10px] font-semibold border transition-colors {{ $review->status === 'published' ? 'border-gray-200 text-gray-500 hover:bg-gray-100' : 'border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                                {{ $review->status === 'published' ? 'Hide' : 'Publish' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-gray-400 hover:text-rose-600">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 py-12 text-center text-gray-400">
                No customer reviews submitted yet.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $reviews->links() }}
    </div>

</div>

@endsection
