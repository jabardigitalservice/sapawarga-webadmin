<template>
  <el-card class="box-card" style="margin-bottom: 10px" :xs="24">
    <el-form>
      <el-row :gutter="10">
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="20">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.search" :placeholder="$t('label.beneficiaries-download-search-subdistrict-placeholder')" />
          </el-form-item>
        </el-col>
        <el-col :xs="24" :sm="4">
          <el-button type="primary" size="small" @click="submitSearch">{{ $t('crud.search') }}</el-button>
          <el-button type="primary" size="small" @click="resetFilter">{{ $t('crud.reset') }}</el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
export default {
  props: {
    listQuery: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      options: []
    }
  },
  methods: {
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
