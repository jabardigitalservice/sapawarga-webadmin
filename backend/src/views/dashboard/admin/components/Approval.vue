<template>
  <el-card class="box-card">
    <el-table
      v-loading="listLoading"
      :data="list"
      stripe

      style="width: 100%"
    >
      <el-table-column
        prop="accept"
        label="Diterima"
        align="center"
      />
      <el-table-column
        prop="publish"
        label="Dipublikasikan"
        align="center"
      />
    </el-table>
  </el-card>

</template>

<script>
import { fetchApproval } from '@/api/dashboard'

export default {
  components: {},
  data() {
    return {
      list: null,
      listLoading: true
    }
  },
  created() {
    this.getApproval()
  },
  methods: {
    getApproval() {
      this.listLoading = true
      fetchApproval().then(response => {
        const responseAccept = response.data.items[0].total_count
        const responsePublish = response.data.items[1].total_count
        this.list = [{
          accept: responseAccept,
          publish: responsePublish
        }]
        this.listLoading = false
      })
    }
  }
}
</script>
