<template>
  <div class="mt-16">
    <el-row :gutter="24">
      <el-col v-for="item in items" :key="item.id" :xs="24" :sm="24" :md="24" :lg="24" :xl="24" :class="{'section-body': id === item.id}" class="mb-16">
        <div class="title-explanation">{{ item.title }}</div>
        <div class="desc-explanation">{{ item.description }}</div>
      </el-col>
    </el-row>
    <div class="btn-explanation">
      <el-button plain @click="closeDialog()">Tutup</el-button>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      items: [
        {
          id: 1,
          title: 'Total Usulan:',
          description: 'Seluruh data yang ada di dalam aplikasi Sapawarga diantaranya data Usulan Terverifikasi, Belum Terverifikasi, dan Ditolak.'
        },
        {
          id: 2,
          title: 'Usulan Terverifikasi:',
          description: 'Data yang telah memenuhi syarat dan ketentuan sehingga dapat diajukan sebagai calon penerima bansos, Usulan Baru termasuk di dalam data ini. Data ini tidak sama dengan data BNBA penerima bansos, karena masih harus melewati pemadanan dan penyaringan administrasi.'
        },
        {
          id: 3,
          title: 'Usulan Belum Terverifikasi:',
          description: 'Data usulan manual pada tahap sebelumnya yang dianggap belum sesuai dengan syarat dan ketentuan standar data, sehingga perlu melalui proses verifikasi.'
        },
        {
          id: 4,
          title: 'Usulan Ditolak:',
          description: 'Data yang dianggap tidak memenuhi syarat dan ketentuan berdasarkan keterangan RW atau Pemerintah Desa.'
        },
        {
          id: 5,
          title: 'Usulan Baru:',
          description: 'Data Usulan Baru via Sapawarga yang telah memenuhi syarat dan ketentuan sehingga dapat diajukan sebagai calon penerima bansos, data ini merupakan bagian dari Usulan Terverifikasi. Data ini tidak sama dengan data BNBA penerima bansos, karena masih harus melewati pemadanan dan penyaringan administrasi.'
        },
        {
          id: 6,
          title: 'Disetujui Oleh:',
          description: 'Data usulan baru via Sapawarga yang diimport melalui Desa/Kelurahan, Kecamatan, dan Kabupaten/Kota, yang memenuhi syarat administrasi sehingga dapat didaftarkan sebagai calon penerima bansos provinsi (Usulan Terdaftar).'
        }
      ]
    }
  },
  methods: {
    closeDialog() {
      this.$emit('close')
    }
  }
}
</script>

<style lang="scss">
.dialog-explanation > .el-dialog__body {
  padding-top: 0px;
}
.mt-16 {
  margin-top: 16px;
}
.mb-16 {
  margin-bottom: 16px;
}
.section-body {
  padding: 10px;
  background: rgba(39, 174, 96, 0.1);
  border-radius: 8px;
}
.title-explanation {
  font-weight: bold;
  margin-bottom: 5px;
  color: #000000;
}
.desc-explanation {
  line-height: 150%;
}
.btn-explanation {
  text-align: center;
  margin-top: 32px;
}
</style>
