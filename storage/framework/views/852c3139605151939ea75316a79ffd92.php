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
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('messages.chat', $user->id)); ?>" class="chat-user-item d-flex align-items-center text-decoration-none text-dark p-4 border-bottom hover-bg-light <?php echo e($user->id == $receiver->id ? 'active' : ''); ?>">
                                    <div class="me-3 position-relative">
                                        <?php if($user->photo): ?>
                                            <img src="<?php echo e(asset('storage/' . $user->photo)); ?>" alt="<?php echo e($user->name); ?>" class="rounded-circle shadow-sm" width="64" height="64" style="object-fit: cover;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/img/default-avatar.png')); ?>" alt="No Profile" class="rounded-circle shadow-sm" width="64" height="64">
                                        <?php endif; ?>
                                    </div>    
                                    <div class="flex-grow-1 min-width-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="mb-0 text-truncate fw-bold" style="font-size: 1.35rem;"><?php echo e($user->name); ?></h5>
                                            <small class="text-muted" style="font-size: 1.1rem;"><?php echo e($user->phone ?? 'No Phone'); ?></small>
                                        </div>
                                        <p class="text-muted mb-0 text-truncate" style="font-size: 1.15rem;">
                                            <?php if(isset($user->lastMessage)): ?>
                                                <?php echo e($user->lastMessage->sender_id === auth()->id() ? 'You: ' : $user->name . ': '); ?>

                                                <?php echo e(Str::limit($user->lastMessage->message, 25)); ?>

                                            <?php else: ?>
                                                <?php echo e($user->latestMessage ? ($user->latestMessage->sender_id === auth()->id() ? 'You: ' : $user->name . ': ') . Str::limit($user->latestMessage->message, 25) : 'No messages yet'); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    
                    <!-- Chat Window -->
                    <div class="col-md-6 col-lg-8 d-flex flex-column" style="height: 100%; overflow: hidden;">
                        <!-- Chat Header -->
                        <div class="chat-header bg-white border-bottom p-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <?php if($receiver->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $receiver->photo)); ?>" alt="<?php echo e($receiver->name); ?>" class="rounded-circle shadow-sm" width="64" height="64" style="object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('assets/img/default-avatar.png')); ?>" alt="No Profile" class="rounded-circle shadow-sm" width="64" height="64">
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold" style="font-size: 1.3rem;"><?php echo e($receiver->name); ?></h5>
                                    <p class="mb-0 text-muted" style="font-size: 1.1rem;"><?php echo e($receiver->phone ?? 'No Phone Number'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div class="chat-body flex-grow-1 p-4" style="background-color: #f8f9fa; overflow-y: auto;">
                            <div class="chat-messages" style="display: flex; flex-direction: column;">
                                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="chat-bubble mb-3 <?php echo e($message->sender_id === auth()->id() ? 'chat-bubble-me ms-auto' : ''); ?>" 
                                         style="max-width: 80%; width: fit-content; <?php echo e($message->sender_id === auth()->id() ? 'background-color: #206bc4; color: white;' : 'background-color: #fff;'); ?>">
                                        <div class="chat-bubble-body">
                                            <?php echo e($message->message); ?>

                                        </div>
                                        <div class="chat-bubble-footer mt-2">
                                            <small class="<?php echo e($message->sender_id === auth()->id() ? 'text-white-50' : 'text-muted'); ?>">
                                                <?php echo e($message->created_at->format('M d, Y h:i A')); ?>

                                            </small>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Chat Input -->
                        <div class="chat-footer bg-white border-top p-3">
                            <form method="POST" action="<?php echo e(route('messages.send', $receiver->id)); ?>" class="m-0">
                                <?php echo csrf_field(); ?>
                                <div class="input-group input-group-lg">
                                    <input type="text" name="message" class="form-control border-0" placeholder="Type your message..." style="font-size: 1.2rem;" required>
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

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to bottom of chat
        const chatBody = document.querySelector('.chat-body');
        if (chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        // Focus the input field
        const messageInput = document.querySelector('input[name="message"]');
        if (messageInput) {
            messageInput.focus();
        }

        // Message search functionality
        const searchFeedback = document.getElementById('searchFeedback');
        const searchUser = document.getElementById('searchUser');
        const messageSearch = document.getElementById('messageSearch');
        const chatUserItems = document.querySelectorAll('.chat-user-item');

        messageSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            chatUserItems.forEach(item => {
                const userName = item.querySelector('h5').textContent.toLowerCase();
                
                if (userName.includes(searchTerm)) {
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
    .chat-bubble {
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .chat-bubble-me {
        border-bottom-right-radius: 0.25rem;
    }
    .chat-bubble:not(.chat-bubble-me) {
        border-bottom-left-radius: 0.25rem;
    }
    .chat-messages {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/message/chat.blade.php ENDPATH**/ ?>