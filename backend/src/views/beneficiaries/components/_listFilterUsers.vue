<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10">
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="8">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.nik" placeholder="NIK" @keyup.enter.native="submitSearch()" />
          </el-form-item>
        </el-col>
        <el-col :xs="24" :sm="24" :md="4">
          <el-button type="primary" size="small" @click="submitSearch">
            {{ $t('crud.search') }}
          </el-button>
          <el-button type="primary" size="small" @click="resetFilter">
            {{ $t('crud.reset') }}
          </el-button>
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
  methods: {
    submitSearch() {
      if (!this.listQuery.nik) {
        return
      }

      this.$emit('submit-search')
    },
    resetFilter() {
      this.$emit('reset-search')
    }
  }
}
</script>
