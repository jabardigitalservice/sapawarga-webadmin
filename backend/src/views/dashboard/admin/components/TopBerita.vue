<template>
  <el-card class="box-card">
    <el-table v-loading="listLoading" class="title" :data="list" stripe border highlight-current-row style="width: 100%">
      <el-table-column
        prop="title"
        label="Judul"
        align="left"
        style="background:blue"
      />
      <el-table-column
        prop="category_name"
        label="View"
        align="center"
      />
    </el-table>
    <el-row>
      <router-link :to="{ path: '/aspirasi/index' }">
        <el-button class="see-more" type="primary" plain>Lihat Semua Usulan</el-button>
      </router-link>
    </el-row>
  </el-card>
</template>

<script>

export default {
  props: {
    list: {
      type: Object,
      default: null
    },
  },
  data() {
    return {
      listLoading: false,
    }
  },
}
</script>

