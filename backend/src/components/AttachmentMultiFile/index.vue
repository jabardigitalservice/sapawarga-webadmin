<template>
  <div>
    <label class="custom-file-upload primary-custome"> {{ $t('label.select-file') }}
      <input ref="file" type="file" accept=".pdf, .doc, .docx, .ppt, .pptx, image/*" @change="handleFileUpload">
    </label>
    <span v-if="file !== null" class="file-name">
      {{ file.name }}
      <el-tooltip class="item" effect="dark" content="Hapus lampiran" placement="right">
        <span class="remove" @click="removeFile">x</span>
      </el-tooltip>
    </span>
  </div>
</template>
<script>
import { upload } from '@/api/attachments'
export default {
  props: {

  },
  data() {
    return {
      file: null
    }
  },
  methods: {
    handleFileUpload(event) {
      this.file = this.$refs.file.files[0]
      // this.file = event.target.files[0]
      console.log(this.file)
      this.onUpload()
    },
    async onUpload() {
      try {
        this.loading = true

        const formData = new FormData()

        formData.append('file', this.file)
        formData.append('type', 'news_important_attachment')

        const { data } = await upload(formData)
        const { path, url } = data

        this.$emit('onUpload', path, url)
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    removeFile() {
      this.file = null
      console.log(this.file)
    }
  }
}
</script>
<style lang="scss" scoped>
	input[type="file"] {
    display: none;
  }

  .custom-file-upload {
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
    -webkit-transition: .1s;
    transition: .1s;
    font-weight: 400;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    font-size: 14px;
    border-radius: 4px;
    width: 90px;
    display: inline-block;
		padding: 0px 0px;
    margin-bottom: 10px;
  }

  .import-file {
    display: block;
  }

  .primary-custome {
    color: white;
    background:#409eff;
    border-color: #409eff;
  }

  .primary-custome:hover {
    background: #46a6ff;
    border-color: #46a6ff;
    color: #FFFFFF;
  }

	.file-name {
		margin-left: 10px;
		padding: 7px;
		border-radius: 5px;
	}

	.file-name:hover {
		background: rgb(241, 243, 245);
		cursor: pointer;

		.remove {
			display: inline;
			margin-left: 50px;
			background:rgb(109, 102, 102);
			color: white;
			border-radius: 100%;
			padding: 0px 4px 1px 4px;
		}
	}

	.remove {
		display: none;
	}

</style>
