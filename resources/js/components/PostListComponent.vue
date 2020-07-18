<template>
<div class="container">
    <template v-if="loading"> 
        <div class="fade-layer"></div>
        <div class="spinner-wrapper text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </template>

    <div class="row">
        <div class="col-sm-12 col-md-12 mb-4">
            <h3>さぁ、最新のニュースを<span class="break-sm"><br></span>シェアしましょう</h3>
        </div>
        <div class="col-sm-12 col-md-12">
            <div v-if="errors" class="row">
                <div class="col-md-2"></div>
                <div class="col-sm-12 col-md-9 col-lg-6 ml-2 mr-2 pl-0 pr-0">
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
            <form v-on:submit.prevent="confirmPost">
                <div class="row form-group mb-2">
                    <label for="title" class="col-sm-12 col-md-2 col-lg-2 label-title">タイトル</label>
                    <input type="text" class="col-sm-12 col-md-9 col-lg-6 form-control ml-2 mr-2"
                           id="title" v-model="formPost.title">
                </div>
                <div class="row form-group mb-2">
                    <label for="body" class="col-sm-12 col-md-2 col-lg-2 label-body">記事</label>
                    <textarea class="col-sm-12 col-md-9 col-lg-6 form-control ml-2 mr-2"
                              id="body" rows="4" v-model="formPost.body">
                    </textarea>
                </div>
                <div class="row form-group mb-2">
                    <div class="col-sm-12 col-md-2 col-lg-2 label-thumbnail mb-2">サムネイル</div>
                    <div class="col-sm-12 col-md-9 col-lg-6 ml-2 mr-2 pl-0 pr-0">
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-success btn-thumbnail">
                                    ファイルを選択
                                    <input type="file" multiple="multiple" class="d-none" v-on:change="thumbnailSelected">
                                </span>
                            </label>
                            <input type="text" class="form-control thumbnail-name" readonly="" v-bind:value="selectedFile">
                        </div>
                        <ul class="thumbnail-note" v-bind:class=" colorNote ? 'text-danger': ''">
                            <li>ファイルサイズは2.0MBまでです。</li>
                            <li>画像ファイルを選択してください。</li>
                        </ul>
                        <div class="img-wrapper">
                            <img class="img-fluid thumbnail-preview" v-bind:src="formPost.thumbnail" v-if="formPost.thumbnail">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-2"></div>
                    <button type="submit" class="col-sm-12 col-md-9 col-lg-6 btn btn-primary mb-2 ml-2 mr-2">
                        投&emsp;稿
                    </button>
                </div>
            </form>
            <hr>
        </div>
    </div>

    <div class="row row-post" v-for="post in posts" v-bind:key="post.id">
        <div class="col-3 col-sm-2 img-wrapper text-center">
            <img class="post-thumbnail img-fluid rounded-circle" v-bind:src="post.thumbnail" alt="No Image">
        </div>
        <div class="col-9 col-sm-10">
            <h3 class="post-title">{{ post.title }}</h3>
            <p class="post-body">{{ post.body }}</p>
            <router-link v-bind:to="{ name: 'post.show', params: { postId: post.id.toString() } }">
                <span>記事全文・コメントを見る</span>
            </router-link>
        </div>
        <div class="col-sm-12">
            <hr>
        </div>
    </div>

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
                            v-on:click="submitPost">
                         はい
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
const postIndexURL = '/laravel-news-spa/api/posts';
const postStoreURL = '/laravel-news-spa/api/posts';

const queryParamfetchType   = 'type=';
const queryParamReferenceId = 'ref_id=';

const fetchTypeRecent = 'recent';
const fetchTypePast   = 'past';

