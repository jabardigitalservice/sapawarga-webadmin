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
    margin-left: 20px;
    -webkit-box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);

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
