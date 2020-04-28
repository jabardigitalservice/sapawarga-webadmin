<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-card class="box-card">
          <div slot="header">
            <span>Upload Form</span>
          </div>
          <div class="text item">
            <el-collapse accordion>
              <el-collapse-item title="Upload Data Alokasi Bantuan Kota Bandung" name="1">
                <p>Upload File</p>
                <el-upload
                  class="upload-demo"
                  ref="upload"
                  action="https://jsonplaceholder.typicode.com/posts/"
                  :auto-upload="false">
                  <el-button slot="trigger" size="small" type="primary">select file</el-button>
                  <el-button style="margin-left: 10px;" size="small" type="success">upload to server</el-button>
                </el-upload>
              </el-collapse-item>
              <el-collapse-item title="Upload Data Alokasi Bantuan Per Kecamatan" name="2">
                <p>Upload File</p>
                <el-upload
                  class="upload-demo"
                  ref="upload"
                  action="https://jsonplaceholder.typicode.com/posts/"
                  :auto-upload="false">
                  <el-button slot="trigger" size="small" type="primary">select file</el-button>
                  <el-button style="margin-left: 10px;" size="small" type="success">upload to server</el-button>
                </el-upload>
              </el-collapse-item>
              <el-collapse-item title="Upload Data Alokasi Bantuan Per Desa/Kelurahan" name="3">
                <p>Upload File</p>
                <el-upload
                  class="upload-demo"
                  ref="upload"
                  action="https://jsonplaceholder.typicode.com/posts/"
                  :auto-upload="false">
                  <el-button slot="trigger" size="small" type="primary">select file</el-button>
                  <el-button style="margin-left: 10px;" size="small" type="success">upload to server</el-button>
                </el-upload>
              </el-collapse-item>
            </el-collapse>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  //
}
</script>
