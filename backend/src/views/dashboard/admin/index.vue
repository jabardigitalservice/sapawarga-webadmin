<template>
  <div class="dashboard-editor-container">

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
      <el-col :xs="{span: 24, tag:'mb-10'}" :sm="{span: 24, tag:'mb-10'}" :md="{span: 12}" :lg="{span: 12}" :xl="{span: 12}">
        <TopNews :list="listNewsProvinsi" :title="$t('dashboard.dashboard-news-prov')" />
      </el-col>
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 12}" :lg="{span: 12}" :xl="{span: 12}">
        <TopNews :list="listNewsKoKab" :title="$t('dashboard.dashboard-news-kabkota')" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchTopFiveNewsProv, fetchTopFiveNewsDistricts } from '@/api/dashboard'
import { mapGetters } from 'vuex'
import Usulan from './components/Usulan'
import Approval from './components/Approval'
import Category from './components/Category'
import MapData from './components/MapData'
import Polling from './components/Polling'
import TopNews from './components/TopNews'

export default {
  name: 'DashboardAdmin',
  components: {
    Category,
    Usulan,
    Approval,
    MapData,
    Polling,
    TopNews
  },
  data() {
    return {
      listNewsProvinsi: null,
      listNewsKoKab: null,
      listLoading: true,
      listQuery: null
    }
  },
  computed: {
    ...mapGetters([
      'user'
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
      this.listQuery = this.user.kabkota_id ? { kabkota_id: this.user.kabkota_id } : { location: 'kabkota' }
      fetchTopFiveNewsDistricts(this.listQuery).then(response => {
        this.listNewsKoKab = response.data
        this.listLoading = false
      })
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
