<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $auth = Auth::user();
        $task = Task::where('user_id', $auth->id)->get();

        return response()->json([
            'task' => $task,
        ], 201);
    }

    public function trash(){
        $auth = Auth::user();
        $task = Task::where('user_id', $auth->id)->onlyTrashed()->get();

        return response()->json([
            'task' => $task,
        ], 201);
    }

    public function store(TaskRequest $request){
        $auth = Auth::user();

        $attachments = [];
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public');
                $size = $file->getSize();
                $attachments[] = [
                    'name' => $originalName,
                    'size' => $size,
                    'path' => $path
                ];
            }
        }

        $task = Task::create([
            'user_id' => $auth->id,
            'title' => $request->title,
            'content' => $request->content,
            'attachment' => json_encode($attachments),
            'subtask' => $request->subtask,
            'status' => $request->status,
            'is_published' => $request->is_published,
        ]);

        return response()->json([
            'task' => $task,
        ], 201);
    }

    public function show($id){
        $task = Task::where('id', $id)->withTrashed()->first();

        return response()->json([
            'task' => $task
        ], 201);
    }

    public function update(TaskRequest $request, $id){
        $auth = Auth::user();
        $task = Task::find($id);

        $attachments = [];
        $existingAttachment = json_decode($task->attachment);
        for ($i = 0; $i < count($existingAttachment); $i++) {
            $attachments[] = [
                'name' => $existingAttachment[$i]->name,
                'size' => $existingAttachment[$i]->size,
                'path' => $existingAttachment[$i]->path
            ];
        }

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public');
                $size = $file->getSize();
                $attachments[] = [
                    'name' => $originalName,
                    'size' => $size,
                    'path' => $path
                ];
            }
        }

        $task->update([
            'user_id' => $auth->id,
            'title' => $request->title,
            'content' => $request->content,
            'attachment' => json_encode($attachments),
            'subtask' => $request->subtask,
            'status' => $request->status,
            'is_published' => $request->is_published,
        ]);

        return response()->json([
            'task' => $task,
        ], 201);
    }

    public function delete($id){
        $task = Task::find($id);
        $task->delete();

        return response()->json([
            'task' => $task,
        ], 201);
    }

    public function deleteImage(Request $request, $id){
        $task = Task::find($id);

        $updatedAttactment = [];
        $attachment = json_decode($task->attachment);
        for ($i = 0; $i < count($attachment); $i++) {
            if($i != $request->deletedIndex){
                $updatedAttactment[] = [
                    'name' => $attachment[$i]->name,
                    'size' => $attachment[$i]->size,
                    'path' => $attachment[$i]->path
                ];
            }
        }

        $task->update([
            'attachment' => json_encode($updatedAttactment)
        ]);

        return response()->json([
            'task' => $task,
        ], 201);
    }

    public function deleteSubtask(Request $request, $id){
        $task = Task::find($id);

        $updatedSubtask = [];
        $subtask = json_decode($task->subtask);
        for ($i = 0; $i < count($subtask); $i++) {
            if($i != $request->deletedIndex){
                $updatedSubtask[] = [
                    'name' => $subtask[$i]->name,
                    'is_done' => $subtask[$i]->is_done
                ];
            }
        }

        $task->update([
            'subtask' => json_encode($updatedSubtask)
        ]);

        return response()->json([
            'task' => $task,
        ], 201);
    }
}
