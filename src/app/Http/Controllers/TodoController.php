<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Http\Requests\TodoRequest;

class TodoController extends Controller
{
    // トップページ表示
    public function index()
    {
        $todos = Todo::all();
        return view('index', compact('todos'));
    }

    // todo作成時
    public function store(TodoRequest $request)
    {
        $todo = $request->only(['content']);
        Todo::create($todo);

        return redirect('/')->with('message', 'Todoを作成しました');
    }

    // todo更新時
    public function update(TodoRequest $request)
    {
        $todo = $request->only(['content']);
        Todo::find($request->id)->update($todo);

        return redirect('/')->with('message', 'Todoを更新しました');
    }
}
