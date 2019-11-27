<template>
  <div>
    <el-row>
      <el-form>
        <el-col :lg="20" :sm="20" :xs="20">
          <el-form-item>
            <el-input v-model="name" placeholder="Cari Pengguna" @keyup.enter.native="onSubmitSearch">
              <i slot="prefix" class="el-input__icon el-icon-search" />
            </el-input>
          </el-form-item>
        </el-col>
        <el-col :lg="4" :sm="4" :xs="4">
          <el-form-item class="style-user-select">
            <el-select v-model="kabkota" placeholder="" @change="onSelection">
              <el-option
                v-for="item in KabKotaList"
                :key="item.id"
                :value="item.id"
                :label="item.name"
              >{{ item.name }}</el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-form>
    </el-row>
  </div>
</template>

<script>
import { getKabkotaList } from '@/api/areas'
export default {
  props: {
    propsName: {
      type: String,
      required: false
    },
    propsKabKota: {
      type: Number,
      required: false
    }
  },
  data() {
    return {
      name: null,
      kabkota: null,
      KabKotaList: null
    }
  },
  watch: {
    propsName: {
      handler: function(propsName) {
        this.name = propsName
      },
      immediate: true
    },
    propsKabKota: {
      handler: function(propsKabKota) {
        this.kabkota = propsKabKota
      },
      immediate: true
    }
  },
  async created() {
    await this.getListKabKota()
  },
  methods: {
    onSubmitSearch() {
      this.$emit('changeNameInput', this.name)
    },
    onSelection() {
      this.$emit('changeKabKota', this.kabkota)
    },
    async getListKabKota() {
      const response = await getKabkotaList()
      this.KabKotaList = await response.data.items
    }
  }
}
</script>
