@extends('admin.layouts.app')

@section('title', 'Client Concierge Messages | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Client Concierge Inquiries
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Review and resolve customer inquiries, bespoke commissions, and sizing assistance for By Zunash patrons.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if($unreadCount > 0)
                <span class="px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold">
                    {{ $unreadCount }} Unread Inquiries
                </span>
            @else
                <span class="px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                    All Inquiries Handled
                </span>
            @endif
        </div>
    </div>

    <!-- Messages List -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
            @forelse($inquiries as $inquiry)
                <div class="p-6 hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-1.5 max-w-2xl">
                        <div class="flex items-center gap-2">
                            <h2 class="font-bold text-sm text-espresso-950 dark:text-white">
                                {{ $inquiry->subject }}
                            </h2>
                            @if($inquiry->status === 'unread')
                                <span class="px-2 py-0.2 rounded-full text-[9px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    NEW
                                </span>
                            @else
                                <span class="px-2 py-0.2 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    RESOLVED
                                </span>
                            @endif
                        </div>

                        <p class="text-xs text-[#6E6359] dark:text-[#C5B8AC] leading-relaxed">
                            {{ $inquiry->message }}
                        </p>

                        <div class="flex items-center gap-3 text-[11px] text-[#8F8379] pt-1">
                            <span>From: <strong>{{ $inquiry->name }}</strong> ({{ $inquiry->email }})</span>
                            @if($inquiry->phone)
                                <span>• Phone: {{ $inquiry->phone }}</span>
                            @endif
                            <span>• {{ $inquiry->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0 self-start sm:self-center">
                        @if($inquiry->status === 'unread')
                            <form action="{{ route('admin.messages.resolve', $inquiry) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-2xs transition-colors border border-gold-400/20">
                                    Mark as Handled
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.messages.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 transition-colors" title="Delete Inquiry">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-gray-400">
                    <i data-lucide="inbox" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
                    No customer concierge inquiries present.
                </div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
            {{ $inquiries->links() }}
        </div>
    </div>

</div>

@endsection
