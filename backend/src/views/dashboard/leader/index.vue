<template>
  <div class="dashboard-leader-container">
    <div class=" clearfix">
      <el-row :gutter="8">
        <el-col class="dashboard-content-map" :md="{span: 24}" :lg="{span: 24}" :xl="{span: 24}">
          <map-aspiration :additional-data="additionalData" />
        </el-col>
      </el-row>
      <el-row :gutter="8">
        <el-col class="dashboard-content" :md="{span: 24}" :lg="{span: 24}" :xl="{span: 24}">
          <polling :total-polling="totalPolling" />
        </el-col>
      </el-row>
      <el-row :gutter="8">
        <el-col class="dashboard-content" :md="24" :lg="14" :xl="14">
          <!-- list news -->
          <top-news :list="listNewsProvinsi" :title="$t('dashboard.dashboard-news-prov')" />
        </el-col>
        <el-col class="dashboard-content" :md="24" :lg="10" :xl="10">
          <!-- list qna -->
          <top-QNA :list="listTopQNA" />
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { fetchTopFiveNewsProv, fetchAspirasiCounts } from '@/api/dashboard'
import MapAspiration from '@/components/Dashboard/MapAspiration'
import Polling from '@/components/Dashboard/Polling'
import TopNews from '@/components/Dashboard/TopNews'
import TopQNA from '@/components/Dashboard/TopQNA'

const listTopQNA = {
  items: [
    {
      likes_count: 5,
      text: 'selamat siang pak gub, sehat?',
      user: {
        id: 186100,
        name: 'staff rw sembilan puluh'
      }
    },
    {
      likes_count: 5,
      text: 'selamat siang pak gub, sehat?',
      user: {
        id: 186100,
        name: 'staff rw sembilan puluh'
      }
    }
  ]
}

const countPolling = {
  createdPolling: 12,
  followedPolling: 10
}

export default {
  name: 'DashboardLeader',
  components: {
    MapAspiration,
    Polling,
    TopNews,
    TopQNA
  },
  data() {
    return {
      listTopQNA: listTopQNA.items,
      totalPolling: countPolling,
      additionalData: [],
      listNewsProvinsi: null,
      listLoading: true
    }
  },
  computed: {
    ...mapGetters([
      'name',
      'avatar',
      'roles'
    ])
  },
  created() {
    this.getListProvinsi()
    this.getAspirasiCounts()
  },
  methods: {
    getListProvinsi() {
      this.listLoading = true
      fetchTopFiveNewsProv({ location: 'provinsi' }).then(response => {
        this.listNewsProvinsi = response.data
        this.listLoading = false
      })
    },
    getAspirasiCounts() {
      this.listLoading = true
      fetchAspirasiCounts().then(response => {
        this.additionalData.push(response.data)
      })
    }

  }
}
</script>

<style lang="scss" scoped>
.dashboard-leader-container {
  background-color: #fff;
  min-height: 100vh;
  padding: 20px 14px 0px;

  .dashboard-content {
    padding-bottom: 10px;
  }
}

@media screen and (max-width: 768px) {
  .dashboard-leader-container {
    .dashboard-content-map {
      padding-bottom: 50px;
    }
  }
}
</style>
