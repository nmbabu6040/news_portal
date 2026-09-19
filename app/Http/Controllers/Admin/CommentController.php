<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('article')->latest()->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('status', 'মন্তব্য অনুমোদিত হয়েছে');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('status', 'মন্তব্য ডিলিট হয়েছে');
    }
}