export default {
    data: function() {
        return {
            loading: false, // true for prod, false for dev
            errors: null,
            colorNote: false,
            timeoutId: 0,
            selectedFile: '',
            formPost: {
                title: '',
                body: '',
                thumbnail: null
            },
            posts: [],
            recentRefId: 0,
            pastRefId: 0
        }
    },
    methods: {
        handleScroll() {
            if (this.timeoutId) {
                return;
            }

            let that = this;

            this.timeoutId = setTimeout(function() {
                that.timeoutId = 0 ;

                if (window.scrollY === 0) {
                    that.fetchPosts(fetchTypeRecent, that.recentRefId);
                }

                if (document.body.clientHeight - window.innerHeight - window.scrollY < 10) {
                    that.fetchPosts(fetchTypePast, that.pastRefId);
                }
            }, 1000);
        },
        fetchPosts(fetchType = fetchTypeRecent, ref_id = 0) {
            this.loading = true; // behavior only for dev

            let that = this;

            axios.get(postIndexURL + '?' + queryParamfetchType + fetchType + '&' + queryParamReferenceId + ref_id)
                .then((res) => {
                    if (res.data.length === 0) {
                        return
                    };

                    if (this.posts.length === 0) {
                        this.posts = res.data;

                        this.recentRefId = this.posts.reduce((a, b) => { return a.id > b.id ? a : b; }).id;
                        this.pastRefId   = this.posts.reduce((a, b) => { return a.id < b.id ? a : b; }).id;
                    } else {
                        if (fetchType === fetchTypeRecent) {
                            res.data.forEach(el => {
                                this.posts.unshift(el);
                            });

                            this.recentRefId = res.data.reduce((a, b) => { return a.id > b.id ? a : b; }).id;
                        } else {
                            res.data.forEach(el => {
                                this.posts.push(el);
                            });

                            this.pastRefId = res.data.reduce((a, b) => { return a.id < b.id ? a : b; }).id;
                        }
                    }
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };
                }).then(function() {
                    that.loading = false;
                });
        },
        thumbnailSelected(e) {
            let thumbnail = e.target.files[0];

            this.colorNote = false;

            if (!this.checkThumbnail(thumbnail)) {
                this.colorNote = true;

                return;
            }

            let reader = new FileReader();

            reader.onload = (ev) => {
                this.formPost.thumbnail = ev.target.result;
            };
            reader.readAsDataURL(thumbnail);

            this.selectedFile = thumbnail.name;
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

            axios.post(postStoreURL, this.formPost)
                .then((res) => {
                    this.selectedFile       = '';
                    this.formPost.title     = '';
                    this.formPost.body      = '';
                    this.formPost.thumbnail = null;

                    this.errors = null;
                    this.fetchPosts(fetchTypeRecent, this.recentRefId);
                }).catch((error) => {
                    this.errors = error.response.data.errors || { message: [error.message] };
                });
        },
        checkForm() {
            const existTitle = !!this.formPost.title;
            const isTitleValidLength = this.formPost.title.length <= 30;
            const existBody = !!this.formPost.body;

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
        },
        checkThumbnail(file) {
            const maxFileSize = 2 * 1024 * 1024;
            const pattern = 'image/';

            const isImage = file.type.indexOf(pattern) > -1;
            const isValidFileSize = file.size <= maxFileSize;

            if (!isImage || !isValidFileSize) {
                return false;
            }

            return true;
        }
    },
    mounted: function() {
        this.fetchPosts();

        window.addEventListener('scroll', this.handleScroll);
    },
    beforeDestroy: function() {
        window.removeEventListener('scroll', this.handleScroll);
    },
}
</script>

<style scoped>
@media (min-width: 576px) {
    .break-sm {
        display: none;
    }
}

.fade-layer {
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background-color: #000000;
    opacity: 0.5;
    z-index: 1;
}

.spinner-wrapper {
    position: fixed;
    top: 50%;
    left: 50%;
    z-index: 99;
}

.label-title,
.label-thumbnail {
    padding-top: 0.3rem;
}

textarea {
    resize: none;
}

.btn-thumbnail {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.thumbnail-note {
    list-style: disclosure-closed;
}

.thumbnail-preview {
    max-height: 200px;
    max-width: 100%;
}

.thumbnail-name,
.post-body {
    padding-right: 1.0rem;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.post-thumbnail {
    max-height: 100px;
    max-width: 100%;
}

.row-post {
    height: 160px;
}

.img-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
