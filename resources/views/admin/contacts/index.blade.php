@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-display font-bold text-luxury-900">Contact Messages</h1>
    <p class="text-luxury-500 mt-1">Manage inquiries and messages from customers.</p>
</div>

<div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-luxury-50 border-b border-luxury-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Sender</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Subject</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Date</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-luxury-100">
                @foreach($contacts as $contact)
                <tr class="hover:bg-luxury-50 transition-colors {{ $contact->status === 'new' ? 'bg-blue-50/30' : '' }}">
                    <!-- Status -->
                    <td class="px-6 py-4">
                        @if($contact->status === 'new')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">New</span>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Replied</span>
                        @endif
                    </td>

                    <!-- Sender Info -->
                    <td class="px-6 py-4">
                        <div class="font-medium text-luxury-900">{{ $contact->name }}</div>
                        <div class="text-sm text-luxury-500">{{ $contact->email }}</div>
                    </td>

                    <!-- Subject -->
                    <td class="px-6 py-4">
                        <div class="text-luxury-700 max-w-xs truncate">{{ $contact->subject ?? 'General Inquiry' }}</div>
                    </td>

                    <!-- Date -->
                    <td class="px-6 py-4 text-sm text-luxury-500 whitespace-nowrap">
                        {{ $contact->created_at->format('d M Y, H:i') }}
                    </td>

                    <!-- Action -->
                    <td class="px-6 py-4 text-right">
                        <button onclick="openModal({{ $contact }})" class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors">
                            @if($contact->status === 'new') View & Reply @else View Details @endif
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($contacts->isEmpty())
    <div class="text-center py-12">
        <svg class="w-16 h-16 text-luxury-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        <h3 class="text-lg font-medium text-luxury-700">Inbox Empty</h3>
        <p class="text-luxury-500">No messages found.</p>
    </div>
    @endif

    <!-- Pagination -->
    @if($contacts->hasPages())
    <div class="px-6 py-4 border-t border-luxury-100">
        {{ $contacts->links() }}
    </div>
    @endif
</div>

<!-- Modal for View/Reply -->
<div id="contactModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" onclick="closeModal()">
            <div class="absolute inset-0 bg-luxury-900 opacity-75"></div>
        </div>

        <!-- Modal Panel -->
        <div class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-luxury-100 flex justify-between items-center bg-luxury-50">
                <h3 class="text-lg font-bold text-luxury-900">Message Details</h3>
                <button onclick="closeModal()" class="text-luxury-400 hover:text-luxury-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-6">
                <!-- Sender Info -->
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-luxury-500">From</p>
                        <p class="font-semibold text-luxury-900" id="modal-name">-</p>
                    </div>
                    <div>
                        <p class="text-luxury-500">Email</p>
                        <p class="font-semibold text-luxury-900" id="modal-email">-</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-luxury-500">Phone</p>
                        <p class="font-semibold text-luxury-900" id="modal-phone">-</p>
                    </div>
                </div>

                <!-- Message Body -->
                <div class="bg-luxury-50 p-4 rounded-xl">
                    <p class="text-sm font-semibold text-luxury-700 mb-1">Message:</p>
                    <p class="text-luxury-600 text-sm whitespace-pre-line" id="modal-message">-</p>
                </div>

                <!-- Reply Section -->
                <form id="replyForm" action="" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-luxury-700 mb-2">Your Reply</label>
                        <textarea name="reply" rows="4" id="modal-reply-text" class="w-full px-4 py-3 bg-white border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none" placeholder="Type your reply here..."></textarea>

                        <!-- Existing Reply Info -->
                        <div id="previous-reply-info" class="hidden mt-2 text-xs text-green-600">
                            <span class="font-semibold">Replied at:</span> <span id="modal-replied-at"></span>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end gap-3">
                        <button type="button" onclick="closeModal()" class="px-6 py-2.5 bg-luxury-100 text-luxury-700 rounded-xl font-medium hover:bg-luxury-200 transition-colors">
                            Close
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition-colors">
                            Send Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(contact) {
        const modal = document.getElementById('contactModal');

        // Fill data
        document.getElementById('modal-name').innerText = contact.name;
        document.getElementById('modal-email').innerText = contact.email;
        document.getElementById('modal-phone').innerText = contact.phone || '-';
        document.getElementById('modal-message').innerText = contact.message;

        // Set form action
        document.getElementById('replyForm').action = `/admin/contacts/${contact.id}/reply`;

        // Handle reply data if exists
        const replyText = document.getElementById('modal-reply-text');
        const replyInfo = document.getElementById('previous-reply-info');

        if (contact.reply) {
            replyText.value = contact.reply;
            replyInfo.classList.remove('hidden');
            document.getElementById('modal-replied-at').innerText = contact.replied_at;
        } else {
            replyText.value = '';
            replyInfo.classList.add('hidden');
        }

        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeModal() {
        const modal = document.getElementById('contactModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Allow scrolling
    }
</script>
@endsection
