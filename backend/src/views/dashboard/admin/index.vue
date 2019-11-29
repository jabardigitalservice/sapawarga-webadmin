<template>
  <div class="dashboard-editor-container">

    <!-- <h3>Trafik User</h3>

    <el-row style="background:#fff;padding:16px 16px 0;margin-bottom:32px;">
      <line-chart :chart-data="lineChartData" />
    </el-row> -->

    <h3>{{ $t('dashboard.dashboard-aspiration') }}</h3>

    <el-row :gutter="8">
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 16}" :xl="{span: 16}" style="padding-right:8px;margin-bottom:10px;">
        <Usulan />
      </el-col>
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 8}" :xl="{span: 8}" style="margin-bottom:10px;">
        <Approval />
        <Category style="margin-top:10px" />
      </el-col>
    </el-row>
    <!-- Map Usulan -->
    <el-row>
      <el-col>
        <Map-data />

      </el-col>
    </el-row>

    <!-- Polling -->
    <h3>{{ $t('dashboard.dashboard-polling') }}</h3>
    <el-row>
      <el-col>
        <polling />
      </el-col>
    </el-row>

    <!-- Polling -->
    <h3>{{ $t('dashboard.dashboard-top-news') }}</h3>
    <el-row>
      <el-col :xs="{span: 12}" :sm="{span: 12}" :md="{span: 12}" :lg="{span: 12}" :xl="{span: 12}">
        <TopNews v-if="roleAccess" :list="listNewsProvinsi" :title="$t('dashboard.dashboard-news-prov')" />
      </el-col>
      <el-col :xs="{span: 12}" :sm="{span: 12}" :md="{span: 12}" :lg="{span: 12}" :xl="{span: 12}">
        <TopNews :list="listNewsKoKab" :title="$t('dashboard.dashboard-news-kabkota')" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
// import LineChart from './components/LineChart'
import { fetchTopFiveNewsProv, fetchTopFiveNewsDistricts } from '@/api/dashboard'
import Usulan from './components/Usulan'
import Approval from './components/Approval'
import Category from './components/Category'
import MapData from './components/MapData'
import Polling from './components/Polling'
import TopNews from './components/TopNews'
import { mapGetters } from 'vuex'
import checkPermission from '@/utils/permission'
import { RolesUser } from '@/utils/constantVariabel'

const lineChartData = {
  newVisitis: {
    expectedData: [100, 120, 161, 134, 105, 160, 165],
    actualData: [120, 82, 91, 154, 162, 140, 145]
  },
  messages: {
    expectedData: [200, 192, 120, 144, 160, 130, 140],
    actualData: [180, 160, 151, 106, 145, 150, 130]
  },
  purchases: {
    expectedData: [80, 100, 121, 104, 105, 90, 100],
    actualData: [120, 90, 100, 138, 142, 130, 130]
  },
  shoppings: {
    expectedData: [130, 140, 141, 142, 145, 150, 160],
    actualData: [120, 82, 91, 154, 162, 140, 130]
  }
}

export default {
  name: 'DashboardAdmin',
  components: {
    // LineChart,
    Category,
    Usulan,
    Approval,
    MapData,
    Polling,
    TopNews
  },
  data() {
    return {
      lineChartData: lineChartData.newVisitis,
      listNewsProvinsi: null,
      listNewsKoKab: null,
      listLoading: true,
      roleAccess: checkPermission([RolesUser.ADMIN, RolesUser.STAFFPROV])
    }
  },
  computed: {
    ...mapGetters([
      'roles'
    ])
  },
  created() {
    this.getListProvinsi()
    this.getLisKoKab()
  },
  methods: {
    getListProvinsi() {
      this.listLoading = true
      fetchTopFiveNewsProv({ location: 'provinsi' }).then(response => {
        this.listNewsProvinsi = response.data
        this.listLoading = false
      })
    },

    getLisKoKab() {
      this.listLoading = true
      fetchTopFiveNewsDistricts({ location: 'kabkota' }).then(response => {
        this.listNewsKoKab = response.data
        this.listLoading = false
      })
    },

    handleSetLineChartData(type) {
      this.lineChartData = lineChartData[type]
    }
  }
}
</script>

<style lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  padding-top: 10px;
  background-color: rgb(240, 242, 245);
  position: relative;

  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}
</style>
