<template>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="post">
                <h3 class="post-title">タイトル1</h3>
                <p class="post-body">ボディ1</p>
            </div>
            <hr>
        </div>
    </div>
    <section class="comments">
        <div class="form-comment">
            <form>
                <div class="input-body">
                    <textarea name="body" class="post-it post-it-blue"></textarea>
                    <button type="submit" class="btn-submit mb-2 ml-2 mr-2">
                        コメントを書く
                    </button>
                </div>
            </form>
        </div>
        <form class="comment">
            <div class="input-body">
                <div class="post-it post-it-blue">コメントサンプル</div>
                <button type="submit" class="btn-submit mb-2 ml-2 mr-2">
                    コメントを消す
                </button>
            </div>
        </form>
        <form class="comment">
            <div class="input-body">
                <div class="post-it post-it-blue">コメントサンプル</div>
                <button type="submit" class="btn-submit mb-2 ml-2 mr-2">
                    コメントを消す
                </button>
            </div>
        </form>
        <form class="comment">
            <div class="input-body">
                <div class="post-it post-it-blue">コメントサンプル</div>
                <button type="submit" class="btn-submit mb-2 ml-2 mr-2">
                    コメントを消す
                </button>
            </div>
        </form>
        <form class="comment">
            <div class="input-body">
                <div class="post-it post-it-blue">コメントサンプル</div>
                <button type="submit" class="btn-submit mb-2 ml-2 mr-2">
                    コメントを消す
                </button>
            </div>
        </form>
    </section>
</div>
</template>

<script>
export default {
    props: {
        postId: String
    },
    data: function() {
        return {
            color: 'blue' // ランダムに抽出する ['red', 'blue', 'yellow']
        }
    },
    mounted() {
        console.log(this.postId);
    }
}
</script>

<style scoped>
textarea {
    resize: none;
}

.form-comment .input-body,
.comment .input-body {
    display: inline-block;
    position: relative;
    margin-left: 1.0rem;
}

.form-comment .post-it,
.comment .post-it {
    resize: none;
    height: 10.0rem;
    width: 11.5rem;
    margin-top: 30px;
    margin-left: 20px;
    border: none;
    padding: 1.0em;
    overflow: hidden;
    box-shadow: 0 .5rem 0.5rem hsla(0, 0%, 0%, .1);
    font-size: 0.9rem;
    line-height: 1.8;
}

.form-comment .post-it-blue,
.comment .post-it-blue {
    background-image:
        linear-gradient(180deg, hsla(0, 0%, 45%, .1) 2rem, hsla(0, 100%, 100%, 0) 2.5rem),
        linear-gradient(180deg, hsla(200, 100%, 85%, 1), hsla(200, 100%, 85%, 1));
}

.form-comment .post-it-red,
.comment .post-it-red {
    background-image:
        linear-gradient(180deg, hsla(0, 0%, 45%, .1) 2rem, hsla(0, 100%, 100%, 0) 2.5rem),
        linear-gradient(180deg, hsla(15, 100%, 85%, 1), hsla(15, 100%, 85%, 1));
}

.form-comment .post-it-yellow,
.comment .post-it-yellow {
    background-image:
        linear-gradient(180deg, hsla(0, 0%, 45%, .1) 2rem, hsla(0, 100%, 100%, 0) 2.5rem),
        linear-gradient(180deg, hsla(60, 100%, 85%, 1), hsla(60, 100%, 85%, 1));
}

.form-comment .btn-submit {
	position: absolute;
	right: 10px;
	bottom: 10px;
    display: inline-block;
    padding: 0.5em 1em;
    text-decoration: none;
    background: #f2fcff;
    border: dashed 1px #67c5ff;
    border-radius: 3px;
    transition: .4s;
}

.form-comment .btn-submit:hover {
    border-style: dotted;
    color: #679efd;
}

.comments {
    display: flex;
    flex-wrap: wrap;
}

.comment .btn-submit {
	position: absolute;
	right: 10px;
	bottom: 10px;
    display: inline-block;
    padding: 0.5em 1em;
    color: blue;
    text-decoration: underline;
    background: none;
    border: none;
}

.comment .btn-submit:hover {
    color: red;
}
</style>
