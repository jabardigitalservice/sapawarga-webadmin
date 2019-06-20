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

        <div style="margin-top: 25px">
          <el-button v-if="record && record.status === 0" type="primary" @click="submitForm">{{ $t('crud.survey-send') }}</el-button>

          <router-link :to="'/survey/index'">
            <el-button type="info">{{ $t('crud.back-to-list') }}</el-button>
          </router-link>
        </div>

      </el-col>
    </el-row>
  </div>
</template>

<script>
import moment from 'moment'
import { fetchRecord, update } from '@/api/survey'

import { getStatusColor, getStatusLabel } from './status'

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
        const { title, category, start_date, end_date, external_url, status, status_label } = response.data

        this.record = response.data

        const row = {
          start_date: start_date,
          end_date: end_date,
          status: status,
          status_label: status_label
        }

        this.tableDataRecord = [
          {
            title: 'Nama Survey',
            content: title
          },
          {
            title: 'Kategori',
            content: category.name
          },
          {
            title: 'Tanggal Mulai',
            content: moment(start_date).format('D MMMM YYYY')
          },
          {
            title: 'Tanggal Berakhir',
            content: moment(end_date).format('D MMMM YYYY')
          },
          {
            title: 'URL Survey',
            content: external_url
          },
          {
            title: 'Status',
            content: <el-tag type={getStatusColor(row)}>{getStatusLabel(row)}</el-tag>
          }
        ]
      })
    },

    async submitForm() {
      const id = this.$route.params && this.$route.params.id
      const statusActive = 10

      const data = {
        status: statusActive
      }

      await update(id, data)
      this.$message.success(this.$t('crud.publish-polling'))

      this.$router.push('/survey/index')
    }
  }
}
</script>
