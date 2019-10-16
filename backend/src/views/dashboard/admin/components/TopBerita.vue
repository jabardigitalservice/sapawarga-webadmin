<template>
  <el-card class="box-card">
    <el-table v-loading="listLoading" class="title" :data="list" stripe border highlight-current-row style="width: 100%">
      <!--       <el-table-column min-width="200">
        <div slot-scope="{row}" class="img-container">
          <img :src="source_url">
        </div>
      </el-table-column> -->
      <el-table-column
        prop="title"
        :label="judul"
        align="left"
        style="background:blue"
      />
      <el-table-column
        prop="total_viewers"
        label="View"
        align="center"
      />
    </el-table>
    <el-row style="margin: 0 auto; text-align: center;padding-top:10px;">
      <router-link :to="{ path: '/news/index' }">
        <a href="#" style="color: #1890ff;">Lihat Semua</a>
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
    judul: {
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

