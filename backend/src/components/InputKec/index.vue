<template>
  <div>
    <el-row>
      <el-col :span="8">
        <el-select
          v-model="kecamatan_selected"
          filterable
          clearable
          placeholder="Semua Kecamatan"
          name="kecamatan"
          style="width: 100%"
          :disabled="open"
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
  </div>
</template>

<script>
import { getKabkotaList, getKecamatanList, getKelurahanList } from '@/api/areas'
import { RolesUser } from '@/utils/constantVariable'
import checkPermission from '@/utils/permission'

export default {
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
    open: {
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
      kelurahan_options: []
    }
  },

  computed: {
    // enableKabkota() {
    //   if (this.enableRolePolicy === true) {
    //     return checkPermission([this.RolesUser.ADMIN, this.RolesUser.STAFFPROV, this.RolesUser.LEADER])
    //   }

    //   return true
    // },

    // enableKecamatan() {
    //   if (this.enableRolePolicy === true) {
    //     return checkPermission([this.RolesUser.ADMIN, this.RolesUser.LEADER, this.RolesUser.STAFFPROV, this.RolesUser.STAFFKABKOTA])
    //   }

    //   return true
    // },

    // enableKelurahan() {
    //   if (this.enableRolePolicy === true) {
    //     return checkPermission([this.RolesUser.ADMIN, this.RolesUser.LEADER, this.RolesUser.STAFFPROV, this.RolesUser.STAFFKABKOTA, this.RolesUser.STAFFKEC])
    //   }

    //   return true
    // }
  },

  watch: {
    kecId: {
      handler: function(value) {
        this.kecamatan_selected = value

        this.changeSelection(value, 'changeKecamatan')
      },
      immediate: true
    }
  },

  mounted() {
    this.init()
  },

  methods: {
    changeSelection(value, type) {
      if (value === '') {
        value = null
      }

      if (type === 'changeKabkota') {
        this.kecamatan_selected = null
        this.kelurahan_selected = null

        this.kecamatan_options = []
        this.kelurahan_options = []

        this.getKecamatanOptions(value)
      }

      if (type === 'changeKecamatan') {
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
      const authUser = this.$store.state.user

      this.getKabkotaOptions()

      if (checkPermission([this.RolesUser.STAFFKABKOTA, this.RolesUser.STAFFKEC, this.RolesUser.STAFFKEL])) {
        this.kabkota_selected = authUser.kabkota_id

        this.changeSelection(this.kabkota_selected, 'changeKabkota')
      }

      if (checkPermission([this.RolesUser.STAFFKEC, this.RolesUser.STAFFKEL])) {
        this.kecamatan_selected = authUser.kec_id

        this.changeSelection(this.kecamatan_selected, 'changeKecamatan')
      }

      if (checkPermission([this.RolesUser.STAFFKEL])) {
        this.kelurahan_selected = authUser.kel_id

        this.changeSelection(this.kelurahan_selected, 'changeKelurahan')
      }
    }
  }
}
</script>
