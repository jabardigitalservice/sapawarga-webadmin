<template>
  <el-col :lg="24" :sm="24" :xs="24">
    <el-col :lg="24" :sm="24" :xs="24">
      <el-input
        v-model="search"
        name="search"
        placeholder="Cari Pertanyaan"
        @keyup.enter.native="onSubmitSearch"
      >
        <i slot="prefix" class="el-input__icon el-icon-search" />
      </el-input>
    </el-col>
  </el-col>
</template>

<script>
export default {
  name: 'FilterQuestions',
  data() {
    return {
      search: null
    }
  },
  async created() {
    //
  },
  methods: {
    onSubmitSearch() {
      this.$emit('changeNameInput', this.search)
    }
  }
}
</script>
