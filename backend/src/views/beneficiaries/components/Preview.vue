<template>
  <div class="components-container">
    <h1>Preview</h1>
    <el-button @click="update">Kirim</el-button>
    <el-button @click="back">back</el-button>
  </div>
</template>
<script>
import { update } from '@/api/beneficiaries'

export default {
  props: {
    beneficiaries: {
      type: Object,
      default: null
    }
  },
  methods: {
    async update() {
      delete this.beneficiaries.nik
      this.beneficiaries.status_verification = 3
      const id = await this.$route.params && this.$route.params.id
      await update(id, this.beneficiaries)
      this.$router.push('/beneficiaries/index')
    },
    back() {
      this.$emit('nextStep', false)
    }
  }
}
</script>
