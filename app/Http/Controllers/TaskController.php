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
        $task = Task::all();

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
                $path = $file->store('public/uploads');
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
            'status' => $request->status,
            'is_published' => $request->is_published,
        ]);

        return response()->json([
            'task' => $task,
        ], 201);
    }

    public function show($id){
        $task = Task::find($id);

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
                $path = $file->store('public/uploads');
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
            'task' => $updatedAttactment,
        ], 201);
    }
}
