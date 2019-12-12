<template>
  <el-row>
    <el-col :md="24" :lg="14" :xl="14" class="dashboard-polling">
      <el-card class="box-card">
        <el-table v-loading="listLoading" class="title" :data="list" stripe :show-header="header">
          <el-table-column type="index" width="50" align="center" />
          <el-table-column prop="question" align="left" min-width="400px" />
          <el-table-column align="right">
            <template slot-scope="scope">
              <el-button circle type="default" icon="el-icon-arrow-right" size="small" min-width="50px" @click="displayChart(scope.row)" />
            </template>
          </el-table-column>
        </el-table>
        <el-row class="dashboard-btn-all">
          <router-link :to="{ path: '/polling/index' }">
            <a href="#" style="color: #1890ff;">{{ $t('label.polling-view-all') }}</a>
          </router-link>
        </el-row>
      </el-card>
    </el-col>
    <el-col :md="24" :lg="10" :xl="10">
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>{{ $t('label.polling-audience') }}</span>
          <span class="total_audience">{{ count }}</span>
        </div>
        <p class="question">{{ question }}</p>
        <p class="date">{{ chartStart_date }} - {{ chartEnd_date }}</p>
        <PollingChart :is-edit="true" :prop-id-polling="id" @childToParent="getFromChild" />
      </el-card>
    </el-col>
  </el-row>
</template>
<script>
import { fetchLatestPolling } from '@/api/dashboard'
import PollingChart from '@/components/PollingChart'
import moment from 'moment'
export default {
  components: {
    PollingChart
  },
  data() {
    return {
      list: null,
      listLoading: true,
      header: false,
      id: null,
      question: null,
      chartStart_date: null,
      chartEnd_date: null,
      count: null,
      listQuery: {
        limit: null
      }
    }
  },
  watch: {
  },
  mounted() {
    this.getList()
    this.getFromChild()
  },
  methods: {
    getList() {
      this.listLoading = true
      fetchLatestPolling(this.listQuery).then(response => {
        this.list = response.data
        this.listLoading = false
        if (this.list.length === 0) {
          this.id = null
          this.question = this.$t('message.empty')
        } else {
          const firstPolling = this.list[0]
          this.id = parseInt(firstPolling.id)
          this.question = firstPolling.question
          this.chartStart_date = moment(firstPolling.start_date).format('D MMMM YYYY')
          this.chartEnd_date = moment(firstPolling.end_date).format('D MMMM YYYY')
        }
      })
    },
    displayChart(data) {
      this.id = parseInt(data.id)
      this.question = data.question
      this.chartStart_date = moment(data.start_date).format('D MMMM YYYY')
      this.chartEnd_date = moment(data.end_date).format('D MMMM YYYY')
    },
    getFromChild(value) {
      this.count = value
    }
  }
}
</script>
<style lang="scss" scoped>
  .total_audience {
    float:right;
    color:#14A75B;
    font-size: 20px;
    font-weight: bold;
  }
  .question {
    margin-top: 0px;
    color: rgba(0, 0, 0, 0.7);
    text-align:center;
  }
  .date {
    font-size: 15px;
    text-align:center;
    color: rgba(0, 0, 0, 0.7);
  }
</style>
