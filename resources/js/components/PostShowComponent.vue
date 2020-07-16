<template>
<div class="container">
    <div v-if="loadingPost" class="spinner-post text-center">
        <div class="spinner-border text-secondary mt-5" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <template v-else>
        <div class="row">
            <div class="col-12 col-sm-4 img-wrapper text-center mb-4 mb-sm-0" v-if="post.thumbnail">
                <img class="img-fluid img-thumbnail" v-bind:src="post.thumbnail">
            </div>
            <div class="col-12" v-bind:class=" post.thumbnail ? 'col-md-8' : '' ">
                <div class="post">
                    <h3 class="post-title">{{ post.title }}</h3>
                    <p class="post-body">{{ post.body }}</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <hr>
            </div>
        </div>
    </template>
    <template v-if="errors">
        <div class="alert alert-warning" role="alert">
            <ul class="mb-0">
                <template v-for="error in errors">
                    <li v-for="message in error" v-bind:key="message">
                        {{ message }}
                    </li>
                </template>
            </ul>
        </div>
    </template>
    <div v-if="loadingComment" class="spinner-comment text-center mt-5">
        <div class="spinner-grow text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-danger" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-warning" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-dark" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <template v-else>
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                <div class="card position-relative">
                    <div class="card-body">
                        <form v-on:submit.prevent="submitComment()">
                            <textarea name="body" rows="4" v-model="formComment.body"></textarea>
                            <button type="submit" class="btn btn-primary btn-submit position-absolute">
                                コメントを書く
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3 mb-4" v-for="comment in comments" v-bind:key="comment.id">
                <div class="card position-relative">
                    <div class="card-body">
                        <p class="comment-body">{{ comment.body }}</p>
                        <a href="#" class="link-delete position-absolute" v-on:click="deleteComment(comment.id)">
                            コメントを消す
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
</template>

<script>
const postShowURL = '/laravel-news-spa/api/posts/';
const commentStoreURL = '/laravel-news-spa/api/comments';
const commentDestroyURL = '/laravel-news-spa/api/comments/';

export default {
    props: {
        postId: String
    },
    data: function() {
        return {
            loadingPost: false,
            loadingComment: false,
            errors: null,
            post: {},
            formComment: {
                post_id: this.postId,
                body: ''
            },
            comments: [],
        }
    },
    methods: {
        fetchPost() {
            if (!Object.keys(this.post).length) {
                this.loadingPost = true;
            }

            this.loadingComment = true;

            axios.get(postShowURL + this.postId)
                .then((res) => {
                    this.errors = null;
                    this.post = res.data.post;
                    this.comments = res.data.comments;

                    this.loadingPost = false;
                    this.loadingComment = false;
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };

                    this.loadingPost = false;
                    this.loadingComment = false;
                });
        },
        submitComment() {
            if (this.checkForm() === false) {
                return;
            }

            this.loadingComment = true;

            axios.post(commentStoreURL, this.formComment)
                .then((res) => {
                    this.formComment.body = '';

                    this.fetchPost();
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };

                    this.loadingComment = false;
                });
        },
        deleteComment(id) {
            this.loadingComment = true;

            axios.delete(commentDestroyURL + id)
                .then((res) => {
                    this.fetchPost();
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };

                    this.loadingComment = false;
                });
        },
        checkForm() {
            const existBody = !!this.formComment.body;
            const isBodyValidLength = this.formComment.body.length <= 50;

            this.errors = {
                body: []
            }

            if (!existBody) {
                this.errors.body.push('コメントは必須です。');
            }

            if (!isBodyValidLength) {
                this.errors.body.push('コメントは50文字以下です。');
            }

            if (!existBody || !isBodyValidLength) {
                return false;
            }

            this.errors = null;

            return true;
        }
    },
    mounted() {
        this.fetchPost();0
    }
}
</script>

<style scoped>
.spinner-post {
    height: 300px;
}

.post-body,
.comment-body {
    white-space: pre;
}

textarea {
    resize: none;
    height: 100%;
    width: 100%;
    border: none;
    padding: 0.5em;
    overflow: hidden;
}

textarea:focus {
    outline: none;
}

.card {
    height: 12.0rem;
}

.btn-submit {
    right: 15px;
    bottom: 15px;
}

.link-delete {
    right: 20px;
    bottom: 20px;
}

.img-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
