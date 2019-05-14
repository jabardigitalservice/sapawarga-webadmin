<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="7" :xl="5">
        <PhotoBox class="image" :image="imageUrl" :height="height" />
        <vue-friendly-iframe v-show="latitude && longitude !== null" id="map" :src="`https://maps.google.com/maps?q=${latitude},${longitude}&hl=es;z=14&amp;output=embed`" :style="{'border':0}" />
      </el-col>
      <el-col class="col-right" :xs="23" :sm="23" :md="23" :lg="16" :xl="18">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Nomor Telepon</span>
          </div>
          <el-table :data="tableData" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import PhotoBox from '@/components/PhotoBox'
import { fetchRecord } from '@/api/phonebooks'

export default {
  components: { PhotoBox },
  data() {
    return {
      id: 0,
      imageUrl: null,
      height: '220px',
      tableData: [],
      urlMap: null,
      latitude: null,
      longitude: null
    }
  },

  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },

  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { name, address, description, category, seq, kabkota, kecamatan, kelurahan, phone_numbers, latitude, longitude, cover_image_path
        } = response.data

        this.imageUrl = ((cover_image_path !== null) ? cover_image_path : null)
        this.latitude = latitude
        this.longitude = longitude
        const textPhoneMsg = phone_numbers.map(e => e.type + ': ' + e.phone_number).join(', ')
        const wilayah = [kabkota, kecamatan, kelurahan].filter(e => e.name !== null).map(e => e.name).join(', ')
        this.tableData = [
          {
            title: 'Nama Instansi',
            content: ': ' + (name !== null ? name : '-')
          },
          {
            title: 'Alamat Instansi',
            content: ': ' + (address !== null ? address : '-')
          },
          {
            title: 'Kategori Instansi',
            content: ': ' + (category !== null ? category.name : '-')
          },
          {
            title: 'Deskripsi',
            content: ': ' + (description !== null ? description : '-')
          },
          {
            title: 'Call Center',
            content: ': ' + (seq === 1000 ? 'Ya' : 'Tidak') || '-'
          },
          {
            title: 'Wilayah',
            content: ': ' + (wilayah !== null ? wilayah : '-')
          },
          {
            title: 'Nomor Telepon',
            content: ': ' + (textPhoneMsg !== null ? textPhoneMsg : '-')
          },
          {
            title: 'Koordinat Lokasi',
            content: ': ' + ((latitude && longitude !== null) ? `Latitude ${latitude}, Longitude ${longitude}` : '-')
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
