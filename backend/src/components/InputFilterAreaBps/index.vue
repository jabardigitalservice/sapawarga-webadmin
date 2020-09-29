<template>
  <div>
    <el-row :gutter="10">
      <el-col v-if="enableKabkota" :span="colsWidht">
        <el-select
          v-model="kabkota_selected"
          clearable
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

      <el-col v-if="enableKecamatan" :span="colsWidht">
        <el-select
          v-model="kecamatan_selected"
          :disabled="enableKabkota === true && (kabkota_selected === '' || kabkota_selected === null)"
          clearable
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

      <el-col v-if="enableKelurahan" :span="colsWidht">
        <el-select
          v-model="kelurahan_selected"
          :disabled="enableKecamatan === true && (kecamatan_selected === '' || kecamatan_selected === null)"
          clearable
          filterable
          placeholder="Pilih Desa/Kelurahan"
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
import { getKabkotaList, getKecamatanBpsList, getKelurahanBpsList } from '@/api/areas'
import { RolesUser } from '@/utils/constantVariable'
import checkPermission from '@/utils/permission'

export default {
  name: 'InputFilterArea',
  props: {
    enableRolePolicy: {
      type: Boolean,
      default: true
    },

    kabkotaId: {
      type: String,
      default: null
    },

    kecId: {
      type: String,
      default: null
    },

    kelId: {
      type: String,
      default: null
    },

    parentId: {
      type: Number,
      default: null
    },

    isBnbaStaffprov: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      RolesUser,
      kabkota_selected: null,
      kecamatan_selected: null,
      kelurahan_selected: null,
      kabkota_options: [],
      kecamatan_options: [],
      kelurahan_options: [],
      colsWidht: 8
    }
  },

  computed: {
    enableKabkota() {
      if (this.enableRolePolicy === true) {
        return checkPermission([this.RolesUser.ADMIN, this.RolesUser.STAFFPROV, this.RolesUser.STAFFOPD])
      }

      return false
    },

    enableKecamatan() {
      if (this.enableRolePolicy === true) {
        return checkPermission([this.RolesUser.ADMIN, this.RolesUser.STAFFPROV, this.RolesUser.STAFFOPD, this.RolesUser.STAFFKABKOTA])
      }

      return false
    },

    enableKelurahan() {
      if (this.enableRolePolicy === true) {
        return checkPermission([this.RolesUser.ADMIN, this.RolesUser.STAFFPROV, this.RolesUser.STAFFOPD, this.RolesUser.STAFFKABKOTA, this.RolesUser.STAFFKEC])
      }

      return false
    }
  },

  watch: {
    kabkotaId: {
      handler: function(value) {
        this.kabkota_selected = value
      },
      immediate: true
    },

    kecId: {
      handler: function(value) {
        this.kecamatan_selected = value
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
    if (checkPermission([this.RolesUser.STAFFKABKOTA])) {
      this.colsWidht = 12
    } else if (checkPermission([this.RolesUser.STAFFKEC])) {
      this.colsWidht = 24
    } else if (checkPermission([this.RolesUser.STAFFKEL])) {
      this.colsWidht = 0
    }
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
          value: item.code_bps,
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

      const { data } = await getKecamatanBpsList(parentId, true)

      this.kecamatan_options = data.items.map(item => {
        return {
          value: item.code_bps,
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

      const { data } = await getKelurahanBpsList(parentId, true)

      this.kelurahan_options = data.items.map(item => {
        return {
          value: item.code_bps,
          label: item.name
        }
      })
    },

    init() {
      this.getKabkotaOptions()

      if (this.enableKabkota === false || this.isBnbaStaffprov) {
        this.getKecamatanOptions(this.parentId)
      }

      if (this.enableKecamatan === false) {
        this.getKelurahanOptions(this.parentId)
      }
    }
  }
}
</script>
