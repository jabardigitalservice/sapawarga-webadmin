<template>
  <div class="dashboard-leader-container">
    <div class=" clearfix">
      <el-row :gutter="8">
        <el-col :md="{span: 13}" :lg="{span: 13}" :xl="{span: 13}" style="padding-bottom: 10px;">
          <!-- grafik saberhoax -->
          <el-card>
            <span><b>Saber Hoax</b></span>
            <line-chart :chart-data="lineChartData" />
          </el-card>
        </el-col>
        <el-col :md="{span: 11}" :lg="{span: 11}" :xl="{span: 11}" style="padding-bottom: 10px;">
          <!-- <span>&nbsp;</span> -->
          <!-- card panel -->
          <card-panel />
        </el-col>
      </el-row>
      <el-row :gutter="8">
        <el-col :md="{span: 13}" :lg="{span: 13}" :xl="{span: 13}">
          <!-- list news -->
          <top-news />
        </el-col>
        <el-col :md="{span: 11}" :lg="{span: 11}" :xl="{span: 11}">
          <!-- list qna -->
          <top-QNA />
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import CardPanel from './components/CardPanel'
import LineChart from './components/LineChart'
import TopNews from './components/TopNews'
import TopQNA from './components/TopQNA'

const lineChartData = {
  newHoaxChart: {
    monthTitle: ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    actualData: [120, 82, 91, 154, 162, 140, 145]
  }
}
export default {
  name: 'DashboardLeader',
  components: {
    CardPanel,
    LineChart,
    TopNews,
    TopQNA
  },
  data() {
    return {
      lineChartData: lineChartData.newHoaxChart
    }
  },
  computed: {
    ...mapGetters([
      'name',
      'avatar',
      'roles'
    ])
  }
}
</script>

<style lang="scss" scoped>
.dashboard-leader-container {
  background-color: #fff;
  min-height: 100vh;
  padding: 20px 14px 0px;
  .pan-info-roles {
    font-size: 12px;
    font-weight: 700;
    color: #333;
    display: block;
  }
  .info-container {
    position: relative;
    margin-left: 190px;
    height: 150px;
    line-height: 200px;
    .display_name {
      font-size: 48px;
      line-height: 48px;
      color: #212121;
      position: absolute;
      top: 25px;
    }
  }
}
</style>
