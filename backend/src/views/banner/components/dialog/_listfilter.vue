<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="18">
          <el-form-item style="margin-bottom: 0">
            <el-input v-if="fitur === 'survei'" v-model="listQuery.title" placeholder="Judul Survei" />
            <el-input v-if="fitur === 'polling'" v-model="listQuery.title" placeholder="Judul Polling" />
            <el-input v-if="fitur === 'berita'" v-model="listQuery.search" placeholder="Judul Berita" />
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-button type="primary" size="small" @click="submitSearch">Cari</el-button>
          <el-button type="primary" size="small" @click="resetFilter">Reset</el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import checkPermission from '@/utils/permission'
export default {
  props: {
    listQuery: {
      type: Object,
      default: null
    },
    fitur: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      options: []
    }
  },
  created() {

  },
  methods: {
    checkPermission,

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    }
  }
}
</script>

<style lang="scss" scoped>
.mt-10 {
  margin-top: 10px;
}
</style>
