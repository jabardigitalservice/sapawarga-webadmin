<template>
  <el-card class="box-card">
    <el-table v-loading="listLoading" class="title" :data="list" stripe border highlight-current-row style="width: 100%">
      <el-table-column
        prop="title"
        :label="judul"
        align="left"
        style="background:blue"
        valign="middle"
      >
        <template slot-scope="{row}">
          <el-row>
            <el-col :span="3">
              <img :src="row.cover_path_url" style="width: 28px;border-radius: 50%;">
            </el-col>
            <el-col :span="10">
              <div class="title-top-berita cell" style="using display:table-cell; vertical-align:middle;padding-left: 10px;width: 200px;">
                <span>{{ row.title }}</span>
              </div>
            </el-col>
          </el-row>
        </template>
      </el-table-column>
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

