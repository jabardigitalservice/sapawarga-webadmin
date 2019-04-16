<template>
  <div>
    <el-row :gutter="10" type="flex" justify="end">
      <el-col :span="6">
        <el-select filterable placeholder="Pilih Kabupaten/Kota">
          <el-option />
        </el-select>
      </el-col>

      <el-col :span="6">
        <el-select filterable placeholder="Pilih Kecamatan">
          <el-option />
        </el-select>
      </el-col>

      <el-col :span="6">
        <el-select filterable placeholder="Pilih Kelurahan">
          <el-option />
        </el-select>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {}
</script>
