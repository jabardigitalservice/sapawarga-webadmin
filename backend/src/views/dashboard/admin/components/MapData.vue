<template>
  <el-card class="box-card">
    <div class="text item">
      <el-row :gutter="8">
        <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 16}" :xl="{span: 16}" style="padding-right:8px;margin-bottom:30px;">
          <h1 align="center">Map Jawa Barat</h1>
        </el-col>
        <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 8}" :xl="{span: 8}" style="margin-bottom:30px;">
          <el-table
            :data="tableData"
            stripe
            style="width: 100%; margin-left:10px">
            <el-table-column
              prop="usulan"
              label="Kota/Kabupaten"
              align="center"
              min-width="200"
            >
            </el-table-column>
            <el-table-column
              prop="category"
              label="Usulan"
              align="center"
              min-width="100"
              >
            </el-table-column>
          </el-table>
        </el-col>
      </el-row>
    </div>
</el-card>
</template>

<script>

</script>


<style lang="scss" scoped>
  .text {
    font-size: 14px;
  }

  .item {
    padding: 18px 0;
  }

  .box-card {
    width: 100%;
  }
</style>