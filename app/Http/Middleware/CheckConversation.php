<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;

class CheckConversationAccess
{
    public function handle($request, Closure $next)
    {
        $conversation = Conversation::find($request->route('conversation'));

        if ($conversation && $conversation->participants()->where('user_id', Auth::id())->exists()) {
            return $next($request);
        }

        abort(403, 'Unauthorized access to this conversation');
    }
}
