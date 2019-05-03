<template>
  <div>
    <el-row v-if="enableKabkota" style="margin-bottom: 15px">
      <el-col :span="8">
        <el-select
          v-model="kabkota_selected"
          filterable
          placeholder="Pilih Kabupaten/Kota"
          style="width: 100%"
          @change="changeSelection($event, 'changeKabkota')"
        >
          <el-option
            v-for="item in kabkota_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>
    </el-row>

    <el-row v-if="enableKecamatan" style="margin-bottom: 15px">
      <el-col :span="8">
        <el-select
          v-model="kecamatan_selected"
          :disabled="enableKabkota === true && (kabkota_selected === '' || kabkota_selected === null)"
          filterable
          placeholder="Pilih Kecamatan"
          style="width: 100%"
          @change="changeSelection($event, 'changeKecamatan')"
        >
          <el-option
            v-for="item in kecamatan_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>
    </el-row>

    <el-row v-if="enableKelurahan">
      <el-col :span="8">
        <el-select
          v-model="kelurahan_selected"
          :disabled="enableKecamatan === true && (kecamatan_selected === '' || kecamatan_selected === null)"
          filterable
          placeholder="Pilih Kelurahan"
          style="width: 100%"
          @change="changeSelection($event, 'changeKelurahan')"
        >
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
import checkPermission from '@/utils/permission'

export default {
  name: 'InputFilterArea',
  props: {
    enableRolePolicy: {
      type: Boolean,
      default: true
    },

    kabkotaId: {
      type: Number,
      default: null
    },

    kecId: {
      type: Number,
      default: null
    },

    kelId: {
      type: Number,
      default: null
    },
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

  computed: {
    enableKabkota() {
      if (this.enableRolePolicy === true) {
        return checkPermission(['admin', 'staffProv'])
      }

      return false
    },

    enableKecamatan() {
      if (this.enableRolePolicy === true) {
        return checkPermission(['admin', 'staffProv', 'staffKabkota'])
      }

      return false
    },

    enableKelurahan() {
      if (this.enableRolePolicy === true) {
        return checkPermission(['admin', 'staffProv', 'staffKabkota', 'staffKec'])
      }

      return false
    },

    parentId() {
      const authUser = this.$store.state.user

      if (checkPermission(['staffKabkota'])) {
        return parseInt(authUser.kabkota_id)
      }

      if (checkPermission(['staffKec'])) {
        return parseInt(authUser.kec_id)
      }

      return null
    }
  },

  watch: {
    kabkotaId: {
      handler: function(value) {
        this.kabkota_selected = value

        this.changeSelection(value, 'changeKabkota')
      },
      immediate: true
    },

    kecId: {
      handler: function(value) {
        this.kecamatan_selected = value

        this.changeSelection(value, 'changeKecamatan')
      },
      immediate: true
    },

    kelId: {
      handler: function(value) {
        this.kelurahan_selected = value
      },
      immediate: true
    }
  },

  mounted() {
    this.init()
  },

  methods: {
    changeSelection(value, type) {
      if (type === 'changeKabkota' && value !== '') {
        this.kecamatan_selected = null
        this.kelurahan_selected = null

        this.kecamatan_options = []
        this.kelurahan_options = []

        this.getKecamatanOptions(value)
      }

      if (type === 'changeKecamatan' && value !== '') {
        this.kelurahan_selected = null

        this.kelurahan_options = []

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
      // Jika parentId null, skip request, karena akan timeout (terlalu banyak data)
      if (parentId === null) {
        return false
      }

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
      // Jika parentId null, skip request, karena akan timeout (terlalu banyak data)
      if (parentId === null) {
        return false
      }

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
