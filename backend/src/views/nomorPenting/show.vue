<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="7" :xl="7">
        <PhotoBox class="image" :image="imageUrl" />
        <MapThumb v-if="latitude && longitude" :latitude="latitude" :longitude="longitude" />
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="17" :xl="17">
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
import MapThumb from '@/components/MapThumb'
import { fetchRecord } from '@/api/phonebooks'

export default {
  components: { PhotoBox, MapThumb },
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

  mounted() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },

  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { name, address, description, category, seq, kabkota, kecamatan, kelurahan, phone_numbers, latitude, longitude, cover_image_path, cover_image_url
        } = response.data

        this.imageUrl = ((cover_image_path !== null) ? cover_image_url : null)
        this.latitude = latitude
        this.longitude = longitude
        const textPhoneMsg = (phone_numbers) ? phone_numbers.map(e => e.type + ': ' + e.phone_number).join(', ') : '-'
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
@media only screen and (max-width: 1200px) {
  .col-right {
    margin-top: 30px;
    margin-left: 20px;
    margin-right: 20px !important
  }
}
</style>
