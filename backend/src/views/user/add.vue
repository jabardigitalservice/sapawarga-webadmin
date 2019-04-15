<template>
  <div class="app-container">
    <!-- <p class="warn-content">Tambah Pengguna</p> -->
    <p class="warn-content">Profile Pengguna</p>
    <el-row :gutter="10">
      <!-- Left colomn -->
      <el-col :sm="24" :lg="8" :xl="8" class="grid-content">
        <el-upload class="upload-demo" drag multiple v-model="user.photo" action>
          <i class="el-icon-upload"></i>
          <div class="el-upload__text">
            Unggah foto disini
            <em>Klik untuk mengunggah</em>
          </div>
          <!-- <div class="el-upload__tip" slot="tip">jpg/png files with a size less than 500kb</div> -->
        </el-upload>
      </el-col>

      <!-- Center colomn -->
      <el-col :sm="24" :lg="15" :xl="14" class="grid-content">
        <el-form
          :model="user"
          ref="user"
          status-icon
          label-width="150px"
          label-position="left"
          class="demo-ruleForm"
          :rules="rules"
        >
          <el-form-item label="Nama Pengguna" prop="username">
            <el-input type="text" v-model="user.username"></el-input>
          </el-form-item>
          <el-form-item label="Nama" prop="nama">
            <el-input type="text" v-model="user.nama"></el-input>
          </el-form-item>

          <el-form-item label="Email" prop="email">
            <el-input type="email" v-model="user.email"></el-input>
          </el-form-item>
          <el-form-item label="Password" prop="password">
            <el-input type="password" v-model="user.password"></el-input>
          </el-form-item>
          <el-form-item label="Telepon" prop="telepon">
            <el-input type="number" v-model="user.telepon"></el-input>
          </el-form-item>
          <el-form-item label="Alamat" prop="alamat">
            <el-input type="text" v-model="user.alamat"></el-input>
          </el-form-item>
          <el-form-item label="Peran" prop="peran">
            <el-select v-model="user.peran" placeholder="Pilih Peran">
              <el-option
                v-for="item in opsiPeran"
                :value="item.value"
                :key="item.value"
                :label="user.peran.value"
              ></el-option>
            </el-select>
            {{user.peran}}
          </el-form-item>
          <el-row>
            <el-col :span="12">
              <el-form-item
                label="Kab/Kota"
                prop="kota"
                v-if="(!(this.user.peran == 'admin') && !(this.user.peran == 'staffProv'))"
              >
                <el-select
                  v-bind="pilihKota"
                  v-model="user.kota"
                  placeholder="Pilih Kab/Kota"
                  @change="pilihKecamatan"
                >
                  <el-option
                    v-for="item in AREAS"
                    :key="item.id"
                    :value="item"
                    :label="user.kota.name"
                  >{{item.name}}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                label="RW"
                prop="rw"
                v-if="(!(this.user.peran == 'admin') && !(this.user.peran == 'staffProv'))"
              >
                <el-input type="number" v-model="user.rw" placeholder="Masukan RW"></el-input>
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item
                label="Kecamatan"
                prop="kecamatan"
                v-if="(!(this.user.peran == 'admin') && !(this.user.peran == 'staffProv'))"
              >
                <el-select
                  v-model="user.kecamatan"
                  placeholder="Pilih Kecamatan"
                  @change="pilihKelurahan"
                >
                  <el-option
                    v-for="item in KECAMATAN"
                    :value="item"
                    :key="item.id"
                    :label="user.kecamatan.name"
                  >{{item.name}}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item
                label="RT"
                prop="rt"
                v-if="(!(this.user.peran == 'admin') && !(this.user.peran == 'staffProv'))"
              >
                <el-input type="number" v-model="user.rt" placeholder="Masukan RT"></el-input>
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item
                label="Kelurahan"
                prop="kelurahan"
                v-if="(!(this.user.peran == 'admin') && !(this.user.peran == 'staffProv'))"
              >
                <el-select v-model="user.kelurahan" placeholder="Pilih Kelurahan">
                  <el-option
                    v-for="item in KELURAHAN"
                    :value="item"
                    :key="item.id"
                    :label="user.kelurahan.name"
                  >{{item.name}}</el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12"></el-col>
          </el-row>
          <p class="warn-content">Media Sosial</p>
          <el-form-item label="Twitter" prop="twitter">
            <el-input type="text" v-model="user.twitter" disabled="false"></el-input>
          </el-form-item>
          <el-form-item label="Facebook" prop="facebook">
            <el-input type="text" v-model="user.facebook"></el-input>
          </el-form-item>
          <el-form-item label="Instagram" prop="instagram">
            <el-input type="text" v-model="user.instagram"></el-input>
          </el-form-item>
          <el-form-item label="Photo">
            <el-input type="text" v-model="user.photo"></el-input>
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
import { mapGetters } from "vuex";
import { mapActions } from "vuex";
export default {
  data() {
    return {
      user: {
        username: "",
        nama: "",
        email: "",
        password: "",
        telepon: "",
        alamat: "",
        kota: [
          {
            id: "",
            parent_id: "",
            depth: "",
            name: ""
          }
        ],
        kecamatan: [
          {
            id: "",
            parent_id: "",
            depth: "",
            name: ""
          }
        ],
        kelurahan: [
          {
            id: "",
            parent_id: "",
            depth: "",
            name: ""
          }
        ],
        rw: "",
        rt: "",
        peran: [],
        twitter: "",
        facebook: "",
        instagram: "",
        photo: ""
      },
      opsiPeran1: ["admin", "staffProv"],

      opsiPeran: [
        {
          value: "admin"
        },
        {
          value: "staffProv"
        },
        {
          value: "staffKabkota"
        },
        {
          value: "staffKec"
        },
        {
          value: "staffKel"
        },
        {
          value: "staffRW"
        },
        {
          value: "user"
        }
      ],

      // validation
      rules: {
        username: [
          {
            required: true,
            message: "Nama pengguna harus diisi",
            trigger: "blur"
          },
          {
            min: 4,
            message: "Nama pengguna minimal 4 karakter",
            trigger: "blur"
          },
          {
            max: 14,
            message: "Nama pengguna maksimal 14 karakter",
            trigger: "blur"
          },
          {
            pattern: /^[a-z0-9_.]+$/,
            message: "Karakter nama pengguna tidak sesuai",
            trigger: "blur"
          }
        ],
        nama: [
          {
            required: true,
            message: "Nama harus diisi",
            trigger: "blur"
          },
          {
            max: 255,
            message: "Nama pengguna maksimal 255 karakter",
            trigger: "blur"
          },
          {
            pattern: /^[a-zA-Z.'\s]+$/,
            message: "Karakter Nama tidak sesuai",
            trigger: "blur"
          }
        ],
        email: [
          {
            required: true,
            message: "Email harus diisi",
            trigger: "blur"
          },
          {
            type: "email",
            message: "Format email yang Anda masukan salah",
            trigger: "blur"
          }
        ],
        password: [
          {
            required: true,
            message: "Kata sandi harus diisi",
            trigger: "blur"
          },
          {
            max: 255,
            message: "Kata sandi maksimal 255 karakter",
            trigger: "blur"
          },
          {
            min: 5,
            message: "Kata sandi minimal 5 karakter",
            trigger: "blur"
          },
          {
            pattern: /^[a-zA-Z0-9\w\S]+$/,
            message: "Karakter kata sandi tidak sesuai",
            trigger: "blur"
          }
        ],
        telepon: [
          {
            required: true,
            message: "Nomor telepon harus diisi",
            trigger: "blur"
          },
          {
            min: 3,
            message: "Nomor telepon minimal 3 karakter",
            trigger: "blur"
          },
          {
            max: 13,
            message: "Nomor telepon maksimal 13 karakter",
            trigger: "blur"
          }
        ],
        alamat: [
          {
            required: true,
            message: "Alamat harus diisi",
            trigger: "blur"
          },
          {
            max: 255,
            message: "Alamat maksimal 255 karakter",
            trigger: "blur"
          }
        ],
        kota: [
          {
            required: true,
            message: "Kota harus diisi",
            trigger: "blur"
          },
          {
            max: 25,
            message: "Kota/Kab maksimal 25 kota",
            trigger: "blur"
          },
          {
            pattern: /^[a-zA-Z\s]+$/,
            message: "Karakter Kota/Kab tidak sesuai",
            trigger: "blur"
          }
        ],
        kecamatan: [
          {
            required: true,
            message: "Kecamatan harus diisi",
            trigger: "blur"
          },
          {
            min: 4,
            message: "Kecamatan minimal 4 karakter",
            trigger: "blur"
          },
          {
            max: 50,
            message: "Kecamatan maksimal 50 karakter",
            trigger: "blur"
          },
          {
            pattern: /^[a-zA-Z\s]+$/,
            message: "Karakter Kecamatan tidak sesuai",
            trigger: "blur"
          }
        ],
        kelurahan: [
          {
            required: true,
            message: "Kelurahan harus diisi",
            trigger: "blur"
          },
          {
            min: 4,
            message: "Kelurahan minimal 4 karakter",
            trigger: "blur"
          },
          {
            max: 50,
            message: "Kelurahan maksimal 50 karakter",
            trigger: "blur"
          },
          {
            pattern: /^[a-zA-Z\s]+$/,
            message: "Karakter Kelurahan tidak sesuai",
            trigger: "blur"
          }
        ],
        rw: [
          {
            required: true,
            message: "RW harus diisi",
            trigger: "blur"
          },
          {
            min: 3,
            message: "masukan 3 angka",
            trigger: "blur"
          },
          {
            min: 3,
            message: "Masukan 3 angka",
            trigger: "blur"
          },
          {
            pattern: /^[0-9]+$/,
            message: "Karakter RW tidak sesuai",
            trigger: "blur"
          }
        ],
        rt: [
          {
            required: true,
            message: "RT harus diisi",
            trigger: "blur"
          },
          {
            min: 3,
            message: "masukan 3 angka",
            trigger: "blur"
          },
          {
            min: 3,
            message: "Masukan 3 angka",
            trigger: "blur"
          },
          {
            pattern: /^[0-9]+$/,
            message: "Karakter RT tidak sesuai",
            trigger: "blur"
          }
        ],
        peran: [
          {
            required: true,
            message: "Peran harus diisi",
            trigger: "blur"
          }
        ],
        twitter: [
          {
            required: false
          },
          {
            pattern: /^[a-z0-9._]+$/,
            message: "Karakter tidak sesuai",
            trigger: "blur"
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
            pattern: /^[a-z0-9._]+$/,
            message: "Karakter tidak sesuai",
            trigger: "blur"
          }
        ]
      }
    };
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          console.log(this.user.username);
          this.$store
            .dispatch("addUser/tambahUser", {
              username: this.user.username,
              email: this.user.email,
              password: this.user.password,
              role_id: this.user.peran
            })
            .then(() => {
              console.log("data berhasil ditambah");
            })
            .catch(() => {
              console.log("data gagal");
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
    pilihKecamatan: function() {
      this.$store.dispatch("addUser/pilihKecamatan", this.user.kota.id);
    },
    pilihKelurahan: function() {
      this.$store.dispatch("addUser/pilihKelurahan", this.user.kecamatan.id);
    }
  },
  computed: {
    ...mapGetters(["AREAS", "KECAMATAN", "KELURAHAN"]),
    pilihKota() {
      this.$store
        .dispatch("addUser/pilihKota")
        .then(() => {})
        .catch(err => {});
    }
  }
};
</script>
<style lang="scss" scoped>
.upload-demo {
  margin: 10px auto;
}
.grid-content:first-child {
  margin-bottom: 20px;
}
.upload-demo {
  // padding: 20px;
}
p {
  color: #42b983;
  font-weight: 600;
}
.app-container {
  padding: 5px 20px;
}
.el-row {
  margin-left: 20px;
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
