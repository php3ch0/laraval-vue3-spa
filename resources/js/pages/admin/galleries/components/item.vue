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
<style lang="scss" scoped>
  .admin-item {
    border:2px solid #CCC;
    height:320px;
    overflow: hidden;
    margin-bottom:2em;
    justify-content: center;
    position: relative;
    .item-image {
      overflow: hidden;
      height:200px;
      display: flex;
      position: relative;
      justify-content: center;
      margin:10px;
      img {
        justify-self: center;
        z-index: 1;
        position: absolute;
        align-self: center;
        object-fit: contain;
        max-width: 100%;
        max-height:100%;
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
