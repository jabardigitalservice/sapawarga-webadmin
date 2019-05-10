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
  data() {
    return {
      imageData: require('@/assets/user.png')
    }
  },
  watch: {
    image() {
      if (this.image !== null) {
        this.imageData = this.image
      }
    }
  }
}
</script>

<style lang="scss" scoped>
img.preview {
  width: 400px;
  height: 350px;
  border-radius: 5px;
  margin-left: 20px;
  -webkit-box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);
}

@media only screen and (min-width: 1200px) and (max-width: 1570px) {
  img.preview {
    width: 300px;
    height: 250px;
    border-radius: 5px;
    margin-left: 20px;
    -webkit-box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.75);
  }
}

</style>
