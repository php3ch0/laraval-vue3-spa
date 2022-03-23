<template>
  <div class="admin-gallery-image">
    <div class="image-controls">
      <div class="row">
        <div class="col text-start">
          <i class="fas fa-expand-arrows-alt" title="Change Order By Drag and Drop"></i>
          <i class="fas fa-font" title="Change Text" @click="viewCaption"></i>
          <i class="fas fa-sync-alt" title="Rotate Image" @click="rotateImage"></i>
        </div>
        <div class="col text-end">
          <i class="far fa-trash-alt" title="Delete Image" @click="deleteImage"></i>
        </div>
      </div>
    </div>
    <template v-if="loading">
      <LoadingSm />
    </template>
    <template v-else>
      <img :src="thisImage.imageurl" :alt="thisImage.caption"  />
    </template>
    </div>
  </div>
</template>

<script>

    export default {
        name: "gimage",
      middleware: 'admin',
        data() {
            return {
                loading:true,
                thisImage: null,
        }},
        props: {
            id: Number,
        },
        mounted() {
            let self=this;
            self.$axios.get('/api/galleries/images/'+self.id).then(function (res) {
                self.thisImage = res.data.results;
                self.bgColor = 'loadingLight';
                self.loading=false;
            })
        },
        methods: {
            deleteImage() {
                this.$emit('deleteImage',this.thisImage.id);
            },
            viewCaption() {
                this.$emit('viewCaption',this.thisImage.id);
            },
            rotateImage() {
                this.$emit('rotateImage',this.thisImage.id);
            }
        }
    }
</script>
