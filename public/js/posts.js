let formPost = document.getElementById('formPost');

formPost.addEventListener('submit', function(event) {
    if (window.confirm('投稿してよろしいですか？')) {
        return true;
    }

    event.stopPropagation();
    event.preventDefault();

    window.alert('キャンセルしました。');

    return false;
});
