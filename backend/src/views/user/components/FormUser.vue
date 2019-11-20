<template>
  <div class="app-container user-form">
    <p v-if="!isEdit" class="warn-content">{{ $t('users.users-add-new') }}</p>
    <p v-if="isEdit && !isProfile" class="warn-content">{{ $t('users.users-edit') }}</p>
    <p v-if="isProfile" class="warn-content">{{ $t('users.users-edit-profile') }}</p>
    <el-row :gutter="10">
      <!-- Left colomn -->
      <el-col :sm="24" :md="24" :lg="6" :xl="6" class="grid-content">
        <uploadPhoto :link-edit-photo="setLinkEditPhoto" @onUpload="getUrlPhoto" />
      </el-col>
      <!-- Center colomn -->
      <el-col :sm="24" :md="24" :lg="18" :xl="18" class="grid-content">
        <el-form
          ref="user"
          :model="user"
          :status-icon="true"
          label-width="150px"
          label-position="left"
          class="demo-ruleForm"
          :rules="rules"
        >
          <el-form-item :label="$t('label.username')" :prop="usernameValidation">
            <el-input v-model="user.username" type="text" @focus="changePropUsername" />
          </el-form-item>
          <el-form-item :label="$t('label.fullname')" prop="name">
            <el-input v-model="user.name" type="text" />
          </el-form-item>

          <el-form-item :label="$t('label.email')" :prop="emailValidation">
            <el-input v-model="user.email" type="email" @focus="changePropEmail" />
          </el-form-item>

          <el-form-item :label="$t('label.password')" prop="password">
            <el-input v-model="user.password" type="password" />
          </el-form-item>

          <el-form-item :label="$t('label.repeat-password')" prop="confirmation">
            <el-input v-model="user.confirmation" type="password" />
          </el-form-item>

          <el-form-item :label="$t('label.telepon')" prop="phone">
            <el-input v-model="user.phone" type="text" placeholder="Contoh: 081254332233" />
          </el-form-item>

          <el-row>
            <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
              <el-form-item :label="$t('label.role')" prop="role">
                <el-select v-model="user.role" placeholder="Pilih Peran" :disabled="!checkPermission([RolesUser.ADMIN, RolesUser.STAFFPROV]) && isEdit || isProfile">
                  <el-option
                    v-for="item in filterRole"
                    :key="item.value"
                    :value="item.value"
                    :label="item.label"
                  >{{ item.label }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12" :style="{paddingLeft: formRightSide}">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffSaberhoax') && checkPermission(['admin', 'staffProv']))"
                :label="$t('label.area-kabkota')"
                prop="kabkota"
              >
                <el-select
                  v-if="area !== null"
                  v-model="user.kabkota"
                  :placeholder="$t('label.choose-area-kabkota')"
                  :disabled="user.role === '' || isEdit"
                  @change="getKecamatan"
                >
                  <el-option
                    v-for="item in area"
                    :key="item.id"
                    :value="item"
                    :label="user.kabkota.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffSaberhoax') && checkPermission(['admin', 'staffProv', 'staffKabkota']))"
                :label="$t('label.area-kec')"
                prop="kecamatan"
              >
                <el-select
                  v-model="user.kecamatan"
                  :placeholder="$t('label.choose-area-kec')"
                  :disabled="(user.kabkota == '' && checkPermission(['admin', 'staffProv']) || user.role === '' || isEdit)"
                  @change="getKelurahan"
                >
                  <el-option
                    v-for="item in kecamatan"
                    :key="item.id"
                    :value="item"
                    :label="user.kecamatan.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12" :style="{paddingLeft: formRightSide}">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec') && !(user.role == 'staffSaberhoax') && ! checkPermission(['staffKel']))"
                :label="$t('label.area-kel')"
                prop="kelurahan"
              >
                <el-select
                  v-model="user.kelurahan"
                  :placeholder="$t('label.choose-area-kel')"
                  :disabled="(user.kecamatan == '' && checkPermission(['admin', 'staffProv', 'staffKabkota']) || user.role === '' || isEdit)"
                >
                  <el-option
                    v-for="item in kelurahan"
                    :key="item.id"
                    :value="item"
                    :label="user.kelurahan.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec') && !(user.role == 'staffKel') && !(user.role == 'staffSaberhoax'))"
                :label="$t('label.area-rw')"
                prop="rw"
              >
                <el-input v-model="user.rw" type="text" placeholder="Contoh: 001" :disabled="(user.kelurahan == '' && checkPermission(['admin', 'staffProv', 'staffKabkota', 'staffKec']) || user.role === '')" />
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12" :style="{paddingLeft: formRightSide}">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec') && !(user.role == 'staffKel') && !(user.role == 'staffSaberhoax'))"
                :label="$t('label.area-rt')"
                prop="rt"
              >
                <el-input v-model="user.rt" type="text" placeholder="Contoh: 002" :disabled="user.rw == '' && checkPermission(['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'])" />
              </el-form-item>
            </el-col>
          </el-row>
          <p class="warn-content">{{ $t('route.user-detail') }}</p>
          <el-form-item :label="$t('label.education')">
            <el-select v-model="user.education_level_id" :placeholder="$t('label.choose-education')">
              <el-option
                v-for="item in educationList"
                :key="item.id"
                :value="item.id"
                :label="item.title"
              >{{ item.title }}</el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('label.job')">
            <el-select v-model="user.job_type_id" :placeholder="$t('label.choose-job')">
              <el-option
                v-for="item in jobList"
                :key="item.id"
                :value="item.id"
                :label="item.title"
              >{{ item.title }}</el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('label.birthdate')">
            <el-date-picker
              v-model="user.birth_date"
              type="date"
              :editable="false"
              :clearable="false"
              format="yyyy-MM-dd"
              value-format="yyyy-MM-dd"
              :picker-options="birthdateOptions"
              :placeholder="$t('label.choose-birthdate')"
            />
          </el-form-item>
          <p class="warn-content">{{ $t('label.location-user') }}</p>
          <el-row>
            <el-col>
              <el-form-item :label="$t('label.address')" prop="address">
                <el-input v-model="user.address" type="text" />
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
              <el-form-item :label="$t('label.coordinates')" prop="coordinates">
                <InputMap v-model="user.coordinates" />
              </el-form-item>
            </el-col>
          </el-row>
          <p class="warn-content">{{ $t('label.social-media') }}</p>

          <el-form-item label="Twitter" prop="twitter">
            <el-input v-model="user.twitter" type="text" placeholder="Contoh: jabardigitalservice" />
          </el-form-item>
          <el-form-item label="Facebook" prop="facebook">
            <el-input
              v-model="user.facebook"
              type="text"
              placeholder="Contoh: https://www.facebook.com/jabardigitalservice/"
            />
          </el-form-item>
          <el-form-item label="Instagram" prop="instagram">
            <el-input
              v-model="user.instagram"
              type="text"
              placeholder="Contoh: jabardigitalservice"
            />
          </el-form-item>
          <el-form-item>
            <el-button v-if="(!isEdit)" type="primary" :loading="loading" @click="submitForm('user')">{{ $t('crud.save-user') }}</el-button>
            <el-button v-if="(isEdit && !isProfile)" type="primary" :loading="loading" @click="updateForm('user')">{{ $t('crud.save-update') }}</el-button>
            <el-button v-if="(isProfile)" type="primary" :loading="loading" @click="updateProfile">{{ $t('crud.save-update') }}</el-button>
            <el-button v-if="(isEdit && !isProfile) || (!isEdit && !isProfile) " @click="resetForm('user')">{{ $t('crud.cancel') }}</el-button>
            <router-link v-if="isProfile && isEdit" :to="'/profile'">
              <el-button>{{ $t('crud.cancel') }}</el-button>
            </router-link>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import uploadPhoto from './uploadPhoto'
import checkPermission from '@/utils/permission'
import {
  requestArea,
  requestKecamatan,
  requestKelurahan,
  createUser,
  fetchUser,
  editUser,
  getEducationList,
  getJobList
} from '@/api/staff'
import { fetchProfile, update } from '@/api/user'
import { Message } from 'element-ui'
import InputMap from '@/components/InputMap'
import { validCoordinate, containsWhitespace } from '@/utils/validate'
import { isUserKabKota } from '@/utils/permission'
import { RolesUser } from '@/utils/constantVariabel'
import moment from 'moment'

export default {
  components: { uploadPhoto, InputMap },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    },
    isProfile: {
      type: Boolean,
      default: false
    }
  },
  data() {
    const checkPhone = (rule, value, callback) => {
      const phoneStringFormat = value.toString()
      const checkStringPhone = phoneStringFormat.startsWith('0')
      if (!checkStringPhone) {
        callback(new Error(this.$t('errors.phone-number-must-be-start-0')))
      } else {
        callback()
      }
    }
    const validatePass = (rule, value, callback) => {
      if (this.user.confirmation !== '') {
        this.$refs.user.validateField('confirmation')
      }
      callback()
    }

    const checkPassword = (rule, value, callback) => {
      if (value !== this.user.password) {
        callback(new Error(this.$t('errors.password-dont-match')))
      } else {
        callback()
      }
    }

    const validatorCoordinateRequired = (rule, value, callback) => {
      if (_.isEmpty(this.user.coordinates[0]) === false && _.isEmpty(this.user.coordinates[1]) === true) {
        callback(new Error(this.$t('errors.coordinates-must-be-filled')))
      }

      if (_.isEmpty(this.user.coordinates[0]) === true && _.isEmpty(this.user.coordinates[1]) === false) {
        callback(new Error(this.$t('errors.coordinates-must-be-filled')))
      }

      callback()
    }

    const validatorCoordinateInputNumber = (rule, value, callback) => {
      if (_.isEmpty(this.user.coordinates[0]) === false && validCoordinate(this.user.coordinates[0]) === false) {
        callback(new Error(this.$t('errors.coordinates-only-use-numbers-periods')))
      }

      if (_.isEmpty(this.user.coordinates[1]) === false && validCoordinate(this.user.coordinates[1]) === false) {
        callback(new Error(this.$t('errors.coordinates-only-use-numbers-periods')))
      }

      callback()
    }

    const validatorCoordinateFinite = (rule, value, callback) => {
      if (_.isEmpty(this.user.coordinates[0]) === false && isFinite(this.user.coordinates[0]) === false) {
        callback(new Error(this.$t('errors.coordinates-dont-match')))
      }

      if (_.isEmpty(this.user.coordinates[1]) === false && isFinite(this.user.coordinates[1]) === false) {
        callback(new Error(this.$t('errors.coordinates-dont-match')))
      }

      callback()
    }

    const whitespaceText = (rule, value, callback) => {
      if (containsWhitespace(value) === true) {
        callback(new Error(this.$t('errors.text-not-valid')))
      }
      callback()
    }

    return {
      loading: false,
      user: {
        username: '',
        name: '',
        email: '',
        password: '',
        confirmation: '',
        phone: '',
        address: '',
        kabkota: [],
        kecamatan: [],
        kelurahan: [],
        rw: '',
        rt: '',
        role: [],
        twitter: '',
        facebook: '',
        birth_date: '',
        education_level_id: '',
        job_type_id: '',
        instagram: '',
        photo: '',
        coordinates: []
      },
      roleOptions: [
        {
          label: this.$t('label.roles-admin'),
          value: RolesUser.ADMIN
        },
        {
          label: this.$t('label.roles-admin-saber-hoax'),
          value: RolesUser.STAFFSABERHOAX
        },
        {
          label: this.$t('label.roles-admin-province'),
          value: RolesUser.STAFFPROV
        },
        {
          label: this.$t('label.roles-admin-kabkota'),
          value: RolesUser.STAFFKABKOTA
        },
        {
          label: this.$t('label.roles-admin-districts'),
          value: RolesUser.STAFFKEC
        },
        {
          label: this.$t('label.roles-admin-village'),
          value: RolesUser.STAFFKEL
        },
        {
          label: this.$t('label.roles-admin-rw'),
          value: RolesUser.STAFFRW
        }
      ],
      id_kabkota: '',
      id_kec: '',
      id_kel: '',
      area: '',
      kecamatan: '',
      kelurahan: '',
      educationList: [],
      jobList: [],
      image: '',
      imageData: require('@/assets/user.png'),
      preview: '',
      formRightSide: '10px',
      emailValidation: 'email',
      usernameValidation: 'username',
      emitUrlPhoto: '',
      setLinkEditPhoto: '',
      birthdateOptions: {
        disabledDate: this.optionsBirthDate,
        defaultValue: moment().subtract(20, 'years').format('YYYY-MM-DD')
      },
      RolesUser,
      // validation
      rules: {
        username: [
          {
            required: true,
            message: this.$t('errors.username-must-be-filled'),
            trigger: 'blur'
          },
          {
            min: 4,
            message: this.$t('errors.username-must-be-at-least-4-characters'),
            trigger: 'blur'
          },
          {
            max: 255,
            message: this.$t('errors.username-must-be-at-least-255-characters'),
            trigger: 'blur'
          },
          {
            pattern: /^[a-z0-9_.]+$/,
            message: this.$t('errors.username-only-use-lowercase-letters-numbers-underscore-and-dots'),
            trigger: 'blur'
          },
          {
            validator: whitespaceText,
            trigger: 'blur'
          }
        ],
        errorUsername: [
          {
            required: true,
            message: this.$t('errors.username-already-used'),
            trigger: 'change'
          }
        ],
        name: [
          {
            validator: whitespaceText,
            trigger: 'blur'
          },
          {
            required: true,
            message: this.$t('errors.fullname-must-be-filled'),
            trigger: 'blur'
          },
          {
            max: 255,
            message: this.$t('errors.fullname-be-at-least-255-characters'),
            trigger: 'blur'
          },
          {
            pattern: /^[a-zA-Z.'\s]+$/,
            message: this.$t('errors.fullname-only-use-letters-aposthrope-dots'),
            trigger: 'blur'
          }
        ],
        email: [
          {
            validator: whitespaceText,
            trigger: 'blur'
          },
          {
            required: true,
            message: this.$t('errors.email-must-be-filled'),
            trigger: 'blur'
          },
          {
            max: 255,
            message: this.$t('errors.email-must-be-at-least-255-characters'),
            trigger: 'blur'
          },
          {
            min: 3,
            message: this.$t('errors.email-must-be-at-least-3-characters'),
            trigger: 'blur'
          },
          {
            type: 'email',
            message: this.$t('errors.email-wrong-format'),
            trigger: 'blur'
          }
        ],
        errorEmail: [
          {
            required: true,
            message: this.$t('errors.email-already-used'),
            trigger: 'change'
          }
        ],
        password: [
          {
            max: 255,
            message: this.$t('errors.password-must-be-at-least-255-characters'),
            trigger: 'blur'
          },
          {
            min: 5,
            message: this.$t('errors.password-must-be-at-least-5-characters'),
            trigger: 'blur'
          },
          {
            pattern: /^[a-zA-Z0-9\w\S]+$/,
            message: this.$t('errors.password-only-use-letters-number-characters'),
            trigger: 'blur'
          },
          {
            validator: validatePass,
            trigger: 'blur'
          },
          {
            required: !this.isEdit,
            message: this.$t('errors.password-must-be-filled'),
            trigger: 'blur'
          }
        ],
        confirmation: [
          {
            max: 255,
            message: this.$t('errors.password-must-be-at-least-255-characters'),
            trigger: 'blur'
          },
          {
            min: 5,
            message: this.$t('errors.password-must-be-at-least-5-characters'),
            trigger: 'blur'
          },
          {
            pattern: /^[a-zA-Z0-9\w\S]+$/,
            message: this.$t('errors.password-only-use-letters-number-characters'),
            trigger: 'blur'
          },
          {
            validator: checkPassword,
            trigger: 'blur'
          },
          {
            required: !this.isEdit,
            message: this.$t('errors.please-repeat-the-password'),
            trigger: 'blur'
          }
        ],
        phone: [
          {
            required: true,
            message: this.$t('errors.phone-number-must-be-filled'),
            trigger: 'blur'
          },
          {
            min: 3,
            message: this.$t('errors.phone-number-must-must-be-at-least-3-characters'),
            trigger: 'blur'
          },
          {
            max: 13,
            message: this.$t('errors.phone-number-must-must-be-at-least-13-characters'),
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: this.$t('errors.phone-number-only-use-number'),
            trigger: 'blur'
          },
          {
            validator: checkPhone,
            trigger: 'blur'
          }
        ],
        address: [
          {
            validator: whitespaceText,
            trigger: 'blur'
          },
          {
            required: true,
            message: this.$t('errors.address-must-be-filled'),
            trigger: 'blur'
          },
          {
            max: 255,
            message: this.$t('errors.address-must-be-at-least-255-characters'),
            trigger: 'blur'
          }
        ],
        coordinates: [
          { validator: validatorCoordinateRequired, trigger: 'change' },
          { validator: validatorCoordinateInputNumber, trigger: 'change' },
          { validator: validatorCoordinateFinite, trigger: 'change' }
        ],
        kabkota: [
          {
            required: true,
            message: this.$t('errors.area-kabkota-must-be-filled'),
            trigger: 'blur'
          }
        ],
        kecamatan: [
          {
            required: true,
            message: this.$t('errors.area-kecamatan-must-be-filled'),
            trigger: 'blur'
          }
        ],
        kelurahan: [
          {
            required: true,
            message: this.$t('errors.area-kel-must-be-filled'),
            trigger: 'blur'
          }
        ],
        rw: [
          {
            required: true,
            message: this.$t('errors.rw-must-be-filled'),
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: this.$t('errors.rw-only-use-number'),
            trigger: 'blur'
          },
          {
            max: 3,
            message: this.$t('errors.rw-must-be-at-least-3-number'),
            trigger: 'blur'
          },
          {
            min: 3,
            message: this.$t('errors.rw-must-be-at-least-3-number'),
            trigger: 'blur'
          }
        ],
        rt: [
          {
            required: true,
            message: this.$t('errors.rt-must-be-filled'),
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: this.$t('errors.rt-only-use-number'),
            trigger: 'blur'
          },
          {
            max: 3,
            message: this.$t('errors.rt-must-be-at-least-3-number'),
            trigger: 'blur'
          },
          {
            min: 3,
            message: this.$t('errors.rt-must-be-at-least-3-number'),
            trigger: 'blur'
          }
        ],
        role: [
          {
            required: true,
            message: this.$t('errors.role-must-be-filled'),
            trigger: 'blur'
          }
        ],
        twitter: [
          {
            validator: whitespaceText,
            trigger: 'blur'
          },
          {
            required: false,
            trigger: 'blur'
          },
          {
            pattern: /^[a-z0-9._]+$/,
            message: this.$t('errors.twitter-only-use-lowercase-letters-numbers-underscore-and-dots'),
            trigger: 'blur'
          }
        ],
        facebook: [
          {
            validator: whitespaceText,
            trigger: 'blur'
          },
          {
            required: false,
            trigger: 'blur'
          },
          {
            type: 'url',
            message: this.$t('errors.enter-your-facebook-URL-in-full'),
            trigger: 'blur'
          }
        ],
        instagram: [
          {
            validator: whitespaceText,
            trigger: 'blur'
          },
          {
            required: false,
            trigger: 'blur'
          },
          {
            pattern: /^[a-z0-9._]+$/,
            message: this.$t('errors.instagram-only-use-lowercase-letters-numbers-underscore-and-dots'),
            trigger: 'blur'
          }
        ]
      }
    }
  },
  computed: {
    parentId() {
      const authUser = this.$store.state.user
      if (checkPermission([RolesUser.STAFFKABKOTA])) {
        return parseInt(authUser.kabkota_id)
      }
      if (checkPermission([RolesUser.STAFFKEC])) {
        return parseInt(authUser.kec_id)
      }
      return null
    },
    parentArea() {
      const authUser = this.$store.state.user
      if (checkPermission([RolesUser.STAFFKABKOTA])) {
        const staffKabkota = authUser.kabkota_id
        this.parentKabkotaSet(staffKabkota)
      }
      return null
    },
    parentKecamatan() {
      const authUser = this.$store.state.user
      if (checkPermission([RolesUser.STAFFKEC])) {
        const staffKecamatan = {
          kabkota: authUser.kabkota_id,
          kecamatan: authUser.kec_id
        }
        this.parentKecamatanSet(staffKecamatan)
      }
      return null
    },
    parentKelurahan() {
      const authUser = this.$store.state.user
      if (checkPermission([RolesUser.STAFFKEL])) {
        const staffKelurahan = {
          kabkota: authUser.kabkota_id,
          kecamatan: authUser.kec_id,
          kelurahan: authUser.kel_id
        }
        this.parentKelurahanSet(staffKelurahan)
      }
      return null
    },
    // the filterRole() method returns the selected elements in an array, as a new array object.
    filterRole() {
      const ruleOptions = this.roleOptions
      if ((this.isEdit && !this.isProfile) || (!this.isEdit && !this.isProfile)) {
        if (checkPermission([RolesUser.ADMIN])) {
          ruleOptions.push({ label: this.$t('label.roles-trainer'), value: RolesUser.TRAINER }, { label: this.$t('label.roles-public'), value: RolesUser.PUBLIK })
          return ruleOptions.slice(1, ruleOptions.length)
        } if (checkPermission([RolesUser.STAFFPROV])) {
          ruleOptions.push({ label: this.$t('label.roles-trainer'), value: RolesUser.TRAINER }, { label: this.$t('label.roles-public'), value: RolesUser.PUBLIK })
          return ruleOptions.slice(3, ruleOptions.length)
        } if (checkPermission([RolesUser.STAFFKABKOTA])) {
          return ruleOptions.slice(4, ruleOptions.length)
        } if (checkPermission([RolesUser.STAFFKEC])) {
          return ruleOptions.slice(5, ruleOptions.length)
        } if (checkPermission([RolesUser.STAFFKEL])) {
          return ruleOptions.slice(6, ruleOptions.length)
        }
      }
      return ruleOptions
    }
  },
  watch: {
    'user.kabkota'(oldVal, newVal) {
      if (newVal !== '' && this.isEdit === false && this.isProfile === false) {
        this.user.kecamatan = ''
        this.user.kelurahan = ''
        this.user.rt = ''
        this.user.rw = ''
      }
    },
    'user.kecamatan'(oldVal, newVal) {
      if (newVal !== '' && this.isEdit === false && this.isProfile === false) {
        this.user.kelurahan = ''
        this.user.rt = ''
        this.user.rw = ''
      }
    },
    'user.kelurahan'(oldVal, newVal) {
      if (newVal !== '' && this.isEdit === false && this.isProfile === false) {
        this.user.rt = ''
        this.user.rw = ''
      }
    }
  },
  created() {
    if (this.isEdit && !this.isProfile) {
      const id = this.$route.params && this.$route.params.id
      this.fetchData(id)
    }
    if (this.isEdit && this.isProfile) {
      this.getProfile()
    }
    this.getArea()
    this.getEducation()
    this.getJob()
    this.parentId
    this.parentArea
    this.parentKecamatan
    this.parentKelurahan
    if (checkPermission([RolesUser.STAFFKABKOTA])) {
      this.getKecamatan()
    }
    if (checkPermission([RolesUser.STAFFKEC])) {
      this.getKelurahan()
      this.formRightSide = '0'
    }
  },
  methods: {
    getProfile() {
      fetchProfile().then(response => {
        const dataProfile = response.data
        this.user.role = dataProfile.role_id
        Object.assign(this.user, dataProfile)

        this.user.coordinates = [dataProfile.lat, dataProfile.lon]

        const dataUserPhotoUrl = dataProfile.photo_url
        let urlPhoto = null
        if (dataProfile.photo_url !== null) {
          urlPhoto = dataUserPhotoUrl.substring(dataUserPhotoUrl.lastIndexOf('/', dataUserPhotoUrl.lastIndexOf('/') - 1) + 1)
        } else {
          urlPhoto = dataProfile.photo_url
        }

        this.user.photo = urlPhoto
        this.imageData = dataProfile.photo_url || this.imageData
        this.setLinkEditPhoto = dataProfile.photo_url
        // assign to data
        if ((dataProfile.role_id === RolesUser.STAFFRW) || (dataProfile.role_id === RolesUser.TRAINER) || (dataProfile.role_id === RolesUser.PUBLIK)) {
          this.user.kabkota = dataProfile.kabkota.name
          this.user.kecamatan = dataProfile.kecamatan.name
          this.user.kelurahan = dataProfile.kelurahan.name
        } else if (dataProfile.role_id === RolesUser.STAFFKEL) {
          this.user.kabkota = dataProfile.kabkota.name
          this.user.kecamatan = dataProfile.kecamatan.name
          this.user.kelurahan = dataProfile.kelurahan.name
        } else if (dataProfile.role_id === RolesUser.STAFFKEC) {
          this.user.kabkota = dataProfile.kabkota.name
          this.user.kecamatan = dataProfile.kecamatan.name
        } else if (dataProfile.role_id === RolesUser.STAFFKABKOTA) {
          this.user.kabkota = dataProfile.kabkota.name
        }
      })
    },
    async updateProfile() {
      const valid = await this.$refs.user.validate()

      if (!valid) return

      try {
        this.loading = true
        if (this.isEdit && this.isProfile) {
          const data = {
            username: this.user.username,
            name: this.user.name,
            email: this.user.email,
            phone: this.user.phone,
            address: this.user.address,
            rt: this.user.rt,
            facebook: this.user.facebook,
            twitter: this.user.twitter,
            instagram: this.user.instagram,
            photo_url: this.user.photo,
            lat: this.user.coordinates[0],
            lon: this.user.coordinates[1],
            kabkota_id: this.id_kabkota,
            kec_id: this.id_kec,
            kel_id: this.id_kel,
            role_id: this.role
          }
          if (this.user.confirmation !== '') {
            data.password = this.user.confirmation
          }

          const dataFinal = {
            UserEditForm: data
          }

          await update(dataFinal)

          this.$message.success(this.$t('crud.update-success'))

          this.$router.push('/profile')
        }
      } catch (error) {
        const emailFail = error.response.data.data.email[0]
        this.$message.error(this.$t(emailFail))
        this.user.email = null
        this.emailValidation = 'errorEmail'
      } finally {
        this.loading = false
      }
    },
    getUrlPhoto(url) {
      this.user.photo = url
    },
    optionsBirthDate(date) {
      return date > moment().subtract(20, 'years')
    },
    checkPermission,
    fetchData(id) {
      fetchUser(id).then(response => {
        const dataUser = response.data
        isUserKabKota(dataUser.kabkota ? dataUser.kabkota.id : null, dataUser.role_id)
        const dataUserPhotoUrl = dataUser.photo_url
        let urlPhoto = null
        if (dataUser.photo_url !== null) {
          urlPhoto = dataUserPhotoUrl.substring(dataUserPhotoUrl.lastIndexOf('/', dataUserPhotoUrl.lastIndexOf('/') - 1) + 1)
        } else {
          urlPhoto = dataUser.photo_url
        }
        // // assign to data
        if ((dataUser.role_id === RolesUser.STAFFRW) || (dataUser.role_id === RolesUser.TRAINER) || (dataUser.role_id === RolesUser.PUBLIK)) {
          this.user.kabkota = dataUser.kabkota.name
          this.user.kecamatan = dataUser.kecamatan.name
          this.user.kelurahan = dataUser.kelurahan.name
        } else if (dataUser.role_id === RolesUser.STAFFKEL) {
          this.user.kabkota = dataUser.kabkota.name
          this.user.kecamatan = dataUser.kecamatan.name
          this.user.kelurahan = dataUser.kelurahan.name
        } else if (dataUser.role_id === RolesUser.STAFFKEC) {
          this.user.kabkota = dataUser.kabkota.name
          this.user.kecamatan = dataUser.kecamatan.name
        } else if (dataUser.role_id === RolesUser.STAFFKABKOTA) {
          this.user.kabkota = dataUser.kabkota.name
        }

        const { lat, lon } = response.data
        this.user.coordinates = [lat, lon]
        this.user.rw = dataUser.rw
        this.user.rt = dataUser.rt
        this.user.birth_date = dataUser.birth_date
        this.user.education_level_id = dataUser.education_level_id
        this.user.job_type_id = dataUser.job_type_id
        this.user.photo = urlPhoto
        this.imageData = dataUser.photo_url || this.imageData
        this.setLinkEditPhoto = dataUser.photo_url
        this.user.twitter = dataUser.twitter
        this.user.facebook = dataUser.facebook
        this.user.instagram = dataUser.instagram
        this.user.username = dataUser.username
        this.user.name = dataUser.name
        this.user.email = dataUser.email
        this.user.phone = dataUser.phone
        this.user.address = dataUser.address
        this.user.role = dataUser.role_id
      }).catch()
    },
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          this.loading = true
          createUser({
            username: this.user.username,
            name: this.user.name,
            email: this.user.email,
            password: this.user.confirmation,
            phone: this.user.phone,
            address: this.user.address,
            role_id: this.user.role,
            kabkota_id: this.user.kabkota.id || this.id_kabkota,
            kec_id: this.user.kecamatan.id || this.id_kec,
            kel_id: this.user.kelurahan.id || this.id_kel,
            rw: this.user.rw,
            rt: this.user.rt,
            birth_date: this.user.birth_date,
            education_level_id: this.user.education_level_id,
            job_type_id: this.user.job_type_id,
            facebook: this.user.facebook,
            twitter: this.user.twitter,
            instagram: this.user.instagram,
            photo_url: this.user.photo,
            lat: this.user.coordinates[0],
            lon: this.user.coordinates[1]
          }).then(() => {
            Message({
              message: this.$t('message.user-successfully-added'),
              type: 'success',
              duration: 1 * 1000
            })
            setTimeout(() => {
              this.$router.go(-1)
            }, 1000)
            this.$refs[formName].resetFields()
            this.imageData = 0
            this.loading = false
          })
            .catch(error => {
              const usernameError = error.response.data.data.username
              const emailError = error.response.data.data.email
              if (!emailError) {
                Message({
                  message: usernameError[0],
                  type: 'error',
                  duration: 5 * 1000
                })
                this.user.username = null
                this.usernameValidation = 'errorUsername'
              } else if (!usernameError) {
                Message({
                  message: emailError[0],
                  type: 'error',
                  duration: 5 * 1000
                })
                this.user.email = null
                this.emailValidation = 'errorEmail'
              } else {
                Message({
                  message: this.$t('errors.username-email-already-used'),
                  type: 'error',
                  duration: 5 * 1000
                })
                this.user.username = null
                this.user.email = null
                this.emailValidation = 'errorEmail'
                this.usernameValidation = 'errorUsername'
              }
              this.loading = false
            })
        } else {
          return false
        }
      })
    },
    updateForm(formName) {
      const id = this.$route.params && this.$route.params.id
      this.$refs[formName].validate(valid => {
        if (valid) {
          this.loading = true
          const userEdit = {
            username: this.user.username,
            name: this.user.name,
            email: this.user.email,
            phone: this.user.phone,
            rw: this.user.rw,
            rt: this.user.rt,
            address: this.user.address,
            birth_date: this.user.birth_date,
            education_level_id: this.user.education_level_id,
            job_type_id: this.user.job_type_id,
            facebook: this.user.facebook,
            twitter: this.user.twitter,
            instagram: this.user.instagram,
            photo_url: this.user.photo,
            lat: this.user.coordinates[0],
            lon: this.user.coordinates[1],
            role_id: this.user.role
          }
          if (this.user.confirmation !== '') {
            userEdit['password'] = this.user.confirmation
          }
          editUser(userEdit, id).then(response => {
            Message({
              message: this.$t('message.user-data-successfully-updated'),
              type: 'success',
              duration: 1 * 1000
            })
            setTimeout(() => {
              this.$router.go(-1)
            }, 1000)
            this.$refs[formName].resetFields()
            this.imageData = 0
            this.loading = false
          }).catch(error => {
            const usernameError = error.response.data.data.username
            const emailError = error.response.data.data.email
            if (!emailError) {
              Message({
                message: usernameError[0],
                type: 'error',
                duration: 5 * 1000
              })
            } else if (!usernameError) {
              Message({
                message: emailError[0],
                type: 'error',
                duration: 5 * 1000
              })
            } else {
              Message({
                message: this.$t('errors.username-email-already-used'),
                type: 'error',
                duration: 5 * 1000
              })
            }
            this.user.email = null
            this.emailValidation = 'errorEmail'
            this.loading = false
          })
        } else {
          return false
        }
      })
    },
    changePropEmail() {
      if (this.emailValidation === 'errorEmail') {
        this.emailValidation = 'email'
      } else {
        this.emailValidation = 'email'
      }
    },
    changePropUsername() {
      if (this.usernameValidation === 'errorUsername') {
        this.usernameValidation = 'username'
      } else {
        this.usernameValidation = 'username'
      }
    },

    resetForm(formName) {
      this.$refs[formName].resetFields()
      this.$router.go(-1)
    },
    parentKabkotaSet(dataKabkota) {
      this.id_kabkota = dataKabkota
    },
    parentKecamatanSet(dataKecamatan) {
      this.id_kabkota = dataKecamatan.kabkota
      this.id_kec = dataKecamatan.kecamatan
    },
    parentKelurahanSet(dataKelurahan) {
      this.id_kabkota = dataKelurahan.kabkota
      this.id_kec = dataKelurahan.kecamatan
      this.id_kel = dataKelurahan.kelurahan
    },
    getArea() {
      requestArea().then(response => {
        this.area = response.data.items
      })
    },
    getKecamatan() {
      if (!(this.user.kabkota.id == null)) {
        this.id_kabkota = this.user.kabkota.id
      } else {
        this.id_kabkota = this.parentId
      }
      requestKecamatan(this.id_kabkota).then(response => {
        this.kecamatan = response.data.items
      })
    },
    getKelurahan() {
      if (!(this.user.kecamatan.id == null)) {
        this.id_kec = this.user.kecamatan.id
      } else {
        this.id_kec = this.parentId
      }
      requestKelurahan(this.id_kec).then(response => {
        this.kelurahan = response.data.items
      })
    },

    async getEducation() {
      const response = await getEducationList()
      this.educationList = response.data.items
    },

    async getJob() {
      const response = await getJobList()
      this.jobList = response.data.items
    },
    // Generate password
    randomPassword(length) {
      var chars =
        'abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890'
      var pass = ''
      for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length)
        pass += chars.charAt(i)
      }
      return pass
    },
    generate() {
      this.user.password = this.randomPassword(8)
    }
  }
}
</script>
