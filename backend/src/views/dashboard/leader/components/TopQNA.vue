<template>
  <div>
    <el-card class="box-card" style="background: #bcffa3;">
      <span>Nama pengirim</span>
    </el-card>
    <el-card class="box-card" style="background: #bcffa3;">
      <span>Nama pengirim</span>
    </el-card>
    <el-card class="box-card" style="background: #bcffa3;">
      <span>Nama pengirim</span>
    </el-card>
  </div>
</template>

<script>

export default {
  props: {
    list: {
      type: Array,
      default: null
    },
    title: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      listLoading: false
    }
  }
}
</script>
