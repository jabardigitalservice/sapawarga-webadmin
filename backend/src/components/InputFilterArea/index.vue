<template>
  <div>
    <el-row :gutter="10" type="flex" justify="end">
      <el-col :span="8">
        <el-select v-model="kabkota_selected" clearable filterable placeholder="Pilih Kabupaten/Kota" style="width: 100%" @change="changeSelection($event, 'changeKabkota')">
          <el-option
            v-for="item in kabkota_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>

      <el-col :span="8">
        <el-select v-model="kecamatan_selected" clearable filterable placeholder="Pilih Kecamatan" style="width: 100%" @change="changeSelection($event, 'changeKecamatan')">
          <el-option
            v-for="item in kecamatan_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>

      <el-col :span="8">
        <el-select v-model="kelurahan_selected" clearable filterable placeholder="Pilih Kelurahan" style="width: 100%" @change="changeSelection($event, 'changeKelurahan')">
          <el-option
            v-for="item in kelurahan_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { getKabkotaList, getKecamatanList, getKelurahanList } from '@/api/areas'

export default {
  props: {
    //
  },

  data() {
    return {
      kabkota_selected: null,
      kecamatan_selected: null,
      kelurahan_selected: null,
      kabkota_options: [],
      kecamatan_options: [],
      kelurahan_options: []
    }
  },

  mounted() {
    this.init()
  },

  methods: {
    changeSelection(value, type) {
      if (type === 'changeKabkota') {
        this.getKecamatanOptions(value)
      }

      if (type === 'changeKecamatan') {
        this.getKelurahanOptions(value)
      }

      this.$emit(type, value)
    },

    async getKabkotaOptions() {
      this.kabkota_options = []

      const { data } = await getKabkotaList(true)

      this.kabkota_options = data.items.map(item => {
        return {
          value: item.id,
          label: item.name
        }
      })
    },

    async getKecamatanOptions(parentId) {
      this.kecamatan_options = []

      const { data } = await getKecamatanList(parentId, true)

      this.kecamatan_options = data.items.map(item => {
        return {
          value: item.id,
          label: item.name
        }
      })
    },

    async getKelurahanOptions(parentId) {
      this.kelurahan_options = []

      const { data } = await getKelurahanList(parentId, true)

      this.kelurahan_options = data.items.map(item => {
        return {
          value: item.id,
          label: item.name
        }
      })
    },

    init() {
      this.getKabkotaOptions()
    }
  }
}
</script>
