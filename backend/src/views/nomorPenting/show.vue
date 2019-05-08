<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col :sm="24" :lg="8" :xl="6">
        <PhotoBox :image="imageUrl" :height="height" />
        <!-- ini sample asli iframe <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.280178877438!2d108.20895931416229!3d-7.322392994715478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMTknMjAuNiJTIDEwOMKwMTInNDAuMSJF!5e0!3m2!1sen!2sid!4v1557246825382!5m2!1sen!2sid" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> -->
        <!-- <iframe :src="urlMap" width="400" height="400" frameborder="0" style="border:0" allowfullscreen></iframe> -->
        <vue-friendly-iframe :src="urlMap" @load="onLoad" @document-load="onDocumentLoad" :style="{'border':0}"></vue-friendly-iframe>
      </el-col>
      <el-col :sm="24" :lg="16" :xl="18">
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
// TODO: make table dynamic from API
import PhotoBox from '@/components/PhotoBox'
import { fetchDetail } from '@/api/phonebooks'

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
    const id = this.$route.params && this.$route.params.id
    this.id = id
    this.getDetail();
  },

  methods: {
    getDetail() {
      fetchDetail(this.id).then(response => {
        const { name, address, description, category, seq, kabkota_id, kec_id, kel_id, phone_numbers, latitude, longitude, cover_image_path } = response.data

        this.imageUrl = cover_image_path !== null ? cover_image_path : require('@/assets/user.png')
        this.latitude = latitude
        this.longitude = longitude
        this.urlMap = `https://maps.google.com/maps?q=${latitude},${longitude}&hl=es;z=14&amp;output=embed`
        this.tableData = [
          {
            title: 'Nama Instansi',
            content: ': ' + name
          },
          {
            title: 'Alamat Instansi',
            content: ': ' + address
          },
          {
            title: 'Kategori Instansi',
            content: ': ' + category.name
          },
          {
            title: 'Deskripsi',
            content: ': ' + description
          },
          {
            title: 'Call Center',
            content: ': ' + (seq === 1000 ? 'Ya' : 'Tidak')
          },
          {
            title: 'Wilayah',
            content: ': ' + kabkota_id
          },
          {
            title: 'Nomor Telepon',
            content: ': ' + response.data.name
          },
          {
            title: 'Koordinat Lokasi',
            content: `: Latitude ${latitude}, Longitude ${longitude}`
          }
        ]
        console.log(response.data)
      })
    }
  }
}
</script>

<style>
iframe {
      height: 400px;
      width: 375px;
  }
</style>
