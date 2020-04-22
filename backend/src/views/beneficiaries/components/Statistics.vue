<template>
  <el-row :gutter="20">
    <el-col :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">TERVERIFIKASI</div>
        <div class="stat-count">2555</div>
      </div>
    </el-col>
    <el-col :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title shadow">BELUM TERVERIFIKASI</div>
        <div class="stat-count">2555</div>
      </div>
    </el-col>
    <el-col :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">DITOLAK</div>
        <div class="stat-count">2555</div>
      </div>
    </el-col>
    <el-col :xs="20" :sm="10" :md="6" :lg="6" :xl="6">
      <div class="grid-content">
        <div class="stat-title">SEMUA DATA PENERIMA BANTUAN</div>
        <div class="stat-count">2555</div>
      </div>
    </el-col>
  </el-row>
</template>

<script>
export default {}
</script>

<style lang="scss" scoped>
.el-col {
  padding-top: 10px;
  border-radius: 8px;
  padding-bottom: 30px;
}
.grid-content {
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.04);
  padding: 15px;
  background: #ffff;
  border: 1px solid #E1E5EE;
  box-sizing: border-box;
  border-radius: 8px;
}
.stat-title {
  margin-bottom: 13px;
  font-weight: bold;
}
.stat-count {
  color: #27AE60;
  font-size: 28px;
  font-weight: bolder;
}
</style>
