<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10">
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.text" :placeholder="$t('label.post-title')" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.name" :placeholder="$t('label.post-name')" />
          </el-form-item>
        </el-col>
        <el-col :xs="{span:24, tag:'mb-10'}" :sm="24" :md="6">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.status"
              clearable
              filterable
              :placeholder="$t('label.status-select')"
              style="width: 100%"
            >
              <el-option value="10" :label="$t('label.active')" />
              <el-option value="0" :label="$t('label.inactive')" />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :xs="24" :sm="6" :md="6">
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
