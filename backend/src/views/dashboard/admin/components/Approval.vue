<template>
  <el-table
    :data="tableData"
    stripe
    style="width: 100%"
  >
    <el-table-column
      prop="usulan"
      label="Diterima"
      align="center"
    />
    <el-table-column
      prop="category"
      label="Dipublikasikan"
      align="center"
    />
  </el-table>
</template>
