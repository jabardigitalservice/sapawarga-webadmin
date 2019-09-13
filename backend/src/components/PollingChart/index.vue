<template>
  <div :class="className" :style="{height:height,width:width}" />
</template>

<script>
import echarts from 'echarts'
require('echarts/theme/macarons') // echarts theme
import { debounce } from '@/utils'
import { fetchResult } from '@/api/polling'

export default {
  props: {
    className: {
      type: String,
      default: 'chart'
    },
    width: {
      type: String,
      default: '100%'
    },
    height: {
      type: String,
      default: '300px'
    }
  },
  data() {
    return {
      chart: null,
      id: null,
      result: [],
      count: null
    }
  },
  mounted() {
    this.id = this.$route.params && this.$route.params.id
    this.getResult()
    this.__resizeHandler = debounce(() => {
      if (this.chart) {
        this.chart.resize()
      }
    }, 100)
    window.addEventListener('resize', this.__resizeHandler)
  },
  beforeDestroy() {
    if (!this.chart) {
      return
    }
    window.removeEventListener('resize', this.__resizeHandler)
    this.chart.dispose()
    this.chart = null
  },
  methods: {
    async getResult() {
      const arrayTemporary = []
      await fetchResult(this.id).then(response => {
        response.data.forEach(function(value, key) {
          arrayTemporary.push({ 'value': value.votes, 'name': value.answer_body })
        })
      })

      Object.assign(this.result, arrayTemporary)

      this.count = this.result.reduce(function(prev, cur) {
        return parseInt(prev) + parseInt(cur.value)
      }, 0)

      this.$emit('childToParent', this.count)
      this.initChart()
    },
    initChart() {
      this.chart = echarts.init(this.$el, 'macarons')

      this.chart.setOption({
        tooltip: {
          trigger: 'item',
          formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
          left: 'center',
          bottom: '10'
        },
        calculable: true,
        series: [
          {
            name: 'Hasil Polling',
            type: 'pie',
            roseType: 'radius',
            radius: [15, 95],
            center: ['50%', '45%'],
            data: this.result,
            animationEasing: 'cubicInOut',
            animationDuration: 2600
          }
        ]
      })
    }
  }
}
</script>
