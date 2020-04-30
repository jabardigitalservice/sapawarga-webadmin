<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <span class="head-title">
          <b>{{ $t('label.area-kabkota') }}</b>
        </span>
      </el-col>
    </el-row>
    <br>
    <el-row :gutter="40">
      <el-col :span="12">
        <el-select v-model="value" :placeholder="$t('label.choose-area-kabkota')" style="width:100%">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>
      <el-col :span="12">
        <el-upload
          drag
          action="https://jsonplaceholder.typicode.com/posts/"
          :multiple="false"
          :limit="1"
        >
          <div class="el-upload__text"><i class="el-icon-upload" /><em> Add File </em>or drop files here</div>
        </el-upload>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'FormUploadCity',
  data() {
    return {
      options: [{
        value: 'cianjur',
        label: 'KAB. CIANJUR'
      }, {
        value: 'cirebon',
        label: 'KAB. CIREBON'
      }],
      value: ''
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

