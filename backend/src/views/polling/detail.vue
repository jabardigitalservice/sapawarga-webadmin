<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="{span:24, tag:'mb-10'}" :sm="24" :md="24" :lg="colSize" :xl="colSize">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.target') }}</span>
          </div>
          <el-table stripe :data="tableDataTarget" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-card style="margin-top:10px">
          <div slot="header" class="clearfix">
            <span>{{ $t('label.polling-data') }}</span>
          </div>
          <el-table stripe :data="tableDataPolling" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-button v-if="!btnKirimDisable" :disabled="btnDisableDate" class="button-send" type="primary" @click="actionApprove(status.active)">{{ $t('crud.send-polling') }}</el-button>
      </el-col>
      <el-col v-if="polling.status !== status.draft" class="col-right" :xs="24" :sm="24" :md="24" :lg="11" :xl="11">
        <div style="margin-top:0px">
          <el-card>
            <div slot="header" class="clearfix">
              <span>{{ $t('label.polling-total-audience') }}:</span>
              <span class="total_audience">{{ totalPolling }}</span>
            </div>
            <p class="question">{{ polling.question }}</p>
            <p class="date">{{ chartStart_date }} - {{ chartEnd_date }}</p>
            <PollingChart @childToParent="getFromChild" />
          </el-card>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { PollingStatus } from '@/utils/constantVariable'
import PollingChart from '@/components/PollingChart'
import { fetchRecord, update } from '@/api/polling'
import moment from 'moment'
export default {
  components: {
    PollingChart
  },
  data() {
    return {
      id: 0,
      PollingStatus,
      tableDataTarget: [],
      tableDataPolling: [],
      totalPolling: null,
      btnKirimDisable: false,
      btnDisableDate: false,
      chartStart_date: null,
      chartEnd_date: null,
      polling: {},
      colSize: 13,
      status: {
        draft: 0,
        active: 10
      }
    }
  },
  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
    this.getFromChild()
  },
  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        this.polling = response.data
        const { kabkota, kecamatan, kelurahan, rw, name, category, description, excerpt, start_date, end_date, status, status_label, question, answers } = response.data

        this.chartStart_date = moment(start_date).format('D MMMM YYYY')
        this.chartEnd_date = moment(end_date).format('D MMMM YYYY')

        if (status === 10) {
          this.btnKirimDisable = true
        } else if (status === 0) {
          this.btnKirimDisable = false
        }

        // count down date
        let expired = false
        let beforeStart = false

        const dateStart = moment(start_date).startOf('day')
        const dateSecond = moment(end_date).endOf('day')
        const currentDate = moment()

        const checkStartDate = currentDate - dateStart
        const distance = dateSecond - currentDate

        if (checkStartDate < 0) {
          beforeStart = true
          this.btnDisableDate = true
        }

        if (distance < 0) {
          expired = true
          this.btnDisableDate = true
        }
        // end of count down date

        this.tableDataTarget = [
          {
            title: this.$t('label.area-kabkota'),
            content: ((kabkota !== null) ? kabkota.name : this.$t('label.area-kabkota-all'))
          },
          {
            title: this.$t('label.area-kec'),
            content: ((kecamatan !== null) ? kecamatan.name : this.$t('label.area-kec-all'))
          },
          {
            title: this.$t('label.area-kel'),
            content: ((kelurahan !== null) ? kelurahan.name : this.$t('label.area-kel-all'))
          },
          {
            title: this.$t('label.area-rw'),
            content: ((rw !== null) ? rw : this.$t('label.area-rw-all'))
          }
        ]

        this.tableDataPolling = [
          {
            title: this.$t('label.polling-name'),
            content: name || '-'
          },
          {
            title: this.$t('label.category'),
            content: (category !== null ? category.name : '-')
          },
          {
            title: this.$t('label.polling-description'),
            content: description || '-'
          },
          {
            title: this.$t('label.polling-excerpt'),
            content: excerpt || '-'
          },
          {
            title: this.$t('label.status'),
            content: (status === 1 ? <el-tag type='danger'>{PollingStatus.INACTIVE}</el-tag> : status === 10 && expired === true && beforeStart === false ? <el-tag type='warning'>{PollingStatus.END}</el-tag> : status === 10 && expired === false && beforeStart === false ? <el-tag type='success'>{PollingStatus.LIVE}</el-tag> : status === 10 && beforeStart === true && expired === false ? <el-tag type='primary'>{PollingStatus.PUBLISHED}</el-tag> : <el-tag type='info'>{status_label}</el-tag>)
          }
        ]

        // show this data when status 'draft'

        function logArrayAnswers(value, index, array) {
          return <el-radio label=''>{ value.body }</el-radio>
        }

        if (this.polling.status === this.status.draft) {
          this.colSize = 18
          this.tableDataPolling.push(
            {
              title: this.$t('label.polling-start-date'),
              content: moment(start_date).format('D MMMM YYYY') || '-'
            },
            {
              title: this.$t('label.polling-end-date'),
              content: moment(end_date).format('D MMMM YYYY') || '-'
            },
            {
              title: this.$t('label.polling-question'),
              content: question || '-'
            },
            {
              content: answers.map(logArrayAnswers)
            })
        }
      })
    },
    async submitForm(status) {
      const id = this.$route.params && this.$route.params.id
      const data = {}
      Object.assign(data, this.polling)
      data.status = status
      await update(id, data)
      this.$message.success(this.$t('crud.publish-polling'))
      this.$router.push('/polling/index')
    },
    async actionApprove(status) {
      await this.$confirm(this.$t('label.polling-confirm') + ` : ${this.polling.name} ?`, this.$t('message.title'), {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'success'
      })

      try {
        this.submitForm(status)
      } catch (e) {
        console.log(e)
      }
    },
    getFromChild(value) {
      this.totalPolling = value
    }
  }
}
</script>
<style lang="scss" scoped>
.button-send {
  margin-top: 10px;
  float: right;
}
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

