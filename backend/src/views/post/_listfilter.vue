<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="12">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.title" placeholder="Nama Kegiatan" />
          </el-form-item>
        </el-col>
        <el-col :span="7">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.status"
              clearable
              filterable
              placeholder="Pilih Status"
              style="width: 100%"
            >
              <el-option value="10" label="Aktif" />
              <el-option value="0" label="Tidak Aktif" />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-button type="primary" size="small" @click="submitSearch">
            Cari
          </el-button>
          <el-button type="primary" size="small" @click="resetFilter">
            Reset
          </el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>


export default {
  components: {
    
  },
  props: {
    listQuery: {
      type: Object,
      default: null
    },
    status: {
      type: String,
      default: null
    }
  },

  data() {
    return {
      checkStaff: false
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
