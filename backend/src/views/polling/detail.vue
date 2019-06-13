<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="10" :xl="10">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Target</span>
          </div>
          <el-table stripe :data="tableDataTarget" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="14" :xl="14">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Data Polling</span>
          </div>
          <el-table stripe :data="tableDataPolling" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-button v-if="btnKirimDisable" class="button-send" type="primary" @click="submitForm(status.active)">{{ $t('crud.send-polling') }}</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/polling'
export default {
  data() {
    return {
      id: 0,
      tableDataTarget: [],
      tableDataPolling: [],
      btnKirimDisable: false
    }
  },
  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },
  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        console.log(response)
        const { kabkota, kecamatan, kelurahan, rw, name, category, description, excerpt, start_date, end_date, question, status, status_label, answers } = response.data
        
        // count down date
        let dateFirst = new Date(start_date).getTime()
        let dateSecond = new Date('June 10, 2019 15:37:25').getTime()

        let interval = setInterval(() => {

          
          let currentDate = new Date().getTime()

          let distance = dateSecond - currentDate
          let days = Math.floor(distance / (1000 * 60 * 60 * 24))
          let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
          let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
          let seconds = Math.floor((distance % (1000 * 60)) / 1000)

          console.log(days, hours, minutes, seconds)

          if (distance < 0) {
            clearInterval(interval);
            console.log('EXPIRED')
          }

        }, 2000)

        if (status === 10) {
          this.btnKirimDisable = true
        } else if (status === 0) {
          this.btnKirimDisable = false
        }

        this.tableDataTarget = [
          {
            title: 'Kota',
            content:  ((kabkota !== null) ? kabkota.name : 'Semua Kab/Kota')
          },
          {
            title: 'Kecamatan',
            content:  ((kecamatan !== null) ? kecamatan.name : 'Semua Kecamatan')
          },
          {
            title: 'Kelurahan/Desa',
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
            content: name
          },
          {
            title: 'Kategori',
            content: category.name
          },
          {
            title: 'Deskripsi',
            content: description
          },
          {
            title: 'Pengantar',
            content: excerpt
          },
          {
            title: 'Dimulai dari',
            content: start_date
          },
          {
            title: 'Sampai',
            content: end_date
          },
          {
            title: 'Status',
            content: (status === 5 ? <el-tag type='warning'>{status_label}</el-tag> : status === 3 ? <el-tag type='danger'>{status_label}</el-tag> : status === 10 ? <el-tag type='success'>{status_label}</el-tag> : <el-tag type='info'>{status_label}</el-tag>)
          },
          {
            title: 'Pertanyaan',
            content: question
          },
          {
            content: (<el-radio label="">{ answers[0].body }</el-radio>)
          },
          {
            content: (<el-radio label="">{ answers[1].body }</el-radio>)
          }
        ]
      })
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

