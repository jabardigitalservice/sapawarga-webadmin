<template>
  <div class="app-container">
    <p class="warn-content">Detail Pengguna</p>
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="7" :xl="7">
        <div style="padding: 0 50px">
          <PhotoBox class="image" :image="imageUrl" />
        </div>
        <div v-if="latitude">
          <p class="warn-content map-title">Lokasi Anda</p>
          <MapThumb v-if="latitude && longitude" :latitude="latitude" :longitude="longitude" />
        </div>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="17" :xl="17">
        <el-table stripe :data="tableData" :show-header="false" border style="width: 100%">
          <el-table-column prop="title" width="180" />
          <el-table-column prop="content" />
        </el-table>
        <div class="social-media">
          <p class="warn-content">Media Sosial</p>
          <el-table stripe :data="twitterIcon" :show-header="false" border style="width: 100%">
            <el-table-column width="180">
              <a :href="`https://twitter.com/${twitterAccount}`" target="_blank">
                <img class="social-media-admin twitter" :src="twitter" align="middle">
              </a>
            </el-table-column>
            <el-table-column prop="content" />
          </el-table>
          <el-table stripe :data="instagramIcon" :show-header="false" border style="width: 100%">
            <el-table-column width="180">
              <a :href="`https://www.instagram.com/${instagramAccount}`" target="_blank">
                <img class="social-media-admin twitter" :src="instagram">
              </a>
            </el-table-column>
            <el-table-column prop="content" />
          </el-table>
          <el-table stripe :data="facebookIcon" :show-header="false" border style="width: 100%">
            <el-table-column width="180">
              <a :href="`${facebookAccount}`" target="_blank">
                <img class="social-media-admin twitter" :src="facebook">
              </a>
            </el-table-column>
            <el-table-column prop="content" />
          </el-table>
        </div>
        <div v-permission="['admin','staffProv']" class="informasi-tambahan">
          <p class="warn-content">Informasi Tambahan</p>
          <el-table stripe :data="tableDataTambahan" :show-header="false" border style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import PhotoBox from '@/components/PhotoBox'
import MapThumb from '@/components/MapThumb'
import { fetchUser } from '@/api/staff'
import permission from '@/directive/permission/index.js'
import checkPermission from '@/utils/permission'
import parsingDatetime from '@/utils/datetimeToString'

export default {
  components: { PhotoBox, MapThumb },
  directives: { permission },
  data() {
    return {
      id: 0,
      imageUrl: null,
      height: '220px',
      tableData: [],
      tableDataTambahan: [],
      instagramIcon: [],
      twitterIcon: [],
      facebookIcon: [],
      urlMap: null,
      latitude: null,
      longitude: null,
      twitter: require('@/assets/twitter.svg'),
      facebook: require('@/assets/facebook.svg'),
      instagram: require('@/assets/instagram.svg'),
      twitterAccount: null,
      facebookAccount: null,
      instagramAccount: null
    }
  },

  created() {
    const id = this.$route.params && this.$route.params.id
    this.getDetail(id)
  },

  methods: {
    checkPermission,
    getDetail(id) {
      fetchUser(id).then(response => {
        const {
          name,
          address,
          kabkota,
          kecamatan,
          kelurahan,
          phone,
          lat,
          lon,
          photo_url,
          email,
          facebook,
          instagram,
          rt,
          rw,
          twitter,
          username,
          created_at,
          updated_at,
          last_login_at,
          role_label
        } = response.data
        this.twitterAccount = twitter || '-'
        this.facebookAccount = facebook || '-'
        this.instagramAccount = instagram || '-'
        this.imageUrl = photo_url !== null ? photo_url : null
        this.latitude = lat
        this.longitude = lon
        this.instagramIcon = [
          {
            content: instagram || '-'
          }
        ]
        this.twitterIcon = [
          {
            content: twitter || '-'
          }
        ]
        this.facebookIcon = [
          {
            content: facebook || '-'
          }
        ]
        this.tableData = [
          {
            title: 'Nama',
            content: name || '-'
          },
          {
            title: 'Username',
            content: username || '-'
          },
          {
            title: 'Email',
            content: email || '-'
          },
          {
            title: 'Telepon',
            content: phone || '-'
          },
          {
            title: 'Alamat Instansi',
            content: address || '-'
          },
          {
            title: 'RT',
            content: rt || '-'
          },
          {
            title: 'RW',
            content: rw || '-'
          },
          {
            title: 'Kelurahan',
            content: (kelurahan ? kelurahan.name : '-')
          },
          {
            title: 'Kecamatan',
            content: (kecamatan ? kecamatan.name : '-')
          },
          {
            title: 'Kab/Kota',
            content: (kabkota ? kabkota.name : '-')
          },
          {
            title: 'Peran',
            content: role_label || '-'
          }
        ]
        this.tableDataTambahan = [
          {
            title: 'Tanggal Dibuat',
            content: created_at ? parsingDatetime(created_at) : '-'
          },
          {
            title: 'Tanggal Diperbarui',
            content: updated_at ? parsingDatetime(updated_at) : '-'
          },
          {
            title: 'Terakhir Login',
            content: last_login_at ? parsingDatetime(last_login_at) : 'Belum Pernah'
          }
        ]
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.map-title {
  width: 400px;
  margin-left: 20px;
  margin-bottom: 10px;
  margin-top: 50px;
  padding: 10px;
}

.social-media-admin {
  width: 30px;
  height: 30px;
  display: block;
  margin-left: 40%;
}

.social-media-card {
  margin-top: 30px;
}

@media only screen and (max-width: 1200px) {
  .col-right {
    margin-top: 30px;
    margin-left: 20px;
    padding-right: 30px !important;
  }

}

@media only screen and (min-width: 1200px) and (max-width: 1570px) {
  .gmap_canvas {
    background: none !important;
    width: 250px;
    height: 230px;
    margin-left: 20px;
    border-radius: 5px;
    margin-top: 20px;
    -webkit-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    iframe {
      width: 250px;
      height: 230px;
    }
  }

  .map-title {
    width: 250px;
    margin-left: 20px;
    margin-bottom: 10px;
    margin-top: 50px;
    padding: 10px;
  }
}
</style>
