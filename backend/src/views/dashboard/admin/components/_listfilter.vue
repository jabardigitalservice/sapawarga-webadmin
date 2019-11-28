<template>
  <el-card class="box-card" style="margin-bottom: 10px">
    <el-form>
      <el-row :gutter="10" type="flex">
        <el-col :span="colWidth">
          <el-form-item style="margin-bottom: 0">
            <InputCategory v-model="listQuery.category_id" name="category_id" category-type="aspirasi" prop="category" style="width: 100%" />
          </el-form-item>
        </el-col>
        <el-col v-if="roleAccess" :span="9">
          <el-form-item style="margin-bottom: 0">
            <el-select v-model="listQuery.kabkota_id" filterable clearable placeholder="Kota/Kabupaten">
              <el-option
                v-for="item in area"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="6">
          <el-button type="primary" size="small" @click="submitSearch">
            {{ $t('crud.search') }}
          </el-button>
          <el-button type="primary" size="small" @click="resetFilter">
            {{ $t('crud.reset') }}
          </el-button>
        </el-col>
      </el-row>
    </el-form>
  </el-card>
</template>

<script>
import InputCategory from '@/components/InputCategory'
import { mapGetters } from 'vuex'
import { requestArea } from '@/api/staff'
import checkPermission from '@/utils/permission'
import { RolesUser } from '@/utils/constantVariabel'

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
      colWidth: 9,
      roleAccess: checkPermission([RolesUser.ADMIN, RolesUser.STAFFPROV])
    }
  },

  computed: {
    ...mapGetters([
      'roles'
    ])
  },

  created() {
    this.getArea()
    this.setWidth()
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
      })
    },

    setWidth() {
      this.roles.forEach(element => {
        this.colWidth = element === RolesUser.STAFFKABKOTA ? 20 : 9
      })
    }

  }
}
</script>
