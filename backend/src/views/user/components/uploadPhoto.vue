<template>
  <div class="app-container">
    <el-form>
      <el-form-item label="Photo" prop="photo">
        <div class="image-preview">
          <img class="preview" :src="imageData">
        </div>
        <input type="file" class="input-image" accept="image/*" @change="onFileSelected">
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
      urlImage: null
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
      const formData = new FormData()
      formData.append('image', this.image, this.image.name)
      uploadImage(formData).then(response => {
        const link_photo = response.data.photo_url
        const photo_name = link_photo.substring(link_photo.lastIndexOf('/', link_photo.lastIndexOf('/') - 1) + 1)
        this.urlImage = photo_name

        this.$emit('onUpload', this.urlImage)
      }).catch(error => {
        const image_error = error.response.data.status
        if (image_error === 500) {
          Message({
            message: 'Ukuran foto tidak boleh lebih dari 2 MB. Mohon unggah kembali foto Anda',
            type: 'error',
            duration: 5 * 1000
          })
        }
        this.imageData = require('@/assets/user.png')
        this.image = null
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.input-image {
  margin-left: 75px;
}
img.preview {
    width: 200px;
    background-color: white;
    border: 1px solid #DDD;
    padding: 5px;
    margin-left: 25px;

}
@media only screen and (min-width: 1200px)  and (max-width: 1600px) {
  .input-image {
    margin-left: 0px;
  }
  img.preview {
      width: 150px;
      background-color: white;
      border: 1px solid #DDD;
      padding: 5px;
      margin-left: 0px;
  }
}

</style>
