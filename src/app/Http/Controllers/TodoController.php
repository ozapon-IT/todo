<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('index', compact('todos'));
    }

    public function store(Request $request)
    {
        $todo = $request->only(['content']);
        Todo::create($todo);

        // todoの内容をメッセージとして送る時
        // $message = $todo['content'];
        // $todos = Todo::all();
        // return view('index', compact('message', 'todos'));

        // withメソッドでセッション一時保存(フラッシュセッション)
        return redirect('/')->with('message', 'Todoを作成しました');
    }
}
