<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.search" placeholder="Judul" />
          </el-form-item>
        </el-col>
        <el-col :span="4">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.source" placeholder="Sumber" />
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.viewers" placeholder="Jumlah Pengunjung" />
          </el-form-item>
        </el-col>
        <el-col :span="2">
          <el-form-item style="margin-bottom: 0">
            <el-date-picker
              v-model="listQuery.source_date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              placeholder="Pilih Tanggal"
            />
          </el-form-item>
        </el-col>
      </el-row>

      <el-row :gutter="10" type="flex" class="mt-10">
        <el-col :span="24">
          <el-button type="primary" size="small" @click="submitSearch">Cari</el-button>
          <el-button type="primary" size="small" @click="resetFilter">Reset</el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import InputFilterArea from "@/components/InputFilterArea";

import checkPermission from "@/utils/permission";

export default {
  components: { InputFilterArea },

  props: {
    listQuery: {
      type: Object,
      default: null
    }
  },

  methods: {
    checkPermission,

    submitSearch() {
      console.log(this.listQuery);
      this.$emit("submit-search");
    },

    resetFilter() {
      this.$emit("reset-search");
    }
  }
};
</script>

<style lang="scss" scoped>
  .mt-10 {
      margin-top: 10px;
  }
</style>
