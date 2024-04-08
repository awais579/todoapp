<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string']

        ]);

        $user_id = auth()->id();
        $category = new Category;
        $category->name = $request->input('name');
        $category->user_id = $user_id;
        $category->save();


        return redirect('view_category');
    }

    public function seeCategory()
    {
        $categories = Category::all();

        return redirect('view_task')->with('categories');

    }

    public function gettasks(Request $request)
    {
        return response()->json(Task::all());
    }

    public function addTask(Request $request)
    {

        $validate = $request->validate([
            'description' => ['required'],
            'priority' => ['required', 'in:low,medium,high'],
            'category' => ['required', 'exists:categories,name'],
            'parent_id' => ['required'],
            'due_date' => ['required', 'date'],
        ]);
        $user_id = auth()->id();
        $task = new Task;

        $jsonData = Category::first('id');
        $data = json_decode($jsonData, true);

        $id = $data['id'];
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
        $task->category = $request->input('category');
        $task->parent_id = $id;
        $task->user_id = $user_id;
        $task->due_date = $request->input('due_date');
        $task->save();
        return redirect('/view_task');

    }
    public function viewTask()
    {
        $categories = Category::all();

        return view('dashboard', compact('categories'));

    }

    public function deleteTask($id)
    {
        $deleteTask = Task::find($id);
        if ($deleteTask) {
            $deleteTask->delete();
            return redirect('view_task');
        }

    }
    public function editTasks($id)
    {
        $tasks = Task::find($id);
        return view('editTask', compact('tasks'));
    }

    public function saveEditis(Request $request, $id)
    {
        // $validation = [
        //     'description' =>'required|string',
        //     'priority'    =>'required|string',
        //     'category'    =>'required|string',
        //     'category'    =>'required|string',
        // ]

        $task = Task::where('id', $id)->first();
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
        $task->category = $request->input('category');
        $task->due_date = $request->input('due_date');
        $task->update();

        return redirect('view_task');
    }
    public function filter(Request $request)
    {

        $category = $request->category;
        $priority = $request->priority;
        $data = Task::where('priority', $priority)->where('category', $category)->get();

        return response()->json($data);


    }
    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $taskStatus = $request->taskStatus;
        $task = Task::find($id);
        $task->status = $taskStatus ? 'complete' : 'uncomplete';
        $task->save();

        $task = Task::all();
        return redirect()->back()->with('Task Updated Successfully');
    }

}

