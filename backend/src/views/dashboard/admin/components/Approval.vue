<template>
  <el-card class="box-card">
    <el-table v-loading="listLoading" :data="list" stripe style="width: 100%">
      <el-table-column prop="accept" :label="$t('label.aspiration-accept')" align="center" />
      <el-table-column prop="publish" :label="$t('label.aspiration-publish')" align="center" />
    </el-table>
  </el-card>

</template>

<script>
import { fetchAspirasiCounts } from '@/api/dashboard'

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
      fetchAspirasiCounts().then(response => {
        const responseData = response.data
        this.list = [{
          accept: responseData.STATUS_APPROVAL_PENDING,
          publish: responseData.STATUS_PUBLISHED
        }]
        this.listLoading = false
      })
    }
  }
}
</script>
