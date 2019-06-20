<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">Detail Survey</a></p>

    <el-row>
      <el-col :sm="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Data Survey</span>
          </div>
          <el-table stripe :data="tableDataRecord" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>

        <el-button type="primary" style="margin-top: 25px">{{ $t('crud.survey-send') }}</el-button>

        <router-link :to="'/survey/index'">
          <el-button type="info">{{ $t('crud.cancel') }}</el-button>
        </router-link>

      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, update } from '@/api/survey'
export default {
  data() {
    return {
      tableDataRecord: [],
      record: null
    }
  },
  created() {
    const id = this.$route.params && this.$route.params.id
    this.getDetail(id)
  },
  methods: {
    getDetail(id) {
      fetchRecord(id).then(response => {
        const { title, category, start_date, end_date, external_url, status } = response.data

        this.record = response.data

        this.tableDataRecord = [
          {
            title: 'Nama Survey',
            content: title || '-'
          },
          {
            title: 'Kategori',
            content: (category !== null ? category.name : '-')
          },
          {
            title: 'Tanggal Mulai',
            content: start_date || '-'
          },
          {
            title: 'Tanggal Berakhir',
            content: end_date || '-'
          },
          {
            title: 'URL Survey',
            content: external_url || '-'
          },
          {
            title: 'Status',
            content: status || '-'
          }
        ]
      })
    },

    async submitForm(status) {
      const id = this.$route.params && this.$route.params.id
      const data = {}

      Object.assign(data, this.polling)
      data.status = status

      await update(id, data)
      this.$message.success(this.$t('crud.publish-polling'))

      this.$router.push('/survey/index')
    }
  }
}
</script>
