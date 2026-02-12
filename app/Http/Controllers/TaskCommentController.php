<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskCommentController extends Controller
{
    public function store(Request $request, Project $project, Task $task)
    {
        abort_unless($task->project_id === $project->id, 404);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $comment = TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'body'    => $data['body'],
        ]);

        // ✅ Aktivite log
        log_activity('comment.created', $task, [
            'comment_id' => $comment->id,
            'body'       => $comment->body,
        ]);

        return back()->with('success', 'Yorum eklendi.');
    }

    public function update(Request $request, Project $project, Task $task, TaskComment $comment)
    {
        abort_unless($task->project_id === $project->id, 404);
        abort_unless($comment->task_id === $task->id, 404);
        abort_unless($comment->user_id === Auth::id(), 403); // sadece yorum sahibi

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $oldBody = $comment->body;

        $comment->update([
            'body' => $data['body'],
        ]);

        // ✅ Aktivite log
        log_activity('comment.updated', $task, [
            'comment_id' => $comment->id,
            'old_body'   => $oldBody,
            'new_body'   => $comment->body,
        ]);

        return back()->with('success', 'Yorum güncellendi.');
    }

    public function destroy(Project $project, Task $task, TaskComment $comment)
    {
        abort_unless($task->project_id === $project->id, 404);
        abort_unless($comment->task_id === $task->id, 404);
        abort_unless($comment->user_id === Auth::id(), 403); // sadece yorum sahibi

        $commentId = $comment->id;
        $body = $comment->body;

        $comment->delete();

        // ✅ Aktivite log
        log_activity('comment.deleted', $task, [
            'comment_id' => $commentId,
            'body'       => $body,
        ]);

        return back()->with('success', 'Yorum silindi.');
    }
}
