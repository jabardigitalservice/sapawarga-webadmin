<template>
  <div>
    <el-row>
      <el-col :lg="20" :sm="20" :xs="20">
        <el-form>
          <el-form-item>
            <el-input v-model="name" placeholder="Cari Pengguna">
              <i slot="prefix" class="el-input__icon el-icon-search" @click="onSubmitSearch" />
            </el-input>
          </el-form-item>
        </el-form>
      </el-col>
      <el-col :lg="4" :sm="4" :xs="4">
        <el-form>
          <el-form-item style="padding-left: 10px;">
            <el-button type="primary" icon="el-icon-star-off" circle />
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>

export default {
  props: {
    value: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      name: null
    }
  },
  watch: {
    value: {
      handler: function(value) {
        this.name = value
      },
      immediate: true
    }
  },
  methods: {
    onSubmitSearch() {
      this.$emit('input', this.name)
    }
  }
}
</script>
