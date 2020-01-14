<template>
  <el-card class="box-card" style="margin-bottom: 10px" :xs="24">
    <el-form>
      <el-row :gutter="10">
        <el-col :xs="{span:12, tag:'mb-10'}" :sm="8" :md="8">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.search" placeholder="Judul" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span: 12, tag:'mb-10'}" :span="12">
          <el-form-item class="waktu-publikasi">
            <el-row :gutter="12" type="flex">
              <el-col :xs="12" :sm="8" :lg="12">
                <el-date-picker
                  v-model="listQuery.start_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd HH:mm:ss"
                  value-format="yyyy-MM-dd HH:mm:ss"
                  :placeholder="$t('popup.popup-start-date')"
                />
              </el-col>
              <el-col :xs="12" :sm="8" :lg="12">
                <el-date-picker
                  v-model="listQuery.end_date"
                  class="pop-up-date"
                  type="datetime"
                  format="yyyy-MM-dd HH:mm:ss"
                  value-format="yyyy-MM-dd HH:mm:ss"
                  :placeholder="$t('popup.popup-end-date')"
                />
              </el-col>
            </el-row>
          </el-form-item>
        </el-col>
        <el-col :xs="4" :sm="4">
          <el-button type="primary" size="small" @click="submitSearch">{{ $t('crud.search') }}</el-button>
          <el-button type="primary" size="small" @click="resetFilter">{{ $t('crud.reset') }}</el-button>
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
      options: []
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
</style>
