<template>
  <div class="components-container">
    <div class="warning">
      <p v-if="isCreate" class="caution">Masukan informasi mengenai jumlah anggota keluarga dan penghasilan sebelum dan sesudah COVID-19.</p>
    </div>
    <el-form
      ref="beneficiaries"
      :model="beneficiaries"
      :rules="rules"
      :status-icon="true"
      label-width="300px"
      label-position="left"
    >
      <el-form-item v-if="isCreate" label="Pekerjaan" prop="job_type_id">
        <el-select v-model="beneficiaries.job_type_id" filterable style="width:100%">
          <el-option
            v-for="item in jobList"
            :key="item.id"
            :label="item.title"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Status Kedudukan dalam Pekerjaan" prop="job_status_id">
        <el-select v-model="beneficiaries.job_status_id" filterable style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in jobStatusList"
            :key="item.id"
            :label="item.title"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Jumlah Anggota Keluarga" prop="total_family_members">
        <el-select v-model="temporaryFamilyOptions" style="width:100%" :disabled="disableField">
          <el-option
            v-for="item in familyCount"
            :key="item"
            :label="item"
            :value="item"
          />
        </el-select>
      </el-form-item>
      <el-form-item v-if="temporaryFamilyOptions === 'Lainnya'" prop="total_family_members">
        <el-input v-model="beneficiaries.total_family_members" type="number" placeholder="Jumlah anggota keluarga" :disabled="disableField" />
      </el-form-item>
      <el-form-item label="Penghasilan Sebelum COVID-19" prop="beforeTemporary">
        <el-input v-if="visible === true" v-model="beforeTemporary" placeholder="Penghasilan sebelum COVID-19" :disabled="disableField" @blur="onBlurNumber">
          <template slot="append">Perbulan</template>
        </el-input>
        <el-input v-if="visible === false" v-model="beforeTemporary" placeholder="Penghasilan sebelum COVID-19" :disabled="disableField" @focus="onFocusText">
          <template slot="append">Perbulan</template>
        </el-input>
      </el-form-item>
      {{ beneficiaries.income_before }}
      <el-form-item label="Penghasilan Sesudah COVID-19" prop="afterTemporary">
        <el-input v-if="visible === true" v-model="afterTemporary" placeholder="Penghasilan sesudah COVID-19" :disabled="disableField" @blur="onBlurNumberAfter">
          <template slot="append">Perbulan</template>
        </el-input>
        <el-input v-if="visible === false" v-model="afterTemporary" placeholder="Penghasilan sesudah COVID-19" :disabled="disableField" @focus="onFocusTextAfter">
          <template slot="append">Perbulan</template>
        </el-input>
      </el-form-item>
      {{ beneficiaries.income_after }}
      <el-form-item class="ml-min-40 form-button">
        <div v-if="!isCreate">Apakah informasi penghasilan ini sudah sesuai?</div>
        <el-button v-if="!isCreate" class="button-action" type="primary" plain @click="open">{{ $t('crud.change') }}</el-button>
        <el-button class="button-action" type="primary" @click="next"> {{ $t('crud.next') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { fetchListJob } from '@/api/beneficiaries'
export default {
  props: {
    beneficiaries: {
      type: Object,
      default: null
    },
    isCreate: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      disableField: true,
      beforeTemporary: null,
      afterTemporary: null,
      visible: true,
      jobList: null,
      jobStatusList: null,
      familyCount: [1, 2, 3, 4, 5, 6, 7, 'Lainnya'
      ],
      temporaryFamilyOptions: null,
      rules: {
        job_type_id: [
          {
            required: true,
            message: 'Pekerjaan harus diisi',
            trigger: 'change'
          }
        ],
        job_status_id: [
          {
            required: true,
            message: 'Status Pekerjaan harus diisi',
            trigger: 'change'
          }
        ],
        total_family_members: [
          {
            required: true,
            message: 'Jumlah anggota keluarga harus diisi',
            trigger: 'blur'
          }
        ],
        afterTemporary: [
          {
            required: true,
            message: 'Penghasilan harus diisi',
            trigger: 'blur'
          },
          {
            pattern: /^[a-z0-9_.]+$/,
            message: 'Penghasilan harus berupa angka',
            trigger: 'blur'
          }
        ],
        beforeTemporary: [
          {
            required: true,
            message: 'Penghasilan harus diisi',
            trigger: 'blur'
          },
          {
            pattern: /^[a-z0-9_.]+$/,
            message: 'Penghasilan harus berupa angka',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  watch: {
    'temporaryFamilyOptions'(value) {
      if (value !== 'Lainnya') {
        this.beneficiaries.total_family_members = value
      }
    }
  },
  created() {
    if (this.isCreate) this.disableField = false
    this.getJob()
  },
  methods: {
    async next() {
      const valid = await this.$refs.beneficiaries.validate()

      if (!valid) {
        return
      }
      this.$emit('nextStep', 1)
    },
    open() {
      this.disableField = false
    },
    getJob() {
      fetchListJob().then(response => {
        this.jobList = response.data.items.job_field
        this.jobStatusList = response.data.items.job_status
      })
    },
    formatCurrency(value, prefix) {
      if (value) {
        const number_string = value.toString()
        const split = number_string.split(',')
        const modulo = split[0].length % 3
        let rupiah = split[0].substr(0, modulo)
        const thousand = split[0].substr(modulo).match(/\d{3}/gi)

        if (thousand) {
          const separator = modulo ? '.' : ''
          rupiah += separator + thousand.join('.')
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah
        return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '')
      } else {
        return 'Rp. 0'
      }
    },
    onBlurNumber() {
      this.visible = false
      this.beneficiaries.income_before = this.beforeTemporary
      this.beforeTemporary = this.thousandSeparator(this.beforeTemporary)
    },
    onFocusText() {
      this.visible = true
      this.beforeTemporary = this.beneficiaries.income_before
    },
    onBlurNumberAfter() {
      this.visible = false
      this.beneficiaries.income_after = this.afterTemporary
      this.afterTemporary = this.thousandSeparator(this.afterTemporary)
    },
    onFocusTextAfter() {
      this.visible = true
      this.afterTemporary = this.beneficiaries.income_after
    },
    thousandSeparator(amount) {
      if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.').replace(',', '.')
      } else {
        return amount
      }
    }
  }
}
</script>
<style lang="scss" scoped>
  .caution {
    font-size: 14px;
    padding: 5px 0;
    margin: 0px;
  }
  .warning {
    margin-bottom: 35px;
  }
  .button-action {
    margin: 0 5px;
  }
  .form-button {
    margin-top: 50px;
  }
</style>
