<template>
  <div>
    <el-row>
      <el-col :span="16">&nbsp;</el-col>
      <el-col :span="8">
        <el-row no-gutter class="tahap-filter">
          <el-col :span="16">
            <div class="tahap-title">{{ $t('label.beneficiaries-show-tahap') }}</div>
          </el-col>
          <el-col :span="8">
            <el-select v-model="currentTahap" @change="handleChangeTahap($event)">
              <el-option
                v-for="item in tahapList"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import { fetchCurrentTahap } from '@/api/beneficiaries'

export default {
  props: {
    listQuery: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      currentTahap: null,
      tahapList: [
        { value: '1', label: 'TAHAP 1' },
        { value: '2', label: 'TAHAP 2' }
      ]
    }
  },
  created() {
    this.getCurrentTahap()
  },
  methods: {
    async getCurrentTahap() {
      const response = await fetchCurrentTahap()
      this.listQuery.tahap = Number(response.data.current_tahap_bnba)
      this.currentTahap = Number(response.data.current_tahap_bnba)
      this.$emit('handle-change-tahap')
    },
    handleChangeTahap(row) {
      this.listQuery.tahap = this.currentTahap
      this.$emit('handle-change-tahap')
    }
  }
}
</script>
<style >
.tahap-title {
  margin-top: 8px;
  font-weight: bold;
  font-size: 18px;
  width: 100%;
  text-align: right;
  padding-right: 10px;
}
.tahap-filter {
  position: absolute;
  top: 30px;
}
.tahap-option {
  width: 30%;
}
</style>
