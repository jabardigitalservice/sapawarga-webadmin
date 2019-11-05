<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10">
        <el-col :span="10">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.title" :placeholder="$t('label.newsImportant-title')" />
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-form-item style="margin-bottom: 0">
            <InputCategory v-model="listQuery.category_id" name="category_id" category-type="news_important" prop="category" style="width: 100%" />
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.status"
              clearable
              filterable
              :placeholder="$t('label.status')"
              style="width: 100%"
            >
              <el-option
                v-for="item in status"
                :key="item.value"
                :label="item.name"
                :value="item.value"
              />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="4">
          <el-button type="primary" size="small" @click="submitSearch">Cari</el-button>
          <el-button type="primary" size="small" @click="resetFilter">Reset</el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import checkPermission from '@/utils/permission'
import InputCategory from '@/components/InputCategory'
export default {
  components: { InputCategory },
  props: {
    listQuery: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      type: [
        {
          value: 'internal',
          name: 'Internal'
        },
        {
          value: 'external',
          name: 'External'
        }
      ],
      status: [
        {
          value: 0,
          name: 'Tidak Aktif'
        },
        {
          value: 10,
          name: 'Aktif'
        }
      ]
    }
  },
  methods: {
    checkPermission,

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
