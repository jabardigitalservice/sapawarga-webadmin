<template>
  <div class="components-container">
    <div class="warning">
      <p class="caution">Masukan informasi mengenai jumlah anggota keluarga dan penghasilan sebelum dan sesudah COVID-19.</p>
    </div>
    <el-form
      ref="beneficiaries"
      :model="beneficiaries"
      :rules="rules"
      :status-icon="true"
      label-width="300px"
      label-position="left"
    >
      <el-form-item label="Pekerjaan" prop="job_type_id">
        <el-select v-model="beneficiaries.job_type_id" style="width:100%">
          <el-option
            v-for="item in jobList"
            :key="item.id"
            :label="item.title"
            :value="item.id" />
        </el-select>
      </el-form-item>
      <el-form-item label="Status Kedudukan dalam Pekerjaan" prop="job_status_id">
        <el-select v-model="beneficiaries.job_status_id" style="width:100%">
          <el-option
            v-for="item in jobStatusList"
            :key="item.id"
            :label="item.title"
            :value="item.id" />
        </el-select>
      </el-form-item>
      <el-form-item label="Jumlah Anggota Keluarga" prop="total_family_members">
        <el-input v-model="beneficiaries.total_family_members" type="number"  placeholder="Jumlah anggota keluarga" />
      </el-form-item>
      <el-form-item label="Penghasilan Sebelum COVID-19" prop="income_before">
        <el-input v-model="beneficiaries.income_before" type="number" placeholder="Kab/Penghasilan sebelum COVID-19" />
      </el-form-item>
      <el-form-item label="Penghasilan Sesudah COVID-19" prop="income_after">
        <el-input v-model="beneficiaries.income_after" type="number" placeholder="Penghasilan sesudah COVID-19" />
      </el-form-item>
      <el-form-item class="ml-min-40 form-button">
        <span>Apakah data sudah benar?</span>
        <el-button class="button-action" type="primary" plain>{{ $t('crud.change') }}</el-button>
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
    }
  },
  data() {
    return {
      jobList: null,
      jobStatusList: null,
      familyCount: [1, 2, 3, 4, 5, 6, 7, 'Lainnya'
      ],
      rules: {
        job_type_id: [
          {
            required: true,
            message: 'Pekerjaan harus diisi',
            trigger: 'blur'
          }
        ],
        job_status_id: [
          {
            required: true,
            message: 'Status Pekerjaan harus diisi',
            trigger: 'blur'
          }
        ],
        total_family_members: [
          {
            required: true,
            message: 'Jumlah anggota keluarga harus diisi',
            trigger: 'blur'
          }
        ],
        income_after: [
          {
            required: true,
            message: 'Penghasilan harus diisi',
            trigger: 'blur'
          }
        ],
        income_before: [
          {
            required: true,
            message: 'Penghasilan harus diisi',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  created() {
    this.getJob()
  },
  methods: {
    next() {
      this.$emit('nextStep', 1)
    },
    getJob() {
      fetchListJob().then(response => {
        this.jobList = response.data.items.job_field
        this.jobStatusList = response.data.items.job_status
      })
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
