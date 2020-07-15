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
            post: {},
            newComment: {
                post_id: this.postId
            },
            comments: [],
        }
    },
    methods: {
        fetchPost() {
            axios.get(postShowURL + this.postId)
                .then((res) => {
                    this.post = res.data.post;
                    this.comments = res.data.comments;
                });
        },
        submitComment() {
            axios.post(commentStoreURL, this.newComment)
                .then((res) => {
                    this.newComment.body = '';
                    this.fetchPost();
                });
        },
        deleteComment(id) {
            axios.delete(commentDestroyURL + id)
                .then((res) => {
                    this.fetchPost();
                });
        }
    },
    mounted() {
        this.fetchPost();
    }
}
</script>

<style scoped>
textarea {
    resize: none;
    height: 100%;
    width: 100%;
    border: none;
    padding: 0.5em;
    overflow: hidden;
}

.card {
    height: 12.0rem;
}

.btn-submit {
    bottom: 15px;
    right: 15px;
}

.link-delete {
    right: 20px;
    bottom: 20px;
}
</style>
