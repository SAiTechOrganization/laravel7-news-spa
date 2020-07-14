<template>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12 mb-4">
            <h3>さぁ、最新のニュースを<span class="break-xs"><br></span>シェアしましょう</h3>
        </div>
        <div class="col-xs-12 col-md-12">
            <form>
                <div class="row form-group mb-2">
                    <label for="title" class="col-xs-12 col-md-2  col-lg-2 label-title">タイトル</label>
                    <input type="text" class="col-xs-12 col-md-9 col-lg-6 form-control ml-2 mr-2"
                           id="title">
                </div>
                <div class="row form-group mb-2">
                    <label for="body" class="col-xs-12 col-md-2 col-lg-2 label-body">記事</label>
                    <textarea class="col-xs-12 col-md-9 col-lg-6 form-control ml-2 mr-2" id="body" rows="4">
                    </textarea>
                </div>
                <div class="row">
                    <div class="offset-md-2"></div>
                    <button type="submit" class="col-xs-12 col-md-9 col-lg-6 btn btn-primary mb-2 ml-2 mr-2">
                        投&emsp;稿
                    </button>
                </div>
            </form>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="post">
                <h3 class="post-title">タイトル1</h3>
                <p class="post-body">ボディ1</p>
                <a href="#">記事全文・コメントを見る</a>
            </div>
            <hr>
        </div>
    </div>
</div>
</template>

<script>
    export default {}
</script>

<style scoped>
@media (min-width: 576px) {
    .break-xs {
        display: none;
    }
}

.label-title {
    padding-top: 0.3rem;
}

textarea {
    resize: none;
}
</style>
