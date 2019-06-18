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
            <span>Isi Pesan</span>
          </div>
          <el-table stripe :data="tableDataPesan" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-button v-if="!btnKirimDisable" class="button-send" type="primary" @click="submitForm(status.active)">{{ $t('crud.send') }}</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, update } from '@/api/notification'

export default {
  data() {
    return {
      id: 0,
      tableDataTarget: [],
      tableDataPesan: [],
      notification: null,
      btnKirimDisable: false,
      status: {
        draft: 0,
        active: 10
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
        const { title, description, category, kabkota, kecamatan, kelurahan, rw, status } = response.data
        this.notification = response.data

        if (status === 10) {
          this.btnKirimDisable = true
        } else if (status === 0) {
          this.btnKirimDisable = false
        }

        this.tableDataTarget = [
          {
            title: 'Kota',
            content: ' : ' + ((kabkota !== null) ? kabkota.name : 'Semua Kab/Kota')
          },
          {
            title: 'Kecamatan',
            content: ' : ' + ((kecamatan !== null) ? kecamatan.name : 'Semua Kecamatan')
          },
          {
            title: 'Kelurahan/Desa',
            content: ' : ' + ((kelurahan !== null) ? kelurahan.name : 'Semua Kelurahan')
          },
          {
            title: 'RW',
            content: ' : ' + ((rw !== null) ? rw : 'Semua RW')
          }
        ]

        this.tableDataPesan = [
          {
            title: 'Judul Pesan',
            content: ': ' + (title !== null ? title : '-')
          },
          {
            title: 'Kategori',
            content: ': ' + (category !== null ? category.name : '-')
          },
          {
            title: 'Isi Pesan',
            content: ': ' + (description !== null ? description : '-')
          }
        ]
      })
    },
    async submitForm(status) {
      const id = this.$route.params && this.$route.params.id
      const data = {}
      Object.assign(data, this.notification)
      data.status = status
      await update(id, data)
      this.$message.success(this.$t('crud.send-success'))
      this.$router.push('/notification/index')
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
