<template>
  <div>
    <el-row>
      <el-col :span="8">
        <el-select
          v-model="kabkota_selected"
          filterable
          clearable
          placeholder="Semua Kabupaten/Kota"
          name="kabkota"
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

  </div>
</template>

<script>
import { getKabkotaList } from '@/api/areas'
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
    }
  },

  data() {
    return {
      RolesUser,
      kabkota_selected: null,
      kabkota_options: []
    }
  },

  computed: {
    enableKabkota() {
      if (this.enableRolePolicy === true) {
        return checkPermission([this.RolesUser.ADMIN, this.RolesUser.STAFFPROV, this.RolesUser.LEADER])
      }

      return true
    }
  },

  watch: {
    kabkotaId: {
      handler: function(value) {
        this.kabkota_selected = value

        this.changeSelection(value, 'changeKabkota')
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

    init() {
      const authUser = this.$store.state.user

      this.getKabkotaOptions()

      if (checkPermission([this.RolesUser.STAFFKABKOTA, this.RolesUser.STAFFKEC, this.RolesUser.STAFFKEL])) {
        this.kabkota_selected = authUser.kabkota_id

        this.changeSelection(this.kabkota_selected, 'changeKabkota')
      }
    }
  }
}
</script>
