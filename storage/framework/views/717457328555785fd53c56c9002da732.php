<?php $__env->startSection('content'); ?>
<div class="page-wrapper" style="min-height: 100vh;">
    <div class="container-xl">
        <div class="row">
            <div class="col">
                <?php echo $__env->make('partials._page_header', [
                    'title' => __('Messages'),
                    'section' => 'OVERVIEW'
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <div class="page-body" style="flex: 1;">
        <div class="container-fluid p-4">
            <div class="card shadow-sm" style="height: calc(100vh - 11rem);">
                <div class="row g-0 h-100">
                    <!-- Message List -->
                    <div class="col-12 col-md-6 col-lg-4 bg-white border-end d-flex flex-column" style="height: 100%; overflow: hidden;">
                        <div class="p-3 border-bottom" style="background-color: #f8f9fa;">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control border shadow-none" id="messageSearch" placeholder="Search messages..." style="font-size: 1.2rem;">
                                <button class="btn btn-primary" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                                </button>
                            </div>
                            <div id="searchFeedback" class="mt-2 text-muted d-none" style="font-size: 1.1rem;">
                                Searching messages from: <span id="searchUser"></span>
                            </div>
                        </div>
                        <div class="chat-users flex-grow-1">
                            <?php $__currentLoopData = $users->where('role', 'pet_owner'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $hasUnreadMessages = $user->receivedMessages
                                        ->filter(function($message) {
                                            return is_array($message->receivers) && 
                                                   collect($message->receivers)->contains('id', auth()->id()) &&
                                                   is_null($message->read_at);
                                        })
                                        ->count() > 0;
                                ?>
                                <a href="<?php echo e(route('messages.chat', $user->id)); ?>" 
                                   class="chat-user-item position-relative d-flex align-items-center text-decoration-none p-4 border-bottom
                                          <?php echo e($hasUnreadMessages ? 'unread-messages' : ''); ?>">
                                    <div class="me-3 position-relative">
                                        <?php if($user->photo_data): ?>
                                            <img src="data:image/jpeg;base64,<?php echo e(base64_encode($user->photo_data)); ?>" 
                                                 alt="<?php echo e($user->name); ?>" 
                                                 class="rounded-circle shadow-sm" 
                                                 width="64" 
                                                 height="64" 
                                                 style="object-fit: cover;">
                                        <?php elseif($user->photo): ?>
                                            <img src="<?php echo e(asset('storage/' . $user->photo)); ?>" 
                                                 alt="<?php echo e($user->name); ?>" 
                                                 class="rounded-circle shadow-sm" 
                                                 width="64" 
                                                 height="64" 
                                                 style="object-fit: cover;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/img/default-avatar.png')); ?>" 
                                                 alt="No Profile" 
                                                 class="rounded-circle shadow-sm" 
                                                 width="64" 
                                                 height="64">
                                        <?php endif; ?>
                                    </div>    
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <h5 class="mb-0 text-truncate <?php echo e($hasUnreadMessages ? 'fw-bold' : ''); ?>" 
                                                    style="font-size: 1.35rem;">
                                                    <?php echo e($user->name); ?>

                                                </h5>
                                            </div>
                                            <small class="text-muted" style="font-size: 1.1rem;">
                                                <?php if($user->lastMessage): ?>
                                                    <?php echo e(\Carbon\Carbon::parse($user->lastMessage->created_at)
                                                        ->timezone(config('app.timezone'))
                                                        ->format('h:i A')); ?>

                                                <?php endif; ?>
                                            </small>
                                        </div>
                                        <p class="mb-0 text-truncate <?php echo e($hasUnreadMessages ? 'fw-semibold' : ''); ?>" 
                                           style="font-size: 1.15rem; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?php if($user->lastMessage): ?>
                                                <?php if($user->lastMessage->sender_id === auth()->id()): ?>
                                                    You: <?php echo e(Str::limit($user->lastMessage->message, 30)); ?>

                                                <?php else: ?>
                                                    <?php echo e(Str::limit($user->lastMessage->message, 35)); ?>

                                                <?php endif; ?>
                                            <?php else: ?>
                                                No messages yet
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    
                    <!-- Empty State for Chat Window -->
                    <div class="col-md-6 col-lg-8 d-none d-md-flex flex-column" style="height: 100%; overflow: hidden;">
                        <!-- Chat Header -->
                        <div class="chat-header bg-white border-bottom p-3 d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="placeholder-glow">
                                    <div class="placeholder rounded-circle" style="width: 40px; height: 40px;"></div>
                                </div>
                                <div class="ms-3">
                                    <div class="placeholder-glow">
                                        <span class="placeholder col-6"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Body -->
                        <div class="chat-body flex-grow-1" style="background-color: #f8f9fa; overflow-y: auto;">
                            <div id="messages-container" class="p-4">
                                <?php $__currentLoopData = $messages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="message mb-3 <?php echo e($message->sender_id == auth()->id() ? 'sent' : 'received'); ?>">
                                        <div class="message-bubble p-3 rounded-3 <?php echo e($message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-white'); ?>">
                                            <p class="mb-1"><?php echo e($message->message); ?></p>
                                            <small class="text-<?php echo e($message->sender_id == auth()->id() ? 'light' : 'muted'); ?>">
                                                <?php echo e(\Carbon\Carbon::parse($message->created_at)
                                                    ->timezone(config('app.timezone'))
                                                    ->format('h:i A')); ?>

                                            </small>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Chat Footer -->
                        <div class="chat-footer bg-white border-top p-3">
                            <form id="message-form" class="message-form">
                                <?php echo csrf_field(); ?>
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control border-0" id="message-input" name="message" placeholder="Type your message..." style="font-size: 1.2rem;">
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .message {
        max-width: 80%;
    }
    .message.sent {
        margin-left: auto;
    }
    .message.received {
        margin-right: auto;
    }
    .message-bubble {
        display: inline-block;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    .sent .message-bubble {
        border-radius: 15px 15px 0 15px !important;
    }
    .received .message-bubble {
        border-radius: 15px 15px 15px 0 !important;
    }
    #messages-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .chat-user-item {
        transition: all 0.2s ease;
        position: relative;
        background-color: #ffffff;
    }
    .chat-user-item.unread-messages {
        background-color: #e8f0fe !important;
        border-left: 4px solid #206bc4;
    }
    .chat-user-item.unread-messages h5 {
        color: #206bc4 !important;
    }
    .chat-user-item.unread-messages p {
        color: #1a1a1a !important;
    }
    .chat-user-item:hover {
        background-color: #f8f9fa;
    }
    .chat-user-item.unread-messages:hover {
        background-color: #dae7fd !important;
    }
    .chat-user-item .position-absolute.bg-danger {
        width: 12px;
        height: 12px;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.3);
    }
    .chat-user-item.unread-messages .text-muted {
        color: #2c3338 !important;
        font-weight: 500;
    }
    .chat-user-item.unread-messages h5 {
        color: #206bc4 !important;
    }
    .chat-user-item .badge.bg-danger {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
        font-weight: 600;
        background-color: #dc3545 !important;
    }
    .chat-user-item.active {
        background-color: rgba(32, 107, 196, 0.1);
    }
    .chat-user-item:hover {
        transform: translateX(4px);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchFeedback = document.getElementById('searchFeedback');
        const searchUser = document.getElementById('searchUser');
        
        // Message search functionality
        const messageSearch = document.getElementById('messageSearch');
        const chatUserItems = document.querySelectorAll('.chat-user-item');

        messageSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            chatUserItems.forEach(item => {
                const userName = item.querySelector('h5').textContent.toLowerCase();
                const lastMessage = item.querySelector('p').textContent.toLowerCase();
                
                if (userName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                    item.style.display = 'flex';
                    if (searchTerm !== '') {
                        searchFeedback.classList.remove('d-none');
                        searchUser.textContent = item.querySelector('h5').textContent;
                    }
                } else {
                    item.style.display = 'none';
                }
            });

            if (searchTerm === '') {
                searchFeedback.classList.add('d-none');
                chatUserItems.forEach(item => {
                    item.style.display = 'flex';
                });
            }
        });

        // Highlight active user
        const currentPath = window.location.pathname;
        
        chatUserItems.forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            }
        });

        // Message form submission
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const messagesContainer = document.getElementById('messages-container');

        if (messageForm) {
            messageForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();
                if (!message) return;

                try {
                    const response = await fetch('/messages/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            message: message,
                            receiver_id: currentChatUserId // You'll need to set this based on selected user
                        })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        // Add message to chat
                        appendMessage({
                            message: message,
                            sent_at: new Date(),
                            sender_id: <?php echo e(auth()->id()); ?>

                        });
                        messageInput.value = '';
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                }
            });
        }

        function appendMessage(message) {
            const messageElement = document.createElement('div');
            messageElement.className = `message mb-3 ${message.sender_id == <?php echo e(auth()->id()); ?> ? 'sent' : 'received'}`;
            
            const time = new Date(message.sent_at).toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            messageElement.innerHTML = `
                <div class="message-bubble p-3 rounded-3 ${message.sender_id == <?php echo e(auth()->id()); ?> ? 'bg-primary text-white' : 'bg-white'}">
                    <p class="mb-1">${message.message}</p>
                    <small class="text-${message.sender_id == <?php echo e(auth()->id()); ?> ? 'light' : 'muted'}">${time}</small>
                </div>
            `;

            messagesContainer.appendChild(messageElement);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Auto-scroll to bottom of messages
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Fetch messages periodically
        setInterval(async function() {
            if (currentChatUserId) {
                try {
                    const response = await fetch(`/messages/get/${currentChatUserId}`);
                    const data = await response.json();
                    updateMessages(data.messages);
                } catch (error) {
                    console.error('Error fetching messages:', error);
                }
            }
        }, 5000); // Fetch every 5 seconds

        // Add this function to mark messages as read
        async function markMessagesAsRead(userId) {
            try {
                await fetch(`/messages/mark-as-read/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
            } catch (error) {
                console.error('Error marking messages as read:', error);
            }
        }

        // Add click event listener to chat items
        chatUserItems.forEach(item => {
            item.addEventListener('click', function() {
                const userId = this.getAttribute('href').split('/').pop();
                markMessagesAsRead(userId);
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<style>
    .page-wrapper {
        display: flex;
        flex-direction: column;
    }
    .hover-bg-light:hover {
        background-color: rgba(0,0,0,0.05);
    }
    .chat-users {
        overflow-y: auto;
        border-top: 1px solid rgba(0,0,0,0.1);
    }
    .chat-users::-webkit-scrollbar {
        width: 8px;
    }
    .chat-users::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .chat-users::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    .chat-user-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    .chat-user-item:hover {
        transform: translateX(5px);
        background-color: #f8f9fa;
        border-left: 4px solid #206bc4;
    }
    .chat-user-item.active {
        background-color: #f0f0f0;
        border-left: 4px solid #206bc4;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05);
    }
    .chat-user-item.active h5 {
        color: #206bc4;
    }
    .badge {
        font-size: 1rem;
        padding: 0.4rem 0.8rem;
        min-width: 1.75rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    .text-muted {
        color: #6c757d !important;
    }
    .input-group-lg .form-control {
        height: calc(3.5rem + 2px);
        font-size: 1.2rem;
        border-radius: 8px 0 0 8px !important;
    }
    .input-group-lg .btn {
        padding: 0.75rem 1.25rem;
        border-radius: 0 8px 8px 0 !important;
    }
    .card {
        border: 1px solid rgba(0,0,0,0.125);
        border-radius: 12px;
        overflow: hidden;
    }
    .chat-header {
        height: 72px;
    }
    .chat-footer {
        height: 85px;
    }
    .placeholder {
        background-color: #dee2e6;
    }
</style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/message/index.blade.php ENDPATH**/ ?>