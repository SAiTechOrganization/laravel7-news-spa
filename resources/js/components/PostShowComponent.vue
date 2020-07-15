<template>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="post">
                <h3 class="post-title">{{ post.title }}</h3>
                <p class="post-body">{{ post.body }}</p>
            </div>
            <hr>
        </div>
    </div>
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
    <div class="row">
        <div class="col-xs-12 col-md-4 col-lg-3 mb-4">
            <div class="card position-relative">
                <div class="card-body">
                    <form v-on:submit.prevent="submitComment()">
                        <textarea name="body" rows="4" v-model="newComment.body"></textarea>
                        <button type="submit" class="btn btn-primary btn-submit position-absolute">
                            コメントを書く
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 col-lg-3 mb-4" v-for="comment in comments" v-bind:key="comment.id">
            <div class="card position-relative">
                <div class="card-body">
                    <p>{{ comment.body }}</p>
                    <a href="#" class="link-delete position-absolute" v-on:click="deleteComment(comment.id)">
                        コメントを消す
                    </a>
                </div>
            </div>
        </div>
    </div>
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
            errors: null,
            post: {},
            newComment: {
                post_id: this.postId,
                body: ''
            },
            comments: [],
        }
    },
    methods: {
        fetchPost() {
            axios.get(postShowURL + this.postId)
                .then((res) => {
                    this.errors = null;
                    this.post = res.data.post;
                    this.comments = res.data.comments;
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };
                });
        },
        submitComment() {
            if (this.checkForm() === false) {
                return;
            }

            axios.post(commentStoreURL, this.newComment)
                .then((res) => {
                    this.newComment.body = '';

                    this.fetchPost();
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };
                });
        },
        deleteComment(id) {
            axios.delete(commentDestroyURL + id)
                .then((res) => {
                    this.fetchPost();
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };
                });
        },
        checkForm() {
            const existBody = !!this.newComment.body;
            const isBodyValidLength = this.newComment.body.length <= 50;

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
.post-body {
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
</style>
