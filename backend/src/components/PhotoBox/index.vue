<template>
  <div class="image-preview">
    <img class="preview" :src="imageData">
  </div>
</template>

<script>
export default {
  name: 'PhotoBox',
  props: {
    image: {
      type: String,
      default: null
    },
    height: {
      type: String,
      default: '220px'
    }
  },
  data(){
    return {
      imageData: require('@/assets/user.png')
    }
  },
  watch: {
    image(){
      if (this.image !== null) {
        this.imageData = this.image
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.box-center {

  // display: table;
}

img.preview {
    width: 400px;
    height: 350px;
    background-color: white;
    border: 1px solid #DDD;
    padding: 5px;
    margin-left: 20px;
}
// .box-card-header {
//   position: relative;
//   width: 600px;
//   height: 400px;
//   /* height: 220px; */
//   img {
//     // width: 100%;
//     // height: 100%;
//     // transition: all 0.2s linear;
//     // &:hover {
//     //   transform: scale(1.1, 1.1);
//     //   filter: contrast(130%);
//     width: 100%;
//     height: 100%;
//     background-color: white;
//     border: 1px solid #DDD;
//     }
//   }

</style>
