<template>
  <el-card>
    <span><b>Polling</b></span>
    <el-row :gutter="40" class="panel-group">
      <el-col :xs="12" :sm="12" :lg="12" class="card-panel-col">
        <div class="card-panel" style="background: #43b9ff;" @click="handleSetLineChartData('newVisitis')">
          <div class="card-panel-description">
            <div class="card-panel-text">
              Polling Dibuat
            </div>
            <div class="card-panel-count">
              <count-to :start-val="0" :end-val="102400" :duration="2600" class="card-panel-num" />
            </div>
          </div>
        </div>
      </el-col>
      <el-col :xs="12" :sm="12" :lg="12" class="card-panel-col">
        <div class="card-panel" style="background: #43b9ff;" @click="handleSetLineChartData('messages')">
          <div class="card-panel-description">
            <div class="card-panel-text">
              Polling Diikuti
            </div>
            <div class="card-panel-count">
              <count-to :start-val="0" :end-val="81212" :duration="3000" class="card-panel-num" />
            </div>
          </div>
        </div>
      </el-col>
    </el-row>
    <span><b>Usulan</b></span>
    <el-row :gutter="40" class="panel-group">
      <el-col :xs="12" :sm="12" :lg="12" class="card-panel-col">
        <div class="card-panel" style="background: #26e7a6;" @click="handleSetLineChartData('newVisitis')">
          <div class="card-panel-description">
            <div class="card-panel-text">
              Usulan dibuat bulan ini
            </div>
            <div class="card-panel-count">
              <count-to :start-val="0" :end-val="102400" :duration="2600" class="card-panel-num" />
            </div>
          </div>
        </div>
      </el-col>
      <el-col :xs="12" :sm="12" :lg="12" class="card-panel-col">
        <div class="card-panel" style="background: #26e7a6;" @click="handleSetLineChartData('messages')">
          <div class="card-panel-description">
            <div class="card-panel-text">
              Usulan ditindak lanjuti
            </div>
            <div class="card-panel-count">
              <count-to :start-val="0" :end-val="81212" :duration="3000" class="card-panel-num" />
            </div>
          </div>
        </div>
      </el-col>
    </el-row>
  </el-card>
</template>

<script>

import CountTo from 'vue-count-to'

export default {
  components: { CountTo },
  props: {

  },
  data() {
    return {
      listLoading: true
    }
  },
  created() {

  },
  methods: {
    handleSetLineChartData(type) {
      this.$emit('handleSetLineChartData', type)
    }
  }
}
</script>

<style lang="scss" scoped>
.panel-group {
  margin-top: 18px;

  .card-panel-col {
    margin-bottom: 32px;
  }

  .card-panel {
    height: 108px;
    cursor: pointer;
    font-size: 12px;
    position: relative;
    overflow: hidden;
    color: #666;
    border-radius: 10px;
    box-shadow: 4px 4px 40px rgba(0, 0, 0, .05);
    border-color: rgba(0, 0, 0, .05);

    .card-panel-description {
      text-align: center;
      font-weight: bold;
      margin: 26px;

      .card-panel-text {
        float: left;
        line-height: 18px;
        color: #000;
        font-size: 16px;
        margin-bottom: 12px;
      }

      .card-panel-num {
        color: #000;
        font-size: 20px;
      }
    }
  }
}
</style>
