<template>
  <el-col :lg="24" :sm="24" :xs="24">
    <el-form>
      <el-col :lg="24" :sm="24" :xs="24">
        <el-form-item>
          <el-input v-model="name" name="name" placeholder="Cari Pertanyaan" @keyup.enter.native="onSubmitSearch">
            <i slot="prefix" class="el-input__icon el-icon-search" />
          </el-input>
        </el-form-item>
      </el-col>
    </el-form>
  </el-col>
</template>

<script>
export default {
  name: 'FilterQuestions',
  data() {
    return {
      name: null
    }
  },
  async created() {
    //
  },
  methods: {
    onSubmitSearch() {
      this.$emit('changeNameInput', this.name)
    }
  }
}
</script>
