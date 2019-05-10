<template>
  <div>
    <el-row>
      <el-col :span="6">
        <el-form>
          <el-form-item label="Latitude">
            <el-input v-model="latitude" placeholder="Contoh: -6.943097" @input="change" />
          </el-form-item>

          <el-form-item label="Longitude">
            <el-input v-model="longitude" placeholder="Contoh: 107.633545" @input="change" />
          </el-form-item>
        </el-form>
      </el-col>
      <el-col />
    </el-row>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      latitude: null,
      longitude: null
    }
  },
  watch: {
    value: {
      handler: function(value) {
        this.latitude = value[0]
        this.longitude = value[1]
      },
      immediate: true
    }
  },
  methods: {
    change() {
      this.$emit('input', [this.latitude, this.longitude])
    }
  }
}
</script>
