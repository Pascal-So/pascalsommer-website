<template>
    <div id="photo-selector">
        <h2>Photos in Post</h2>
        <draggable class="dragArea" v-model="post_photos" :options="{put: true, pull: true, group: 'photos'}">
            <div class="box-sortable" v-for="photo in post_photos">
                <a :href="view_path + photo.id" target="blank">
                    <img class="photo-sortable" :src="asset_path + photo.path">
                </a>
            </div>
        </draggable>
        <h2>Staged Photos</h2>
        <draggable class="dragArea" v-model="staged_photos" :options="{handle: 'img', put: true, pull: true, group: 'photos'}">
            <div class="box-sortable" v-for="photo in staged_photos">
                <a :href="view_path + photo.id" target="blank">
                    <img class="photo-sortable" :src="asset_path + photo.path">
                </a>
            </div>
        </draggable>

        <input v-for="photo_id in post_photo_ids" type="hidden" name="photos[]" id="post-photo-ids" :value="photo_id">
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import $ from 'jquery';

    const post_photos = JSON.parse($('#post-photos').text());
    const staged_photos = JSON.parse($('#staged-photos').text());

    const asset_path = $('#asset-path').text();
    const view_path = $('#view-path').text();

    export default {
        data() {
            return {
                post_photos: post_photos,
                staged_photos: staged_photos,
                asset_path: asset_path,
                view_path: view_path,
            };
        },
        components: {
            draggable,
        },
        computed: {
            post_photo_ids() {
                return this.post_photos.map(x => x.id);
            },
        },
    }
</script>

<style lang="scss">

@import "../../sass/pascal.scss";

.box-sortable{
    background-color: $body-bg;
    vertical-align: bottom;
    width: 300px;
    height: 200px;
    line-height: 200px;
    border-bottom: 3px solid $darker-border-color;
    border-right: 2px solid $darker-border-color;
    display: inline-block;
    margin: 10px;
    padding: 2px;
    text-align: center;
}

.sortable-ghost .photo-sortable{
    opacity: 0.3;
    filter: blur(5px);
}

.photo-sortable{
    vertical-align: middle;
    max-height: 200px;
    max-width: 300px;
}

.dragArea{
    background-color: darken($body-bg, 2%);
    border-top: 4px solid $darker-border-color;
    border-left: 4px solid $darker-border-color;
    min-height: 80px;
    margin: 0 5vw;
    text-align: left;
}

</style>