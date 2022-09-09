<template>
  <div id="admin-item" class="admin-item">
    <div class="controls">
      <div class="row">
        <div class="col text-end">
          <router-link :to="'/admin/blog/'+item.id" class="btn btn-sm">Edit</router-link>
        </div>
      </div>
    </div>
    <div class="item-image">
      <img v-if="item.image_url" :src="item.image_url" :alt="item.title"  />
      <img v-else src="/storage/images/loaders/loading-sm.svg" class="m-4" alt="Loading" />
    </div>
    <div class="title text-center">
      {{ item.title }}
      <small>{{ new Date(item.created_at).toLocaleDateString() }}</small>
    </div>
  </div>
</template>

<script>
    export default {
        name: "BlogAdminItem",
        middleware: 'admin',
        data() {
            return {
            }
            },
        props: {
            item: Object,
        },


    }
</script>
