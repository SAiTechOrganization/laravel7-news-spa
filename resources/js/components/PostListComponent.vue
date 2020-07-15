<template>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12 mb-4">
            <h3>さぁ、最新のニュースを<span class="break-xs"><br></span>シェアしましょう</h3>
        </div>
        <div class="col-xs-12 col-md-12">
            <form v-on:submit.prevent="submitPost()">
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
    <div class="row" v-for="post in posts" v-bind:key="post.id">
        <div class="col-xs-12 col-md-12">
            <div class="post">
                <h3 class="post-title">{{ post.title }}</h3>
                <p class="post-body">{{ post.body }}</p>
                <router-link v-bind:to="{ name: 'post.show', params: { postId: post.id.toString() } }">
                    <p>記事全文・コメントを見る</p>
                </router-link>
            </div>
            <hr>
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
            post: {},
            posts: []
        }
    },
    methods: {
        fetchPosts() {
            axios.get(postIndexURL)
                .then((res) => {
                    this.posts = res.data;
                });
        },
        submitPost() {
            axios.post(postStoreURL, this.post)
                .then((res) => {
                    this.fetchPosts();
                });
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
