<template>
  <div class="app-container">
    <p class="warn-content">Tambah Pengguna</p>
    <el-row :gutter="20">
      <el-col :span="5">
        <div class="grid-content bg-purple"></div>
      </el-col>
      <el-col :span="13">
        <div class="grid-content bg-purple-light"></div>
      </el-col>
      <el-col :span="6">
        <div class="grid-content bg-purple"></div>
      </el-col>
    </el-row>
  </div>
</template>
<style lang="scss" scoped>
p {
  color: #42b983;
  font-weight: 600;
}
.app-container {
  padding: 5px 20px;
}
.el-row {
  margin-left: 20px;

  &:last-child {
    margin-bottom: 0;
  }
}
.el-col {
  border-radius: 4px;
}
.bg-purple {
  background: #d3dce6;
}
.bg-purple-light {
  background: #e5e9f2;
}
.grid-content {
  border-radius: 4px;
  min-height: 36px;
}
.row-bg {
  padding: 10px 0;
  background-color: #f9fafc;
}
</style>
