<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="10" :xl="10">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.target') }}</span>
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
            <span>{{ $t('label.description') }}</span>
          </div>
          <el-table stripe :data="tableDataPesan" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="200" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-button v-if="!btnKirimDisable" class="button-send" type="primary" @click="actionApprove(status.PUBLISHED)">{{ $t('crud.send') }}</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, update } from '@/api/broadcast'
import { parsingDatetime } from '@/utils/datetimeToString'

export default {
  data() {
    return {
      id: 0,
      tableDataTarget: [],
      tableDataPesan: [],
      broadcast: null,
      btnKirimDisable: false,
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      }
    }
  },

  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },

  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { title, description, category, kabkota, kecamatan, kelurahan, rw, status, status_label, scheduled_datetime, is_scheduled } = response.data
        this.broadcast = response.data

        if (status === this.status.DRAFT) {
          this.btnKirimDisable = false
        } else {
          this.btnKirimDisable = true
        }

        this.tableDataTarget = [
          {
            title: this.$t('label.area-kabkota'),
            content: ((kabkota !== null) ? kabkota.name : 'Semua Kab/Kota')
          },
          {
            title: this.$t('label.area-kec'),
            content: ((kecamatan !== null) ? kecamatan.name : 'Semua Kecamatan')
          },
          {
            title: this.$t('label.area-kel'),
            content: ((kelurahan !== null) ? kelurahan.name : 'Semua Desa/Kelurahan')
          },
          {
            title: this.$t('label.area-rw'),
            content: ((rw !== null) ? rw : 'Semua RW')
          }
        ]

        this.tableDataPesan = [
          {
            title: this.$t('label.title-broadcast'),
            content: (title !== null ? title : '-')
          },
          {
            title: this.$t('label.category'),
            content: (category !== null ? category.name : '-')
          },
          {
            title: this.$t('label.status'),
            content: (status === this.status.SCHEDULED ? <el-tag type='warning'>{status_label}</el-tag> : status === this.status.PUBLISHED ? <el-tag type='success'>{status_label}</el-tag> : <el-tag type='info'>{status_label}</el-tag>)
          },
          {
            title: this.$t('label.scheduled'),
            content: is_scheduled === false ? 'Sekarang' : 'Terjadwal'
          },
          {
            title: this.$t('label.scheduled_datetime'),
            content: parsingDatetime(scheduled_datetime)
          },
          {
            title: this.$t('label.description'),
            content: (description !== null ? description : '-')
          }
        ]

        if (scheduled_datetime === null) {
          this.tableDataPesan.splice(4, 1)
        }

        if (status === this.status.PUBLISHED || status === this.status.SCHEDULED) {
          this.tableDataPesan.splice(3, 1)
        }
      })
    },
    async submitForm(status) {
      const id = this.$route.params && this.$route.params.id
      const data = {}
      Object.assign(data, this.broadcast)
      data.status = status
      await update(id, data)
      this.$message.success(this.$t('crud.send-success'))
      this.$router.push('/broadcast/index')
    },
    async actionApprove(status) {
      await this.$confirm(this.$t('message.confirmation-send-message') + `${this.broadcast.title}` + '?', this.$t('message.title'), {
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

<style lang="scss">
.button-send {
  margin-top: 30px;
  display: block;
}

@media only screen and (max-width: 1200px) {
  .col-right {
    margin-top: 20px;
    margin-right: 20px !important
  }
}
</style>
