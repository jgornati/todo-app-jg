<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isEmpty;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Task::orderBy('created_at', 'desc')->where([["deleted", false]])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Task
     */
    public function store(Request $request): Task
    {
//        $newTask = new Task;
//        $newTask->title = $request->task['title'];
//        $newTask->save();
//        return $newTask;
        return Task::create($request->task);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Task
     * @package $int $id
     */
    public function update(Request $request, $id): Task
    {
        //
        $task = Task::find($id);
        $task->fill($request->task);
        $task->save();

        return $task;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int|null $id
     * @return Task|\Illuminate\Database\Eloquent\Collection
     */
    public function destroy(Request $request, int $id = null): \Illuminate\Database\Eloquent\Collection|Task|array
    {

        if ($id !== null) {
            $task = Task::find($id);;
            $task->deleted = !$task->deleted;
            $task->save();
            return $task;
        } else {
            $requestTasks = $request->tasks;
            Log::info($requestTasks);
            $tasks = [];
            if ($requestTasks !== null)
                foreach ($requestTasks as $requestTask) {
                    $task = Task::find($requestTask['id']);
                    if ($task !== null) {
                        $task->deleted = !$task->deleted;
                        $task->save();
                    }
                    $tasks[] = $task;
                }
            else {
                $tasks = Task::where([["deleted", false]])->get();
                foreach ($tasks as $task) {
                    $task->deleted = 1;
                    $task->save();
                }
            }

            return $tasks;
        }

    }
}
