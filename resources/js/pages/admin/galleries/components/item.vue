<template>
  <div id="admin-item" class="admin-item">
    <div class="controls">
      <div class="row">
        <div class="col text-end">
          <router-link :to="'/admin/galleries/'+item.id" class="btn btn-sm">Edit</router-link>
        </div>
      </div>
    </div>
    <div class="item-image">
      <img :src="item.image_url" :alt="item.name" />
    </div>
    <div class="title text-center">
      {{ item.name }}
    </div>
  </div>
</template>

<script>
    export default {
        name: "GalleryAdminItem",
        middleware: 'admin',
        data() {
            return {}
            },
        props: {
            item: Object,
        },


    }
</script>
