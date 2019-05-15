<template>
  <div class="app-container">
    <el-form>
      <el-form-item label="" prop="photo">
        <div class="user-image">
          <div class="image-preview">
            <div v-loading="loading">
              <img class="preview" :src="imageData">
            </div>
          </div>
          <label class="custom-file-upload primary-custome">
            <input type="file" accept="image/*" @change="onFileSelected">
            Pilih Foto
          </label>
        </div>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import { uploadImage } from '@/api/staff'
import { Message } from 'element-ui'
export default {
  props: {
    linkEditPhoto: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      imageData: require('@/assets/user.png'),
      image: '',
      urlImage: null,
      loading: false
    }
  },
  watch: {
    linkEditPhoto: function() {
      if (this.linkEditPhoto !== null) {
        this.imageData = this.linkEditPhoto
      }
    }
  },
  methods: {
    onFileSelected(event) {
      this.image = event.target.files[0]
      if (this.image) {
        // create a new FileReader to read this image and convert to base64 format
        var reader = new FileReader()
        // Define a callback function to run, when FileReader finishes its job
        reader.onload = (e) => {
          // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
          // Read image as base64 and set to imageData
          // this.imageData = this.user.photo
          this.imageData = e.target.result
        }
        // Start the reader job - read file as a data url (base64 format)
        this.preview = reader.readAsDataURL(this.image)
        this.onUpload()
      }
    },
    onUpload() {
      this.loading = true
      const formData = new FormData()
      formData.append('image', this.image, this.image.name)
      uploadImage(formData).then(response => {
        const link_photo = response.data.photo_url
        const photo_name = link_photo.substring(link_photo.lastIndexOf('/', link_photo.lastIndexOf('/') - 1) + 1)
        this.urlImage = photo_name
        this.$emit('onUpload', this.urlImage)
        this.loading = false
      }).catch(error => {
        const image_error = error.response.data.status
        if (image_error === 422) {
          Message({
            message: 'Ukuran photo tidak boleh lebih dari 2 MB. Mohon unggah kembali foto Anda',
            type: 'error',
            duration: 5 * 1000
          })
        }
        if (image_error === 500) {
          Message({
            message: 'Oops, telah terjadi kesalahan, silahkan muat ulang halaman ini.',
            type: 'error',
            duration: 5 * 1000
          })
        }
        this.loading = false
        this.imageData = require('@/assets/user.png')
        this.image = null
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.user-image {
  margin: auto;
  width: 200px;
}
input[type="file"] {
  display: none;
}
.custom-file-upload {
  display: inline-block;
  line-height: 1;
  white-space: nowrap;
  cursor: pointer;
  background: #FFFFFF;
  border: 1px solid #DCDFE6;
  border-color: #DCDFE6;
  color: #606266;
  -webkit-appearance: none;
  text-align: center;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  outline: none;
  margin: 0;
  -webkit-transition: .1s;
  transition: .1s;
  font-weight: 400;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  padding: 12px 20px;
  font-size: 14px;
  border-radius: 4px;
  width: 200px;
}
.primary-custome {
  color: #409eff;
  background: #ecf5ff;
  border-color: #b3d8ff;
}

.primary-custome:hover {
  background: #46a6ff;
  border-color: #46a6ff;
  color: #FFFFFF;
}

img.preview {
  width: 200px;
  border-radius: 10px;
  box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
  -moz-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
  -webkit-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
  background-color: blue;
}
@media only screen and (min-width: 1200px)  and (max-width: 1291px) {
  img.preview {
    width: 150px;
    margin-left: 0px;
    border-radius: 10px;
    box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
    -moz-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
    -webkit-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
  }
  .custom-file-upload {
    display: inline-block;
    line-height: 1;
    white-space: nowrap;
    cursor: pointer;
    background: #FFFFFF;
    border: 1px solid #DCDFE6;
    border-color: #DCDFE6;
    color: #606266;
    -webkit-appearance: none;
    text-align: center;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    outline: none;
    margin: 0;
    -webkit-transition: .1s;
    transition: .1s;
    font-weight: 400;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    padding: 12px 20px;
    font-size: 14px;
    border-radius: 4px;
    margin-left: 0px;
    width: 150px;
  }
  .primary-custome {
    color: #409eff;
    background: #ecf5ff;
    border-color: #b3d8ff;
  }

  .primary-custome:hover {
    background: #46a6ff;
    border-color: #46a6ff;
    color: #FFFFFF;
  }
}

@media only screen and (min-width: 1292px)  and (max-width: 1651px) {
  img.preview {
    width: 150px;
    margin-left: 0px;
    border-radius: 10px;
    box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
    -moz-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
    -webkit-box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.43);
  }
  .custom-file-upload {
    display: inline-block;
    line-height: 1;
    white-space: nowrap;
    cursor: pointer;
    background: #FFFFFF;
    border: 1px solid #DCDFE6;
    border-color: #DCDFE6;
    color: #606266;
    -webkit-appearance: none;
    text-align: center;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    outline: none;
    margin: 0;
    -webkit-transition: .1s;
    transition: .1s;
    font-weight: 400;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    padding: 12px 20px;
    font-size: 14px;
    border-radius: 4px;
    width: 150px;
  }
  .primary-custome {
    color: #409eff;
    background: #ecf5ff;
    border-color: #b3d8ff;
  }

  .primary-custome:hover {
    background: #46a6ff;
    border-color: #46a6ff;
    color: #FFFFFF;
  }
}

</style>

}
