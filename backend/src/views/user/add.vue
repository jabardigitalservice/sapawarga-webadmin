<template>
  <div class="app-container">
    <!-- <p class="warn-content">Tambah Pengguna</p> -->
    <p class="warn-content">Profile Pengguna</p>
    <el-row :gutter="10">
      <!-- Left colomn -->
      <el-col :sm="24" :lg="6" :xl="6" class="grid-content">
        <el-form ref="user" :model="user" :rules="rules">
          <el-form-item label="Photo" prop="photo">
            <input type="file" @change="onFileSelected">
            <el-button type="primary" size="small" style="margin-left:50px">Unggah</el-button>
          </el-form-item>
        </el-form>
      </el-col>

      <!-- Center colomn -->
      <el-col :sm="24" :lg="15" :xl="14" class="grid-content">
        <el-form
          ref="user"
          :model="user"
          status-icon
          label-width="150px"
          label-position="left"
          class="demo-ruleForm"
          :rules="rules"
        >
          <!-- form -->

          <el-form-item label="Nama Pengguna" prop="username">
            <el-input v-model="user.username" type="text" />
          </el-form-item>
          <el-form-item label="Nama" prop="name">
            <el-input v-model="user.name" type="text" />
          </el-form-item>

          <el-form-item label="Email" prop="email">
            <el-input v-model="user.email" type="email" />
          </el-form-item>
          <el-row>
            <el-col :span="20">
              <el-form-item label="Password" prop="password">
                <el-input v-model="user.password" type="text" />
              </el-form-item>
            </el-col>

            <el-col :span="3" style="margin-left:5px">
              <el-button type="success" @click="generate">Generate</el-button>
            </el-col>
          </el-row>

          <el-form-item label="Telepon" prop="phone">
            <el-input v-model="user.phone" type="text" placeholder="contoh: 081254332233" />
          </el-form-item>
          <el-form-item label="Alamat" prop="address">
            <el-input v-model="user.address" type="text" />
          </el-form-item>
          <el-form-item label="role" prop="role">
            <el-select v-model="user.role" placeholder="Pilih Peran">
              <el-option
                v-for="item in opsiPeran"
                :key="item.value"
                :value="item.value"
                :label="item.label"
              >{{ item.label }}</el-option>
            </el-select>
          </el-form-item>
          <el-row>
            <el-col :span="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv'))"
                label="Kab/Kota"
                prop="kabkota"
              >
                <el-select
                  v-model="user.kabkota"
                  v-bind="pilihKota"
                  placeholder="Pilih Kab/Kota"
                  @change="pilihKecamatan"
                >
                  <el-option
                    v-for="item in AREAS"
                    :key="item.id"
                    :value="item"
                    :label="user.kabkota.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec') && !(user.role == 'staffKel'))"
                label="RW"
                prop="rw"
              >
                <el-input v-model="user.rw" type="number" placeholder="Masukan RW" />
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota'))"
                label="Kecamatan"
                prop="kecamatan"
              >
                <el-select
                  v-model="user.kecamatan"
                  placeholder="Pilih Kecamatan"
                  @change="pilihKelurahan"
                >
                  <el-option
                    v-for="item in KECAMATAN"
                    :key="item.id"
                    :value="item"
                    :label="user.kecamatan.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec') && !(user.role == 'staffKel'))"
                label="RT"
                prop="rt"
              >
                <el-input v-model="user.rt" type="number" placeholder="Masukan RT" />
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item
                v-if="(!(user.role == 'admin') && !(user.role == 'staffProv') && !(user.role == 'staffKabkota') && !(user.role == 'staffKec'))"
                label="Kelurahan"
                prop="kelurahan"
              >
                <el-select v-model="user.kelurahan" placeholder="Pilih Kelurahan">
                  <el-option
                    v-for="item in KELURAHAN"
                    :key="item.id"
                    :value="item"
                    :label="user.kelurahan.name"
                  >{{ item.name }}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12" />
          </el-row>
          <p class="warn-content">Media Sosial</p>

          <el-form-item label="Twitter" prop="twitter">
            <el-input
              v-model="user.twitter"
              type="text"
              placeholder="Contoh: @jabardigitalservice"
            />
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
              placeholder="Contoh: @jabardigitalservice"
            />
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('user')">Tambah Pengguna</el-button>
            <el-button @click="resetForm('user')">Batal</el-button>
          </el-form-item>
        </el-form>
      </el-col>
      <!-- right colomn -->
    </el-row>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  data() {
    return {
      user: {
        username: '',
        name: '',
        email: '',
        password: '',
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
        instagram: '',
        photo: ''
      },
      opsiPeran: [
        {
          label: 'Admin',
          value: 'admin'
        },
        {
          label: 'Admin Provinsi',
          value: 'staffProv'
        },
        {
          label: 'Admin Kab/kota',
          value: 'staffKabkota'
        },
        {
          label: 'Admin Kecamatan',
          value: 'staffKec'
        },
        {
          label: 'Admin kelurahan',
          value: 'staffKel'
        },
        {
          label: 'RW',
          value: 'staffRW'
        },
        { label: 'Pengguna', value: 'user' }
      ],

      // validation
      rules: {
        username: [
          {
            required: true,
            message: 'Nama pengguna harus diisi',
            trigger: 'blur'
          },
          {
            min: 4,
            message: 'Nama pengguna minimal 4 karakter',
            trigger: 'blur'
          },
          {
            max: 14,
            message: 'Nama pengguna maksimal 14 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[a-z0-9_.]+$/,
            message:
              'Nama pengguna hanya boleh menggunakan huruf, angka, underscore dan titik',
            trigger: 'blur'
          }
        ],
        name: [
          {
            required: true,
            message: 'Nama harus diisi',
            trigger: 'blur'
          },
          {
            max: 255,
            message: 'Nama pengguna maksimal 255 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[a-zA-Z.'\s]+$/,
            message: 'Nama hanya boleh menggunakan huruf, aposthrope dan titik',
            trigger: 'blur'
          }
        ],
        email: [
          {
            required: true,
            message: 'Email harus diisi',
            trigger: 'blur'
          },
          {
            type: 'email',
            message: 'Format email yang Anda masukan salah',
            trigger: 'blur'
          }
        ],
        password: [
          {
            required: true,
            message: 'Kata sandi harus diisi',
            trigger: 'blur'
          },
          {
            max: 255,
            message: 'Kata sandi maksimal 255 karakter',
            trigger: 'blur'
          },
          {
            min: 5,
            message: 'Kata sandi minimal 5 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[a-zA-Z0-9\w\S]+$/,
            message: 'Karakter kata sandi tidak sesuai',
            trigger: 'blur'
          }
        ],
        phone: [
          {
            required: true,
            message: 'Nomor telepon harus diisi',
            trigger: 'blur'
          },
          {
            min: 3,
            message: 'Nomor telepon minimal 3 karakter',
            trigger: 'blur'
          },
          {
            max: 13,
            message: 'Nomor telepon maksimal 13 karakter',
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: 'Nomor telepon hanya boleh menggunakan angka',
            trigger: 'blur'
          }
        ],
        address: [
          {
            required: true,
            message: 'Alamat harus diisi',
            trigger: 'blur'
          },
          {
            max: 255,
            message: 'Alamat maksimal 255 karakter',
            trigger: 'blur'
          }
        ],
        kabkota: [
          {
            required: true,
            message: 'Kota harus diisi',
            trigger: 'blur'
          }
        ],
        kecamatan: [
          {
            required: true,
            message: 'Kecamatan harus diisi',
            trigger: 'blur'
          }
        ],
        kelurahan: [
          {
            required: true,
            message: 'Kelurahan harus diisi',
            trigger: 'blur'
          }
        ],
        rw: [
          {
            required: true,
            message: 'RW harus diisi',
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: 'Karakter RW tidak sesuai',
            trigger: 'blur'
          }
        ],
        rt: [
          {
            required: true,
            message: 'RT harus diisi',
            trigger: 'blur'
          },
          {
            pattern: /^[0-9]+$/,
            message: 'Karakter RT tidak sesuai',
            trigger: 'blur'
          }
        ],
        role: [
          {
            required: true,
            message: 'Peran harus diisi',
            trigger: 'blur'
          }
        ],
        twitter: [
          {
            required: false
          },
          {
            pattern: /^[a-z0-9.@_]+$/,
            message: 'Karakter tidak sesuai',
            trigger: 'blur'
          }
        ],
        facebook: [
          {
            required: false
          }
        ],
        instagram: [
          {
            required: false
          },
          {
            pattern: /^[a-z0-9.@_]+$/,
            message: 'Karakter tidak sesuai',
            trigger: 'blur'
          }
        ]
      }
    }
  },
  computed: {
    ...mapGetters(['AREAS', 'KECAMATAN', 'KELURAHAN'])

    // ini kode yg kena hook
    // pilihKota: function() {
    //   return this.$store
    //     .dispatch("addUser/pilihKota")
    //     .then(() => {})
    //     .catch();
    // }
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          this.$store
            .dispatch('addUser/tambahUser', {
              username: this.user.username,
              name: this.user.name,
              email: this.user.email,
              password: this.user.password,
              phone: this.user.phone,
              address: this.user.address,
              role_id: this.user.role,
              kabkota_id: this.user.kabkota.id,
              kec_id: this.user.kecamatan.id,
              kel_id: this.user.kelurahan.id,
              rw: this.user.rw,
              facebook: this.user.facebook,
              twitter: this.user.twitter,
              instagram: this.user.instagram
            })
            .then(() => {
              this.$alert('Pengguna berhasil ditambahkan', {
                callback: action => {}
              })

              this.user.username = ''
              this.user.name = ''
              this.user.email = ''
              this.user.password = ''
              this.user.role = ''
              this.user.kabkota = ''
              this.user.kecamatan = ''
              this.user.kelurahan = ''
              this.user.rt = ''
              this.user.rw = ''
              this.user.facebook = ''
              this.user.twitter = ''
              this.user.instagram = ''
              this.user.phone = ''
              this.user.address = ''
            })
            .catch(() => {})
        } else {
          return false
        }
      })
    },
    resetForm(formName) {
      this.$refs[formName].resetFields()
    },
    pilihKecamatan: function() {
      this.$store.dispatch('addUser/pilihKecamatan', this.user.kabkota.id)
    },
    pilihKelurahan: function() {
      this.$store.dispatch('addUser/pilihKelurahan', this.user.kecamatan.id)
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
    },
    // Upload image
    onFileSelected(event) {
      this.photo = event.target.files[0]
    }
  }
}
</script>
<style lang="scss" scoped>
.upload-demo {
  margin: 10px auto;
}
.grid-content:first-child {
  margin-bottom: 20px;
}

p {
  color: #42b983;
  font-weight: 600;
}
.app-container {
  padding: 5px 20px;
}

#password {
  .el-row {
    margin-right: 10px;
    &:last-child {
      margin-bottom: 0;
    }
  }
}

.el-row {
  margin-left: 0px;
  &:last-child {
    margin-bottom: 0;
  }
}
.el-col {
  border-radius: 4px;
}
.bg-purple {
  background: #d3dce6;
}
.bg-purple-light {
  background: #e5e9f2;
}
.grid-content {
  border-radius: 4px;
  min-height: 36px;
}
.row-bg {
  padding: 10px 0;
  background-color: #f9fafc;
}
.el-upload .avatar-uploader {
  // border: 5px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
