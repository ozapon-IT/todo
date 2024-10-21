<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Http\Requests\TodoRequest;
use App\Models\Category;

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
        // ユーザー入力をバリデーションで検証する
        $request->validated();

        // カテゴリ名を取得
        $categoryName = $request->input('name');

        // カテゴリを取得または新規作成
        $category = Category::firstOrCreate(['name' => $categoryName]);

        // Todoを作成
        Todo::create([
            'content' => $request->input('content'),
            'category_id' => $category->id,
        ]);

        return redirect('/')->with('message', 'Todoを作成しました');
    }

    // todo更新時
    public function update(TodoRequest $request)
    {
        // ユーザー入力をバリデーションで検証する
        $request->validated();

        // カテゴリ名を取得
        $categoryName = $request->input('name');

        // カテゴリを取得または新規作成
        $category = Category::firstOrCreate(['name' => $categoryName]);

        // Todoを更新
        $todo = Todo::find($request->id);
        $todo->content = $request->input('content');
        $todo->category_id = $category->id;
        $todo->save();


        return redirect('/')->with('message', 'Todoを更新しました');
    }

    // todo削除時
    public function destroy(Request $request)
    {
        Todo::find($request->id)->delete();

        return redirect('/')->with('message', 'Todoを削除しました');
    }

    // todo検索時
    public function search(Request $request)
    {
        // ユーザー入力をバリデーションで検証する
        $messages = [
            'content.string' => 'Todoは文字列で入力してください',
            'content.max' => 'Todoは20文字以下で入力してください',
            'name.string' => 'カテゴリは文字列で入力してください',
            'name.max' => 'カテゴリは10文字以下で入力してください',
        ];

        $validatedData = $request->validate([
            'content' => 'nullable|string|max:20',
            'name' => 'nullable|string|max:10',
        ], $messages);

        // バリデーションに通ったデータのみを使用する
        $contentInput = $validatedData['content'] ?? null;
        $nameInput = $validatedData['name'] ?? null;


        // 検索条件がない場合、空の結果を返す
        if (!$contentInput && !$nameInput) {
            return view('index', ['todos' => collect()]);
        }

        // クエリビルダの初期化とEager Lodingの指定
        $query = Todo::with('category');

        // contentの条件を追加
        if ($contentInput) {
            $query->where('content', 'LIKE', '%' . $contentInput . '%');
        }

        // categoryの条件を追加
        if ($nameInput) {
            $query->whereHas('category', function ($q) use ($nameInput) {
                $q->where('name', 'LIKE', '%' . $nameInput  . '%');
            });
        }

        // 結果を取得
        $todos = $query->get();

        return view('index', compact('todos'));
    }
}
