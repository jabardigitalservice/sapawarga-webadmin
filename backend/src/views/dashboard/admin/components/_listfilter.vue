<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="9">
          <el-form-item style="margin-bottom: 0">
            <InputCategory v-model="listQuery.category_id" name="category_id" category-type="aspirasi" prop="category" style="width: 100%" />
          </el-form-item>
        </el-col>
        <el-col :span="9">
          <el-form-item style="margin-bottom: 0">
            <el-select v-model="listQuery.kabkota_id" filterable clearable placeholder="Kota/Kabupaten">
              <el-option
                v-for="item in area"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="6">
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
import InputCategory from '@/components/InputCategory'

import { requestArea } from '@/api/staff'

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
      area: null
    }
  },

  created() {
    this.getArea()
  },

  methods: {

    changeKabkota(id) {
      this.listQuery.kabkota_id = id
    },

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    },

    getArea() {
      requestArea().then(response => {
        this.area = response.data.items
        console.log(this.area)
      })
    }

  }
}
</script>
