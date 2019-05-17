<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="10" :xl="10">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Target</span>
          </div>
          <el-table stripe :data="tableDataTarget" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="14" :xl="14">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Isi Pesan</span>
          </div>
          <el-table stripe :data="tableDataPesan" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
          <el-button type="primary" :disabled="btnKirimDisable">{{ btnKirimLabel }}</el-button>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord } from '@/api/broadcast'

export default {
  data() {
    return {
      id: 0,
      tableDataTarget: [],
      tableDataPesan: [],
      btnKirimLabel: '',
      btnKirimDisable: false
    }
  },

  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },

  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { title, description, category, kabkota, kecamatan, kelurahan, rw, status, status_label } = response.data
        // const textPhoneMsg = phone_numbers.map(e => e.type + ': ' + e.phone_number).join(', ')
        // const wilayah = [kabkota, kecamatan, kelurahan].filter(e => e.name !== null).map(e => e.name).join(', ')
        if (status === 10) {
          this.btnKirimLabel = status_label
          this.btnKirimDisable = true
        } else if (status === 0) {
          this.btnKirimLabel = 'Kirim'
          this.btnKirimDisable = false
        }

        this.tableDataTarget = [
          {
            title: 'Kota',
            content: ' : ' + ((kabkota !== null) ? kabkota.name : '-')
          },
          {
            title: 'Kecamatan',
            content: ' : ' + ((kecamatan !== null) ? kecamatan.name : '-')
          },
          {
            title: 'Kelurahan/Desa',
            content: ' : ' + ((kelurahan !== null) ? kelurahan.name : '-')
          },
          {
            title: 'RW',
            content: ' : ' + ((rw !== null) ? rw : '-')
          }
        ]

        this.tableDataPesan = [
          {
            title: 'Judul Pesan',
            content: ': ' + (title !== null ? title : '-')
          },
          {
            title: 'Kategori',
            content: ': ' + (category !== null ? category.name : '-')
          },
          {
            title: 'Isi Pesan',
            content: ': ' + (description !== null ? description : '-')
          }
        ]
      })
    }
  }
}
</script>

<style lang="scss">
#map iframe {
  width: 400px;
  height: 350px;
  margin-left: 20px;
  border-radius: 5px;
  margin-top: 30px;
  -webkit-box-shadow: 0px 0px 25px -10px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 25px -10px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 25px -10px rgba(0,0,0,0.75);
}

.button-send {
  margin-top: 30px;
  display: block;
}

@media only screen and (max-width: 1200px) {
  .col-right {
    margin-top: 30px;
    margin-left: 20px;
    margin-right: 20px !important
  }
}

@media only screen and (min-width: 1200px) and (max-width: 1570px) {
  #map iframe {
    width: 250px;
    height: 200px;
    border-radius: 5px;
    margin-left: 20px;
    -webkit-box-shadow: 0px 0px 25px -10px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 25px -10px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 25px -10px rgba(0,0,0,0.75);
  }
}
</style>
