<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="8">
          <el-form-item style="margin-bottom: 0">
            <el-input v-model="listQuery.title" placeholder="Judul Video" />
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-form-item style="margin-bottom: 0">
            <el-select
              v-model="listQuery.status"
              clearable
              filterable
              placeholder="Pilih Status"
              style="width: 100%"
            >
              <el-option value="0" label="Tidak Aktif" />
              <el-option value="10" label="Aktif" />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-form-item style="margin-bottom: 0">
            <el-select v-model="listQuery.kabkota_id" :disabled="checkStaff" placeholder="Pilih Target">
              <el-option 
                v-for="item in area"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-button type="primary" size="small" @click="submitSearch">
            Cari
          </el-button>
          <el-button type="primary" size="small" @click="resetFilter">
            Reset
          </el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import checkPermission from '@/utils/permission'
import { requestArea } from '@/api/staff'
import InputCategory from '@/components/InputCategory'

export default {
  components: {
    InputCategory
  },
  props: {
    listQuery: {
      type: Object,
      default: null
    },
    status: {
      type: String,
      default: null
    }
  },

  data() {
    return {
      area: null,
      checkStaff: false
    }
  },

//   computed: {
//     filterAreaParentId() {
//       const authUser = this.$store.state.user

//       if (checkPermission(['staffKabkota'])) {
//         return parseInt(authUser.kabkota_id)
//       }

//       if (checkPermission(['staffKec'])) {
//         return parseInt(authUser.kec_id)
//       }

//       return null
//     }
//   },

  created() {
    this.init()
  },

  methods: {

    submitSearch() {
      this.$emit('submit-search')
    },

    resetFilter() {
      this.$emit('reset-search')
    },

    getArea() {
      requestArea().then(response => {
        this.area = response.data.items
        this.area.unshift({ id: 1, name: 'JAWA BARAT' })
      })
    },

    init() {
      const authUser = this.$store.state.user
      
      this.getArea()

      if (checkPermission(['staffKabkota'])) {
        this.listQuery.kabkota_id = authUser.kabkota_id
        this.checkStaff = true
      }

    },

  }
}
</script>
