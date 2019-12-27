<template>
  <el-card class="box-card" style="border-radius: 10px;">
    <el-table v-loading="listLoading" class="title" :data="list" stripe border highlight-current-row style="width: 100%">
      <el-table-column
        prop="title"
        :label="title"
        align="left"
        style="background:blue"
        valign="middle"
        min-width="300"
      >
        <template slot-scope="{row}">
          <el-row>
            <el-col :xs="{span:4, tag:'mb-10'}" :sm="3" :md="3">
              <img :src="row.cover_path_url" style="width: 42px;height: 42px;">
            </el-col>
            <el-col :xs="{span:20, tag:'mb-10'}" :sm="20" :md="20">
              <div class="title-top-news cell">
                {{ row.title }}
              </div>
            </el-col>
          </el-row>
        </template>
      </el-table-column>
      <el-table-column
        prop="total_viewers"
        :label="$t('dashboard.dashboard-news-viewer')"
        align="center"
        width="75"
      />
    </el-table>
    <el-row style="margin: 0 auto; text-align: center;padding-top:10px;">
      <router-link :to="{ path: '/news/index' }">
        <a href="#" style="color: #1890ff;">{{ $t('dashboard.dashboard-news-see-all') }}</a>
      </router-link>
    </el-row>
  </el-card>
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
