<template>
  <div>
    <el-row :gutter="10" type="flex" justify="end">
      <el-col v-if="enableKabkota" :span="8">
        <el-select
          v-model="kabkota_selected"
          clearable
          filterable
          placeholder="Pilih Kabupaten/Kota"
          style="width: 100%"
          @change="changeSelection($event, 'changeKabkota')"
          @clear="clearSelection('clearKabkota')"
        >
          <el-option
            v-for="item in kabkota_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>

      <el-col v-if="enableKecamatan" :span="8">
        <el-select
          v-model="kecamatan_selected"
          clearable
          filterable
          placeholder="Pilih Kecamatan"
          style="width: 100%"
          @change="changeSelection($event, 'changeKecamatan')"
          @clear="clearSelection('clearKecamatan')"
        >
          <el-option
            v-for="item in kecamatan_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>

      <el-col v-if="enableKelurahan" :span="8">
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
    enableKabkota: {
      type: Boolean,
      default: true
    },

    enableKecamatan: {
      type: Boolean,
      default: true
    },

    enableKelurahan: {
      type: Boolean,
      default: true
    },

    parentId: {
      type: Number,
      default: null
    }
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
    clearSelection(type) {
      if (type === 'clearKabkota') {
        this.kecamatan_selected = null
        this.kelurahan_selected = null

        this.kecamatan_options = []
        this.kelurahan_options = []
      }

      if (type === 'clearKecamatan') {
        this.kelurahan_selected = null

        this.kelurahan_options = []
      }
    },

    changeSelection(value, type) {
      if (type === 'changeKabkota' && value !== '') {
        this.getKecamatanOptions(value)
      }

      if (type === 'changeKecamatan' && value !== '') {
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

      if (this.enableKabkota === false) {
        this.getKecamatanOptions(this.parentId)
      }

      if (this.enableKecamatan === false) {
        this.getKelurahanOptions(this.parentId)
      }
    }
  }
}
</script>
