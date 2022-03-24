<template>
  <div id="blog-admin-item" class="admin-blog-item">
    <div class="controls">
      <div class="row">
        <div class="col text-end">
          <router-link :to="'/admin/blog/'+thisItem.id" class="btn btn-sm">Edit</router-link>
        </div>
      </div>
    </div>
    <div class="item-image">
      <img v-if="thisItem.image_url" :src="thisItem.image_url" :alt="thisItem.name"  />
      <img v-else src="/storage/images/loaders/loading-sm.svg" alt="Loading" />
    </div>
    <div class="title text-center">
      {{ thisItem.title }}
      <small>{{ thisItem.published }}</small>
    </div>
  </div>
</template>

<script>
    export default {
        name: "BlogAdminItem",
        middleware: 'admin',
        data() {
            return {
                thisItem: {
                    id: null,
                    title: null,
                },
        }},
        props: {
            id: Number,
        },
        mounted() {
            let self=this;
            self.$axios.get('/api/blog/'+self.id).then(function (res) {
                self.thisItem = res.data;
            })
        },

    }
</script>
<style lang="scss" scoped>
  .admin-blog-item {
    border:2px solid #CCC;
    height:320px;
    overflow: hidden;
    margin-bottom:2em;
    justify-content: center;
    position: relative;
    .item-image {
      overflow: hidden;
      height:200px;
      object-fit: contain;
      position: relative;
      img {
        z-index: 1;
        position: absolute;
        align-self: center;
        object-fit: contain;
        width: 100%;
      }
    }
    .title {
      padding:5px;
      height:50px;
      margin-top:10px;
      small {
        display: block;
      }
    }
    a {
      color: #dedede;
    }

    .controls {
      width:100%;
      position: absolute;
      top:0;
      left:0;
      right:0;
      height:0;
      overflow: hidden;
      background-color: rgba(0,0,0,0.8);
      transition: all 0.4s ease-in-out;
      color: #CCC;
      z-index: 2;
    }
    &:hover {
      border:2px solid #333;
      cursor: pointer;
      .controls {
        height:auto;
        padding:10px;
        i {
          font-size: 1.3em;
          &:hover {
            color: #FFF;
          }
        }
      }
    }
  }
  </style>
