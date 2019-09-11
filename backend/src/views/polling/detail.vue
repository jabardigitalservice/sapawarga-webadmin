<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="13" :xl="13">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Target</span>
          </div>
          <el-table stripe :data="tableDataTarget" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-card style="margin-top:10px">
          <div slot="header" class="clearfix">
            <span>Data Polling</span>
          </div>
          <el-table stripe :data="tableDataPolling" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-button v-if="!btnKirimDisable" :disabled="btnDisableDate" class="button-send" type="primary" @click="actionApprove(status.active)">{{ $t('crud.send-polling') }}</el-button>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="11" :xl="11">
        <div style="margin-top:0px">
          <el-card>
            <div slot="header" class="clearfix">
              <span>Hasil Polling</span>
            </div>
              <PollingChart />
          </el-card>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import PollingChart from '@/components/PollingChart'
import { fetchRecord, fetchResult, update } from '@/api/polling'
import moment from 'moment'
export default {
components: {
    PollingChart
  },
  data() {
    return {
      id: 0,
      tableDataTarget: [],
      tableDataPolling: [],
      btnKirimDisable: false,
      btnDisableDate: false,
      polling: null,
      status: {
        draft: 0,
        active: 10
      }
    }
  },
  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
    this.getResult()
  },
  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { kabkota, kecamatan, kelurahan, rw, name, category, description, excerpt, start_date, end_date, question, status, status_label, answers } = response.data
        this.polling = response.data

        function logArrayAnswers(value, index, array) {
          return <el-radio label=''>{ value.body }</el-radio>
        }

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
            title: 'Kabupaten/Kota',
            content: ((kabkota !== null) ? kabkota.name : 'Semua Kab/Kota')
          },
          {
            title: 'Kecamatan',
            content: ((kecamatan !== null) ? kecamatan.name : 'Semua Kecamatan')
          },
          {
            title: 'Desa/Kelurahan',
            content: ((kelurahan !== null) ? kelurahan.name : 'Semua Kelurahan')
          },
          {
            title: 'RW',
            content: ((rw !== null) ? rw : 'Semua RW')
          }
        ]

        this.tableDataPolling = [
          {
            title: 'Nama Survey',
            content: name || '-'
          },
          {
            title: 'Kategori',
            content: (category !== null ? category.name : '-')
          },
          {
            title: 'Deskripsi',
            content: description || '-'
          },
          {
            title: 'Pengantar',
            content: excerpt || '-'
          },
          {
            title: 'Dimulai dari',
            content: moment(start_date).format('D MMMM YYYY') || '-'
          },
          {
            title: 'Sampai',
            content: moment(end_date).format('D MMMM YYYY') || '-'
          },
          {
            title: 'Status',
            content: (status === 1 ? <el-tag type='danger'>Tidak Aktif</el-tag> : status === 10 && expired === true && beforeStart === false ? <el-tag type='warning'>Berakhir</el-tag> : status === 10 && expired === false && beforeStart === false ? <el-tag type='success'>Sedang Berlangsung</el-tag> : status === 10 && beforeStart === true && expired === false ? <el-tag type='primary'>Dipublikasikan</el-tag> : <el-tag type='info'>{status_label}</el-tag>)
          },
          {
            title: 'Pertanyaan',
            content: question || '-'
          },
          {
            content: answers.map(logArrayAnswers)
          }
        ]
      })
    },
    getResult() {
      fetchResult(this.id).then(response => {
        const one = response.data
        console.log(one)
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
      await this.$confirm(`Apakah Anda yakin akan mengirimkan polling: ${this.polling.name} ?`, 'Konfirmasi', {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'success'
      })

      try {
        this.submitForm(status)
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.button-send {
  margin-top: 10px;
  float: right;
}
</style>

