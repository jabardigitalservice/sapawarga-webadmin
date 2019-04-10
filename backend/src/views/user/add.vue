<template>
  <div class="app-container">
    <!-- <p class="warn-content">Tambah Pengguna</p> -->
    <el-row :gutter="20">
      <!-- Left colomn -->
      <el-col :span="5" class="grid-content">
        <el-upload
          class="avatar-uploader"
          action="https://jsonplaceholder.typicode.com/posts/"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :before-upload="beforeAvatarUpload"
        >
          <img v-if="imageUrl" :src="imageUrl" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-col>
      <!-- Center colomn -->
      <el-col :span="13">
        <div class="grid-content">
          <el-form
            :model="ruleForm2"
            status-icon
            :rules="rules2"
            ref="ruleForm2"
            label-width="150px"
            label-position="left"
            class="demo-ruleForm"
          >
            <p class="warn-content">Profile Pengguna</p>
            <el-form-item label="Nama Pengguna" prop="pass">
              <el-input type="text" v-model="username"></el-input>
            </el-form-item>
            <el-form-item label="Nama" prop="pass">
              <el-input type="text" v-model="nama"></el-input>
            </el-form-item>
            <el-form-item label="Email" prop="pass">
              <el-input type="email" v-model="email"></el-input>
            </el-form-item>
            <el-form-item label="Telepon" prop="pass">
              <el-input type="number" v-model="telepon"></el-input>
            </el-form-item>
            <el-form-item label="Alamat" prop="pass">
              <el-input type="text" v-model="alamat"></el-input>
            </el-form-item>
            <el-row>
              <el-col :span="12">
                <el-form-item label="Kab/Kota">
                  <el-select v-model="region" placeholder="Pilih Kota/Kab">
                    <el-option label="Zone one" value></el-option>
                    <el-option label="Zone two" value></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="RW">
                  <el-select v-model="region" placeholder="Pilih RW">
                    <el-option label="Zone one" value></el-option>
                    <el-option label="Zone two" value></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
            </el-row>

            <el-row>
              <el-col :span="12">
                <el-form-item label="Kecamatan">
                  <el-select v-model="region" placeholder="Pilih Kecamatan">
                    <el-option label="Zone one" value></el-option>
                    <el-option label="Zone two" value></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="RT">
                  <el-select v-model="region" placeholder="Pilih RT">
                    <el-option label="Zone one" value></el-option>
                    <el-option label="Zone two" value></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
            </el-row>

            <el-row>
              <el-col :span="12">
                <el-form-item label="Kelurahan">
                  <el-select v-model="region" placeholder="Pilih Kelurahan">
                    <el-option label="Zone one" value></el-option>
                    <el-option label="Zone two" value></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Role">
                  <el-select v-model="region" placeholder="Pilih RW">
                    <el-option label="Zone one" value></el-option>
                    <el-option label="Zone two" value></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
            </el-row>

            <p class="warn-content">Media Sosial</p>

            <el-form-item label="Twitter" prop="pass">
              <el-input type="text" v-model="twitter"></el-input>
            </el-form-item>

            <el-form-item label="Facebook" prop="pass">
              <el-input type="text" v-model="facebook"></el-input>
            </el-form-item>

            <el-form-item label="Instagram" prop="pass">
              <el-input type="text" v-model="instagram"></el-input>
            </el-form-item>

            <!-- <el-form-item label="Confirm" prop="checkPass">
              <el-input type="password" v-model="ruleForm2.checkPass" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="Age" prop="age">
              <el-input v-model.number="ruleForm2.age"></el-input>
            </el-form-item>-->

            <el-form-item>
              <el-button type="primary" @click="submitForm('ruleForm2')">Submit</el-button>
              <el-button @click="resetForm('ruleForm2')">Reset</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-col>
      <!-- right colomn -->
      <el-col :span="6">
        <div class="grid-content bg-purple"></div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  data() {
    var checkAge = (rule, value, callback) => {
      if (!value) {
        return callback(new Error("Please input the age"));
      }
      setTimeout(() => {
        if (!Number.isInteger(value)) {
          callback(new Error("Please input digits"));
        } else {
          if (value < 18) {
            callback(new Error("Age must be greater than 18"));
          } else {
            callback();
          }
        }
      }, 1000);
    };
    var validatePass = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("Please input the password"));
      } else {
        if (this.ruleForm2.checkPass !== "") {
          this.$refs.ruleForm2.validateField("checkPass");
        }
        callback();
      }
    };
    var validatePass2 = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("Please input the password again"));
      } else if (value !== this.ruleForm2.pass) {
        callback(new Error("Two inputs don't match!"));
      } else {
        callback();
      }
    };
    return {
      ruleForm2: {
        pass: "",
        checkPass: "",
        age: "",
        username: ""
      },
      rules2: {
        pass: [{ validator: validatePass, trigger: "blur" }],
        checkPass: [{ validator: validatePass2, trigger: "blur" }],
        age: [{ validator: checkAge, trigger: "blur" }]
      }
    };
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          alert("submit!");
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    }
  }
};
</script>



<style lang="scss" scoped>
.warn-content {
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
</style>
