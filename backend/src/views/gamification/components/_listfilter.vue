<template>
  <el-card class="box-card" style="margin-bottom: 10px" :xs="24">
    <el-form>
      <el-row :gutter="20">
        <el-col :xs="24" :sm="24" :lg="10">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.title" placeholder="Judul" />
          </el-form-item>
        </el-col>
        <el-col :xs="24" :sm="24" :md="10">
          <el-form-item class="waktu-publikasi">
            <el-date-picker
              v-model="listQuery.daterange"
              type="daterange"
              value-format="yyyy-MM-dd"
              :start-placeholder="$t('label.start-date')"
              :end-placeholder="$t('label.end-date')"
              align="center"
            />
          </el-form-item>
        </el-col>
        <el-col :xs="24" :sm="24" :md="4">
          <el-button type="primary" size="small" @click="resetFilter">{{ $t('crud.reset') }}</el-button>
          <el-button type="primary" size="small" @click="submitSearch">{{ $t('crud.search') }}</el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import checkPermission from '@/utils/permission'
import { newsChannelList } from '@/api/news'
export default {
  props: {
    listQuery: {
      type: Object,
      default: null
    },
    isPriority: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      options: [],
      value2: ''
    }
  },
  created() {
    this.getNewsChannel()
  },
  methods: {
    checkPermission,

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    },

    getNewsChannel() {
      newsChannelList().then(response => {
        this.options = response.data.items
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.mt-10 {
  margin-top: 10px;
}
.waktu-publikasi {
  .el-date-editor, .el-range-editor {
    width: 100% !important;
  }
}
</style>
