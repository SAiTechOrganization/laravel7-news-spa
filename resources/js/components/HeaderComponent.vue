<template>
<div class="container-fluid bg-dark mb-3 pl-0">
    <div class="container pl-0">
        <div class="navbar navbar-dark bg-dark pt-2 pb-2">
            <router-link v-bind:to="{name: 'post.list'}">
                <h3 class="font-weight-bold font-italic text-white mb-0">
                    Laravel News
                </h3>
            </router-link>
        </div>
    </div>
</div>
</template>

<script>
    export default {}
</script>
