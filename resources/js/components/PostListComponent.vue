<template>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12 mb-4">
            <h3>さぁ、最新のニュースを<span class="break-xs"><br></span>シェアしましょう</h3>
        </div>
        <div class="col-xs-12 col-md-12">
            <div v-if="errors" class="row">
                <div class="col-md-2 col-lg-2"></div>
                <div class="col-xs-12 col-md-9 col-lg-6 ml-2 mr-2 pl-0 pr-0">
                    <div class="alert alert-warning" role="alert">
                        <ul class="mb-0">
                            <template v-for="error in errors">
                                <li v-for="message in error" v-bind:key="message">
                                    {{ message }}
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
            <form v-on:submit.prevent="confirmPost()">
                <div class="row form-group mb-2">
                    <label for="title" class="col-xs-12 col-md-2  col-lg-2 label-title">タイトル</label>
                    <input type="text" class="col-xs-12 col-md-9 col-lg-6 form-control ml-2 mr-2"
                           id="title" v-model="post.title">
                </div>
                <div class="row form-group mb-2">
                    <label for="body" class="col-xs-12 col-md-2 col-lg-2 label-body">記事</label>
                    <textarea class="col-xs-12 col-md-9 col-lg-6 form-control ml-2 mr-2"
                              id="body" rows="4" v-model="post.body">
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
    <div v-if="loading" class="text-center">
        <div class="spinner-border text-secondary mt-5" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <template v-else>
        <div class="row" v-for="post in posts" v-bind:key="post.id">
            <div class="col-xs-12 col-md-12">
                <div class="post">
                    <h3 class="post-title">{{ post.title }}</h3>
                    <p class="post-body">{{ post.body }}</p>
                    <router-link v-bind:to="{ name: 'post.show', params: { postId: post.id.toString() } }">
                        <span>記事全文・コメントを見る</span>
                    </router-link>
                </div>
                <hr>
            </div>
        </div>
    </template>

    <div class="modal fade" id="confirm-post" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">確認</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    投稿してよろしいですか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
                    <button type="button" class="btn btn-success" id="btn-post" name="btn-post"
                            v-on:click="submitPost()">
                         はい
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
const postIndexURL = '/laravel-news-spa/api/posts/';
const postStoreURL = '/laravel-news-spa/api/posts';

export default {
    data: function() {
        return {
            loading: false,
            errors: null,
            post: {
                title: '',
                body: ''
            },
            posts: []
        }
    },
    methods: {
        fetchPosts() {
            this.loading = true;

            axios.get(postIndexURL)
                .then((res) => {
                    this.errors = null;
                    this.posts = res.data;

                    this.loading = false;
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };

                    this.loading = false;
                });

        },
        confirmPost() {
            if (this.checkForm() === false) {
                return;
            }

            // NOTE: アニメーションを使用しないため,フェード・イン効果を出すためにjQueryを利用
            $('#confirm-post').modal('show');
        },
        submitPost() {
            // NOTE: アニメーションを使用しないため,フェード・アウト効果を出すためにjQueryを利用
            $('#confirm-post').modal('hide');

            axios.post(postStoreURL, this.post)
                .then((res) => {
                    this.post.title = '';
                    this.post.body = '';

                    this.fetchPosts();
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };
                });;
        },
        checkForm() {
            const existTitle = !!this.post.title;
            const isTitleValidLength = this.post.title.length <= 30;
            const existBody = !!this.post.body;

            this.errors = {
                title: [],
                body: []
            }

            if (!existTitle) {
                this.errors.title.push('タイトルは必須です。');
            }

            if (!isTitleValidLength) {
                this.errors.title.push('タイトルは30文字以下です。');
            }

            if (!existBody) {
                this.errors.body.push('記事は必須です。');
            }

            if (!existTitle || !isTitleValidLength || !existBody) {
                return false;
            }

            this.errors = null;

            return true;
        }
    },
    mounted() {
        this.fetchPosts();
    }
}
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

.post-body {
    padding-right: 1.0rem;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
</style>
