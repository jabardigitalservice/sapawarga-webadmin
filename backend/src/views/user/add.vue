<template>
  <div class="app-container">
    <!-- <p class="warn-content">Tambah Pengguna</p> -->
    <p class="warn-content">Profile Pengguna</p>
    <el-row :gutter="10">
      <!-- Left colomn -->
      <el-col :sm="24" :lg="8" :xl="8" class="grid-content">
        <el-upload
          class="upload-demo"
          drag
          action="https://jsonplaceholder.typicode.com/posts/"
          multiple
        >
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
          status-icon
          label-width="150px"
          label-position="left"
          class="demo-ruleForm"
          :rules="rules"
          ref="user"
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
          <el-row>
            <el-col :span="12">
              <el-form-item label="Kab/Kota" prop="kota">
                <el-select v-model="user.kota" placeholder="Pilih Kota/Kab">
                  <el-option label value></el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item label="RW" prop="rw">
                <el-select v-model="user.rw" placeholder="Pilih RW">
                  <el-option label value></el-option>
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item label="Kecamatan" prop="kecamatan">
                <el-select v-model="user.kecamatan" placeholder="Pilih Kecamatan">
                  <el-option label value></el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item label="RT" prop="rt">
                <el-select v-model="user.rt" placeholder="Pilih RT">
                  <el-option label value></el-option>
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-form-item label="Kelurahan" prop="kelurahan">
                <el-select v-model="user.kelurahan" placeholder="Pilih Kelurahan">
                  <el-option label value></el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item label="Peran" prop="peran">
                <el-select v-model="user.role" placeholder="Pilih Peran">
                  <el-option label value></el-option>
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>
          <p class="warn-content">Media Sosial</p>
          <el-form-item label="Twitter" prop="twitter">
            <el-input type="text" v-model="user.twitter"></el-input>
          </el-form-item>
          <el-form-item label="Facebook" prop="facebook">
            <el-input type="text" v-model="user.facebook"></el-input>
          </el-form-item>
          <el-form-item label="Instagram" prop="instagram">
            <el-input type="text" v-model="user.instagram"></el-input>
          </el-form-item>
          <!-- <el-form-item label="Confirm" prop="checkPass">
              <el-input type="password" v-model="ruleForm2.checkPass" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="Age" prop="age">
              <el-input v-model.number="ruleForm2.age"></el-input>
          </el-form-item>-->
          <el-form-item>
            <el-button type="primary" @click="submitForm(user)">Tambah Pengguna</el-button>
            <el-button @click="resetForm(user)">Batal</el-button>
          </el-form-item>
        </el-form>
      </el-col>
      <!-- right colomn -->
    </el-row>
  </div>
</template>
<script>
export default {
  data() {
    // var checkAge = (rule, value, callback) => {
    //   if (!value) {
    //     return callback(new Error("Please input the age"));
    //   }
    //   setTimeout(() => {
    //     if (!Number.isInteger(value)) {
    //       callback(new Error("Please input digits"));
    //     } else {
    //       if (value < 18) {
    //         callback(new Error("Age must be greater than 18"));
    //       } else {
    //         callback();
    //       }
    //     }
    //   }, 1000);
    // };
    // var validatePass = (rule, value, callback) => {
    //   if (value === "") {
    //     callback(new Error("Please input the password"));
    //   } else {
    //     if (this.ruleForm2.checkPass !== "") {
    //       this.$refs.ruleForm2.validateField("checkPass");
    //     }
    //     callback();
    //   }
    // };
    // var validatePass2 = (rule, value, callback) => {
    //   if (value === "") {
    //     callback(new Error("Please input the password again"));
    //   } else if (value !== this.ruleForm2.pass) {
    //     callback(new Error("Two inputs don't match!"));
    //   } else {
    //     callback();
    //   }
    // };
    return {
      user: {
        username: "",
        nama: "",
        email: "",
        password: "",
        telepon: "",
        alamat: "",
        kota: "",
        kecamatan: "",
        kelurahan: "",
        rw: "",
        rt: "",
        peran: "",
        twitter: "",
        facebook: "",
        instagram: "",
        photo: ""
      },
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
    submitForm(user) {
      // this.$refs[formName].validate(valid => {
      //   if (valid) {
      //     alert("submit!");
      //   } else {
      //     console.log("error submit!!");
      //     return false;
      //   }
      // });
      console.log(user);
    },
    resetForm(user) {
      this.$refs[formName].resetFields();
    }
  }
};
</script>
<style lang="scss" scoped>
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
