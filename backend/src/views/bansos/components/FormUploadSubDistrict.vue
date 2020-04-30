<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <span class="head-title">
          <b>{{ $t('label.area-kec') }}</b>
        </span>
      </el-col>
    </el-row>
    <br>

    <el-row :gutter="40">
      <el-col :span="12">
        <el-select
          v-model="kecamatan_selected"
          filterable
          clearable
          placeholder="Semua Kecamatan"
          name="kecamatan"
          style="width: 100%"
          @change="changeKecamatan($event)"
        >
          <el-option
            v-for="item in kecamatan_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>
      <el-col :span="12">
        <el-upload
          drag
          :multiple="false"
          :limit="1"
          action=""
          :auto-upload="false"
          :on-change="handleChangeFile"
        >
          <div class="el-upload__text"><i class="el-icon-upload" /><em> Add File </em>or drop files here</div>
        </el-upload>
      </el-col>
    </el-row>
    <el-row :gutter="40">
      <el-col :span="24" style="text-align:right">
        <el-button type="primary" @click="submitUpload">Upload<i class="el-icon-upload el-icon-right"></i></el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { uploadBansos } from '@/api/bansos'
import { mapGetters } from 'vuex'
import Swal from 'sweetalert2'
import { getKecamatanList } from '@/api/areas'

export default {
  name: 'FormUploadSubDistrict',
  data() {
    return {
      kecId: null,
      file: null,
      kecamatan_selected: null,
      kecamatan_options: [],
    }
  },
  computed: {
    ...mapGetters([
      'user'
    ])
  },
  created() {
    this.getKecamatan()
  },
  methods: {
    async getKecamatan() {
      this.kecamatan_options = []
      const { data } = await getKecamatanList(this.user.kabkota_id, true)
      this.kecamatan_options = data.items.map(item => {
        return {
          value: item.id,
          label: item.name
        }
      })
    },
    async submitUpload() {
      try{
        const formData = new FormData();
        formData.append('type', this.$route.query.type);
        formData.append('kabkota_id', this.user.kabkota_id);
        formData.append('kec_id', this.kecId);
        formData.append('file', this.file);
        
        await uploadBansos(formData)

        Swal.fire({
          text: 'Dokumen berhasil dikirim',
          icon: "success",
          button: "OK",
        }).then((action) => {
          if (action) {
            this.$router.push('/bansos/upload')
          } 
        })

      } catch (err) {
        console.log(err)
        return err;
      }
    },
    handleChangeFile(file) {
      this.file = file.raw
    },
    changeKecamatan(value) {
      this.kecId = value
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
