@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="todo__alert">
  {{-- フラッシュセッション --}}
  @if (session('message'))
  <div class="todo__alert--success">
    {{ session('message') }}
  </div>
  @endif
  {{-- バリデーションエラー --}}
  @if ($errors->any())
  <div class="todo__alert--danger">
    <ul class="todo__alert--danger-list">
      @foreach ($errors->all() as $error)
      <li class="todo__alert--danger-list__item">
        {{ $error }}
      </li>
      @endforeach
    </ul>
  </div>
  @endif
</div>

<div class="todo__content">
  <h2 class="form__title">
    新規作成
  </h2>
  <form class="create-form" action="/todos" method="post">
    @csrf
    <div class="create-form__item">
      <input class="create-form__item-input" type="text" name="content" />
    </div>
    <div class="create-form__category">
      <input class="create-form__category-input" type="text" name="name" placeholder="カテゴリ" />
    </div>
    <div class="create-form__button">
      <button class="create-form__button-submit" type="submit">作成</button>
    </div>
  </form>

  <h2 class="form__title">
    Todo検索
  </h2>
  <form class="search-form" action="/todos/search" method="get">
    @csrf
    <div class="search-form__item">
      <input class="search-form__item-input" type="text" name="content" />
    </div>
    <div class="search-form__category">
      <input class="search-form__category-input" type="text" name="name" placeholder="カテゴリ" />
    </div>
    <div class="search-form__button">
      <button class="search-form__button-submit" type="submit">検索</button>
    </div>
  </form>

  <div class="todo-table">
    <table class="todo-table__inner">
      <tr class="todo-table__row">
        <th class="todo-table__header">Todo</th>
        <th class="todo-table__header">カテゴリ</th>
      </tr>
      @forelse ($todos as $todo)
      <tr class="todo-table__row">
        <form class="update-form" action="/todos/update" method="post">
          @method('PATCH')
          @csrf
          <td class="todo-table__item">
            <div class="update-form__item">
              <input class="update-form__item-input" type="text" name="content" value="{{ $todo['content'] }}">
              <input type="hidden" name="id" value="{{ $todo['id'] }}">
            </div>
          </td>
          <td class="todo-table__item">
            <div class="update-form__item">
              <input class="update-form__item-input" type="text" name="name" value="{{ $todo->category->name }}">
            </div>
          </td>
          <td class="todo-table__item">
            <div class="update-form__button">
              <button class="update-form__button-submit" type="submit">更新</button>
            </div>
          </td>
        </form>
        <td class="todo-table__item">
          <form class="delete-form" action="/todos/delete" method="post">
            @method('DELETE')
            @csrf
            <div class="delete-form__button">
              <input type="hidden" name="id" value="{{ $todo['id'] }}">
              <button class="delete-form__button-submit" type="submit">削除</button>
            </div>
          </form>
        </td>
      </tr>
      @empty
      <tr class="todo-table__row">
        <td class="todo-table__item">
          <p>該当するTodoはありません</p>
        </td>
        <td class="todo-table__item"></td>
        <td class="todo-table__item"></td>
        <td class="todo-table__item"></td>
      </tr>
      @endforelse
    </table>
  </div>
</div>
@endsection