<template>
  <div name="release-management-form">
    <el-card>
      <el-row :gutter="20">
        <el-col :xs="24" :sm="16">
          <el-form ref="form" :model="form" :rules="rules" :status-icon="true" label-width="210px">

            <el-form-item label="Judul Misi" :prop="validateVersion">
              <el-input
                v-model="form.version"
                type="text"
                name="version"
                placeholder="Judul Misi"
              />
            </el-form-item>

            <el-form-item class="waktu-publikasi" label="Tanggal Misi" :prop="validateStartDate">
              <el-row :gutter="12" type="flex">
                <el-col :span="12">
                  <el-date-picker
                    v-model="form.start_date"
                    class="pop-up-date"
                    type="datetime"
                    format="yyyy-MM-dd HH:mm:ss"
                    value-format="yyyy-MM-dd HH:mm:ss"
                    :picker-options="dateStartDateOptions"
                    :placeholder="$t('popup.popup-start-date')"
                  />
                </el-col>
                <el-col :span="12">
                  <el-date-picker
                    v-model="form.end_date"
                    class="pop-up-date"
                    type="datetime"
                    format="yyyy-MM-dd HH:mm:ss"
                    value-format="yyyy-MM-dd HH:mm:ss"
                    :picker-options="dateEndDateOptions"
                    :placeholder="$t('popup.popup-end-date')"
                  />
                </el-col>
              </el-row>
            </el-form-item>

            <el-form-item label="Deskripsi Misi" :prop="validateVersion">
              <el-input
                :model="form.version"
                type="textarea"
                :autosize="{ minRows: 2, maxRows: 4}"
                name="version"
                placeholder="Deskripsi Misi"
              />
            </el-form-item>

          </el-form>
        </el-col>
      </el-row>
      <el-button type="success" style="float: right;" :loading="loading" @click="addMisionRow">
        <span>Tambah Misi</span>
      </el-button>
    </el-card>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <div v-for="(mision, index) in mision" :key="index">
          <el-card>
            <FormDetailGamification
              :index="index"
              :fitur="mision.fitur"
              :jumlah_task="mision.jumlah_task"
              :deskripsi="mision.deskripsi"
            />
          </el-card>
        </div>
      </el-col>
    </el-row>
    <el-row>
      <el-button type="primary" :loading="loading" @click="submitProcess">
        <span v-if="isEdit === true">{{ $t('crud.save-update') }}</span>
        <span v-else>{{ $t('crud.save-create') }}</span>
      </el-button>
      <router-link :to="'/release-management/index'">
        <el-button type="info">{{ $t('crud.cancel') }}</el-button>
      </router-link>
    </el-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { containsWhitespace } from '@/utils/validate'
import FormDetailGamification from './FormDetailGamification'
const moment = require('moment')
moment().format()

export default {
  components: { FormDetailGamification },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const validatorTextWhitespace = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error('Teks yang diisi tidak valid.'))
      }

      callback()
    }

    return {
      form: {
        version: null,
        force_update: null,
        start_date: moment().format('YYYY-MM-DD HH:mm:ss'),
        end_date: moment().add(1, 'days').format('YYYY-MM-DD HH:mm:ss')
      },
      loading: false,
      validateVersion: 'version',
      validateStartDate: 'start_date',
      rules: {
        version: [
          { required: true, message: 'Version harus diisi.', trigger: 'blur' },
          { validator: validatorTextWhitespace, trigger: 'blur' }
        ],
        errorVersion: [
          { required: true, message: 'Version sudah digunakan', trigger: 'change' }
        ]
      },
      dateStartDateOptions: {
        disabledDate: this.disabledStartDate
      },
      dateEndDateOptions: {
        disabledDate: this.disabledEndDate
      }
    }
  },
  computed: {
    ...mapGetters(['mision'])
  },
  mounted() {

  },
  methods: {
    addMisionRow() {
      this.$store.commit('gamification/addMisionRow')
    },
    deleteMisionRow(index) {
      this.$store.commit('gamification/deleteMisionRow', index)
    },
    disabledStartDate(time) {
      const dateTime = moment().format('YYYY-MM-DD 00:00:00')
      const parseDateTime = Date.parse(dateTime)
      return time.getTime() < parseDateTime
    },
    disabledEndDate(time) {
      const startDateTime = moment(this.form.start_date).format('YYYY-MM-DD 00:00:00')
      const parseDateTime = Date.parse(startDateTime)
      return time.getTime() < parseDateTime
    },

    async submitProcess() {
      const valid = await this.$refs.form.validate()

      if (!valid) {
        return
      }
    }
  }
}
</script>
