<template>
  <el-card>
    <div class="photo">
      <div class="box-center">
        <div :style="{height:height}" class="box-card-header">
          <img :src="image">
        </div>
      </div>
    </div>
  </el-card>
</template>

<script>
export default {
  name: 'PhotoBox',
  props: {
    image: {
      type: String,
      required: true
    },
    height: {
      type: String,
      default: '220px'
    }
  }
}
</script>

<style lang="scss" scoped>
.box-center {
  margin: 0 auto;
  display: table;
}
/* .photo {
  .box-center {
    padding-top: 10px;
  }
} */
.box-card-header {
  position: relative;
  /* height: 220px; */
  img {
    width: 100%;
    height: 100%;
    transition: all 0.2s linear;
    &:hover {
      transform: scale(1.1, 1.1);
      filter: contrast(130%);
    }
  }
}
</style>
