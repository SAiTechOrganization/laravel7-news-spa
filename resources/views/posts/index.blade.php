<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SAi Tech News</title>

    <link rel="stylesheet" href="{{ asset('/css/posts.css') }}">
</head>
<body>
    <nav class="main-header">
      <div class="nav-bar">SAi Tech News</div>
    </nav>
    <section class="form-post">
        <h2 class="content-header">あなたのニュースをシェアしませんか？</h2>
        {{ Form::open(['route' => 'posts.store']) }}
            <div class="input-title">
                {{ Form::label('title', 'タイトル：') }}
                {{ Form::input('text', 'title') }}
            </div>
            <div class="input-body">
                {{ Form::label('body', '記事：') }}
                {{ Form::textarea('body') }}
            </div>
            <div class="input-submit">
                {{ Form::submit('投稿', ['class' => 'btn-submit']) }}
            </div>
        {{ Form::close() }}
    </section>
    <hr>
    <section class="posts">
        @foreach ($posts as $post)
            <div class="post">
                <h3 class="post-title">{{ $post->title }}</h3>
                <p class="post-body">{{ $post->body }}</p>
                {{ Html::linkRoute('posts.index', '記事全文・コメントを見る') }}
            </div>
            <hr>
        @endforeach
    </section>
    <script src="{{ asset('/js/posts.js') }}"></script>
</body>
</html>
