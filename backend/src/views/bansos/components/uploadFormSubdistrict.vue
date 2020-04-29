<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <span class="head-title">
          <b>Kecamatan</b>
        </span>
      </el-col>
    </el-row>
    <br>
    <el-row :gutter="40" v-for="(data, index) in uploadFormSubdistrictList" :key="data.id">
      <el-col :span="1">
        <el-button type="text" @click="handleAddFrom"><i class="el-icon-delete"></i></el-button>
      </el-col>
      <el-col :span="12">
        <el-select v-model="value" placeholder="Select" style="width:100%">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </el-col>
      <el-col :span="11">
        <el-upload
          drag
          action="https://jsonplaceholder.typicode.com/posts/"
          :multiple="false"
        >
          <div class="el-upload__text"><i class="el-icon-upload"></i><em> Add File </em>or drop files here</div>
        </el-upload>
      </el-col>
    </el-row>
    <el-row :gutter="40">
      <el-col :span="24" style="text-align:right">
        <el-button type="text" @click="handleAddFrom">Upload Lagi <i class="el-icon-plus"></i></el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'UploadFormSubdistrict',
  data() {
    return {
      options: [{
        value: 'Option1',
        label: 'Option1'
      }, {
        value: 'Option2',
        label: 'Option2'
      }],
      value: '',

      idUploadFormSubdistrict: 0,
      uploadFormSubdistrictList: []
    }
  },
  created () {
    this.handleAddFrom()
  },
  methods: {
    handleAddFrom() {
      this.idUploadFormSubdistrict = this.idUploadFormSubdistrict + 1
      this.uploadFormSubdistrictList.push({
        id: this.idUploadFormSubdistrict
      })
    }
  }
}
</script>

<style>
.el-row {
  margin-bottom: 10px;
}
.el-upload {
    display: inline-block;
    text-align: center;
    cursor: pointer;
    outline: none;
    width: 100%;
}
.el-upload-dragger {
    background-color: #fff;
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    height: 36px !important;
    text-align: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    width: 100% !important;
}
.el-upload-dragger .el-icon-upload {
    font-size: 20px;
    color: #C0C4CC;
    margin: -10px 0 -10px;
    line-height: 50px;
}
</style>