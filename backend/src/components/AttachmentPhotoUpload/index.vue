<template>
  <div>
    <div class="user-image">
      <div class="image-preview">
        <div v-loading="loading">
          <img class="preview" loading="lazy" :src="image_url === null ? image_default : image_url">
        </div>
      </div>

      <el-button type="primary" style="width: 100%;" @click="launchFilePicker">Pilih Foto</el-button>

      <input ref="file" type="file" accept="image/*" @change="onFileSelected">
    </div>
  </div>
</template>

<script>
import { upload } from '@/api/attachments'

export default {
  props: ['initialUrl'], // eslint-disable-line
  data() {
    return {
      image_default: 'https://imgplaceholder.com/720x405/cccccc/757575/glyphicon-search?font-size=36',
      image: null,
      image_url: null,
      loading: false
    }
  },
  watch: {
    initialUrl: {
      handler: function(value) {
        this.image_url = value
      },
      immediate: true
    }
  },
  mounted() {
    //
  },
  methods: {
    launchFilePicker() {
      this.$refs.file.click()
    },
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
        // this.preview = reader.readAsDataURL(this.image)
        this.onUpload()
      }
    },

    async onUpload() {
      this.loading = true
      const formData = new FormData()

      formData.append('file', this.image, this.image.name)
      formData.append('type', 'phonebook_photo')

      const { data } = await upload(formData)
      const { path, url } = data

      this.image_url = url

      this.$emit('onUpload', path, url)
      this.loading = false
    }
  }
}
</script>

<style lang="scss">
.user-image {
  img.preview {
    width: 100%;
  }

  input[type="file"] {
    display: none;
  }
}
</style>
