<template>
  <div>
    <el-upload class="avatar-uploader" action="http://35.247.135.93.xip.io/api/v1/attachments" :thumbnail-mode="true" :data="requestData" :headers="requestHeaders">
      <img v-if="imageUrl" :src="imageUrl" class="avatar">
      <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>

  </div>
</template>

<script>
import { getToken } from '@/utils/auth'

export default {
  data() {
    return {
      requestHeaders: {
        'Authorization': null
      },
      requestData: {
        type: 'phonebook_photo'
      },
      imageUrl: null
    }
  },
  methods: {
    handleAvatarSuccess(res, file) {
      //
    },
    beforeAvatarUpload(file) {
      //
    }
  },
  mounted() {
    const requestToken = getToken()

    this.requestHeaders['Authorization'] = `Bearer ${requestToken}`
  }
}
</script>

<style>
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
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
    width: 100%;
    height: 178px;
    display: block;
  }
</style>

