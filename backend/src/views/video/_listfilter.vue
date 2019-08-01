<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="12">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.title" placeholder="Judul Video" />
          </el-form-item>
        </el-col>
        <el-col :span="7">
          <el-form-item style="margin-bottom: 0">
            <InputCategory v-model="listQuery.category_id" name="category_id" category-type="video" prop="category" style="width: 100%" />
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
import checkPermission from '@/utils/permission'
import { requestArea } from '@/api/staff'
import InputCategory from '@/components/InputCategory'

export default {
  components: {
    InputCategory
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
