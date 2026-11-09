@extends('admin.layouts.app')

@section('title', 'Client Concierge & VIP Inquiries | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Client Concierge & VIP Inquiries
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Review and resolve customer questions, back-in-stock alerts, sizing consultations, and bespoke commissions.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if($unreadCount > 0)
                <span class="px-3.5 py-1.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-amber-900 dark:text-amber-300 text-xs font-bold flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>{{ $unreadCount }} Unresolved Requests</span>
                </span>
            @else
                <span class="px-3.5 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs font-bold">
                    All Concierge Requests Handled
                </span>
            @endif
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Search by patron name, subject, email or keyword..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                >
            </div>

            <div class="w-full sm:w-48">
                <select 
                    name="status" 
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                >
                    <option value="all">Status: All Inquiries</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>New / Unread</option>
                    <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved & Closed</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shrink-0 transition-colors border border-gold-400/20">
                Filter
            </button>
            <a href="{{ route('admin.messages.index') }}" class="px-3 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-500 hover:bg-gray-100 dark:hover:bg-[#201A18] text-xs font-semibold">
                Reset
            </a>
        </form>
    </div>

    <!-- Messages List -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
            @forelse($inquiries as $inquiry)
                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $inquiry->phone ?? '');
                    if (str_starts_with($cleanPhone, '03')) {
                        $cleanPhone = '92' . substr($cleanPhone, 1);
                    }
                    $isRestock = str_contains(strtolower($inquiry->subject), 'restock');
                    $isBespoke = str_contains(strtolower($inquiry->subject), 'bespoke') || str_contains(strtolower($inquiry->subject), 'custom');
                @endphp
                <div class="p-6 hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors flex flex-col sm:flex-row sm:items-start justify-between gap-5">
                    <div class="space-y-2 flex-1 max-w-2xl">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="font-bold text-sm text-espresso-950 dark:text-white">
                                {{ $inquiry->subject }}
                            </h2>

                            @if($isRestock)
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/15 text-amber-800 dark:text-amber-300 border border-amber-500/30">
                                    RESTOCK REQUEST
                                </span>
                            @elseif($isBespoke)
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-purple-500/15 text-purple-800 dark:text-purple-300 border border-purple-500/30">
                                    BESPOKE COMMISSION
                                </span>
                            @endif

                            @if($inquiry->status === 'unread')
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                    PENDING
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                    RESOLVED
                                </span>
                            @endif
                        </div>

                        <p class="text-xs text-[#6E6359] dark:text-[#C5B8AC] leading-relaxed bg-[#FAF8F5]/60 dark:bg-[#1E1715]/60 p-3.5 rounded-xl border border-[#ECE6DE]/80 dark:border-[#2C2420]">
                            {{ $inquiry->message }}
                        </p>

                        <div class="flex items-center gap-3 text-[11px] text-[#8F8379] pt-1 flex-wrap">
                            <span>From: <strong class="text-espresso-950 dark:text-white">{{ $inquiry->name }}</strong> ({{ $inquiry->email }})</span>
                            @if($inquiry->phone)
                                <span>• Phone: <strong class="text-espresso-950 dark:text-white font-mono">{{ $inquiry->phone }}</strong></span>
                            @endif
                            <span>• {{ $inquiry->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Actions Bar -->
                    <div class="flex items-center gap-2 shrink-0 self-start sm:self-center flex-wrap">
                        
                        <!-- WhatsApp Direct Contact -->
                        @if($cleanPhone)
                            <a 
                                href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Assalam o Alaikum ' . $inquiry->name . ', regarding your By Zunash inquiry: ' . $inquiry->subject) }}" 
                                target="_blank"
                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-semibold flex items-center gap-1.5 transition-colors shadow-2xs"
                                title="Chat with patron on WhatsApp"
                            >
                                <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                <span>WhatsApp VIP</span>
                            </a>
                        @endif

                        <!-- Email Direct Contact -->
                        <a 
                            href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Re: ' . $inquiry->subject . ' — By Zunash Atelier') }}" 
                            class="px-3 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#201A18] text-[11px] font-semibold flex items-center gap-1.5 transition-colors"
                            title="Reply via Email"
                        >
                            <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                            <span>Email</span>
                        </a>

                        @if($inquiry->status === 'unread')
                            <form action="{{ route('admin.messages.resolve', $inquiry) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-2xs transition-colors border border-gold-400/20">
                                    Mark Handled
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.messages.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-[#241D1A]" title="Delete Inquiry">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-gray-400">
                    <i data-lucide="inbox" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
                    No customer concierge inquiries found.
                </div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
            {{ $inquiries->links() }}
        </div>
    </div>

</div>

@endsection
