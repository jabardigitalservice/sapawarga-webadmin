<template>
  <e-metric title="Outcome" :value="data[period][0] | formatNumber" icon="fa-yen" icon-dark>
    <div class="d-flex justify-content-center mt-3">
      <div class="btn-group">
        <button
          v-for="field in Object.keys(data)"
          class="btn btn-sm btn-outline-secondary"
          :class="{ 'active': field == period }"
          @click="period = field">{{ field | capitalize }}</button>
      </div>
    </div>
    <div class="mt-3 bg-light">
      <e-bar-chart
        :chart-data="chartData"
        :options="options"
        :height="51"></e-bar-chart>
    </div>
  </e-metric>
</template>

<script>
  import EMetric from '../index'
  import EBarChart from '../../chart/types/bar'

  const data = {
    'day': {
      0: random(),
      1: random(),
      2: random(),
      3: random(),
      4: random(),
      5: random(),
    },
    'week': {
      0: random() * 7,
      1: random() * 7,
      2: random() * 7,
      3: random() * 7,
      4: random() * 7,
      5: random() * 7,
    },
    'month': {
      0: random() * 30,
      1: random() * 30,
      2: random() * 30,
      3: random() * 30,
      4: random() * 30,
      5: random() * 30,
    }
  }

  function random() {
    return Math.round(Math.random() * 10000)
  }

  const chartOptions = {
    legend: { display: false },
    tooltips: { enabled: false },
    layout: {
      padding: {
        left: 10,
        right: 10
      }
    },
    scales: {
      xAxes: [
        {
          display: false,
          categoryPercentage: 0.8,
          barPercentage: 0.6,
        }
      ],
      yAxes: [
        { display: false }
      ]
    }
  }

  export default {
    components: { EMetric, EBarChart },
    data: function() {
      return {
        data,
        options: chartOptions,
        period: Object.keys(data)[0]
      }
    },
    computed: {
      chartData: function() {
        const dataset = this.data[this.period];
        return {
          labels: Object.keys(dataset),
          datasets: [
            {
              label: "Outcome Trend",
              backgroundColor: '#686e71',
              data: Object.keys(dataset).map((key) => dataset[key]),
            }
          ]
        }
      }
    },
    filters: {
      /**
       * capitalize('abc')  ->  'Abc'
       */
      capitalize: function capitalize(value) {
        let string = value.toString()
        if (!value) {
          return ''
        }
        return string.charAt(0).toUpperCase().concat(string.slice(1))
      },
      /**
       * formatNumber(1000)  ->  '1,000'
       * formatNumber(-1000, '$', 2)  ->  '-$1,000.00'
       */
      formatNumber: function(n, currency = '', a) {
          let c = isNaN(c = Math.abs(a)) ? 0 : a,
              d = d == undefined ? "." : d,
              t = t == undefined ? "," : t,
              s = n < 0 ? "-" : "",
              i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
              j = (j = i.length) > 3 ? j % 3 : 0;
         return s + currency + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
      }
    }
  }
</script>
