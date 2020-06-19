<template>
  <div>
    <el-row>
      <el-col :span="16">&nbsp;</el-col>
      <el-col :span="8">
        <el-row no-gutter style="position:absolute; top:30px;">
          <el-col :span="16">
            <div class="step-title">Tampilkan Tahap:</div>
          </el-col>
          <el-col :span="8">
            <el-select v-model="stepSelected" style="30%" @change="handleChangeStep($event)">
              <el-option
                v-for="item in stepList"
                :key="item.value"
                :label="item.label"
                :value="item"
              />
            </el-select>
          </el-col>
        </el-row>
      </el-col>
    </el-row>
  </div>
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
      stepSelected: null,
      stepList: [
        { value: '1', label: 'TAHAP 1' },
        { value: '2', label: 'TAHAP 2' }
      ]
    }
  },
  created() {
    this.stepSelected = { value: '2', label: 'TAHAP 2' }
    this.setDefaultStep()
  },
  methods: {
    setDefaultStep() {
      this.listQuery.tahap = this.stepSelected.value
    },
    handleChangeStep(row) {
      this.listQuery.tahap = this.stepSelected.value
      this.$emit('handle-change-step')
    }
  }
}
</script>
<style >
.step-title {
  margin-top: 8px;
  font-weight: bold;
  font-size: 18px;
  width: 100%;
  text-align: right;
  padding-right: 10px;
}
</style>
