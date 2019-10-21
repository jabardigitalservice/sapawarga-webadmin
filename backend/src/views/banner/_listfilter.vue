<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10">
        <el-col :span="(isPopUp) ? 12 : 10">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.title" :placeholder="(isPopUp) ? 'Judul Pop Up' : 'Judul Banner'" />
          </el-form-item>
        </el-col>
        <el-col :span="(isPopUp) ? 8 : 5">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.type"
              clearable
              filterable
              placeholder="Kategori"
              style="width: 100%"
            >
              <el-option
                v-for="item in type"
                :key="item.value"
                :label="item.name"
                :value="item.value"
              />
            </el-select>
          </el-form-item>
        </el-col>
        <div v-if="(!isPopUp)">
          <el-col :span="5">
            <el-form-item style="margin-bottom: 0">
              <el-select
                v-model="listQuery.status"
                clearable
                filterable
                placeholder="Status"
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
        </div>
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
export default {
  props: {
    listQuery: {
      type: Object,
      default: null
    },
    isPopUp: {
      type: Boolean,
      default: false
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
