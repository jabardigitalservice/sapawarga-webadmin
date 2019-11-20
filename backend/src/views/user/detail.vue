<template>
  <div class="app-container">
    <p class="warn-content">{{ $t('route.user-detail') }}</p>
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="7" :xl="7">
        <div style="padding: 0 50px">
          <PhotoBox class="image" :image="imageUrl" />
        </div>
        <div v-if="latitude">
          <p class="warn-content map-title">{{ $t('label.your-location') }}</p>
          <MapThumb v-if="latitude && longitude" :latitude="latitude" :longitude="longitude" />
        </div>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="17" :xl="17">
        <div class="profile">
          <p class="warn-content">{{ $t('route.profile') }}</p>
          <el-table stripe :data="tableProfile" :show-header="false" border style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </div>

        <div class="contact">
          <p class="warn-content">{{ $t('label.contact') }}</p>
          <el-table stripe :data="tableContact" :show-header="false" border style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </div>

        <div class="address">
          <p class="warn-content">{{ $t('label.address') }}</p>
          <el-table stripe :data="tableAddress" :show-header="false" border style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </div>

        <div class="social-media">
          <p class="warn-content">{{ $t('label.social-media') }}</p>
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
          <p class="warn-content">{{ $t('label.more-information') }}</p>
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
import { parsingDatetime, formatDatetime } from '@/utils/datetimeToString'
import { isUserKabKota } from '@/utils/permission'

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
      tableProfile: [],
      tableAddress: [],
      tableContact: [],
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
          profile_updated_at,
          last_login_at,
          last_access_at,
          job_type,
          birth_date,
          education_level,
          role_id,
          role_label
        } = response.data
        isUserKabKota(kabkota ? kabkota.id : null, role_id)
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
        this.tableProfile = [
          {
            title: this.$t('label.name'),
            content: name || '-'
          },
          {
            title: this.$t('label.birthdate'),
            content: (birth_date ? formatDatetime(birth_date, 'DD MMMM YYYY') : '-')
          },
          {
            title: this.$t('label.education'),
            content: (education_level ? education_level.title : '-')
          },
          {
            title: this.$t('label.job'),
            content: (job_type ? job_type.title : '-')
          },
          {
            title: this.$t('label.role'),
            content: role_label || '-'
          },
          {
            title: this.$t('label.username'),
            content: username || '-'
          }
        ]
        this.tableContact = [
          {
            title: this.$t('label.email'),
            content: email || '-'
          },
          {
            title: this.$t('label.telepon'),
            content: phone || '-'
          }
        ]
        this.tableAddress = [
          {
            title: this.$t('label.address'),
            content: address || '-'
          },
          {
            title: this.$t('label.area-kabkota'),
            content: (kabkota ? kabkota.name : '-')
          },
          {
            title: this.$t('label.area-kec'),
            content: (kecamatan ? kecamatan.name : '-')
          },
          {
            title: this.$t('label.area-kel'),
            content: (kelurahan ? kelurahan.name : '-')
          },
          {
            title: this.$t('label.area-rt'),
            content: rt || '-'
          },
          {
            title: this.$t('label.area-rw'),
            content: rw || '-'
          }
        ]
        this.tableDataTambahan = [
          {
            title: this.$t('label.created-at'),
            content: created_at ? parsingDatetime(created_at) : '-'
          },
          {
            title: this.$t('label.profile-updated-at'),
            content: profile_updated_at ? parsingDatetime(profile_updated_at) : '-'
          },
          {
            title: this.$t('label.last-login-at'),
            content: last_login_at ? parsingDatetime(last_login_at) : 'Belum Pernah'
          },
          {
            title: this.$t('label.last-access-at'),
            content: last_access_at ? parsingDatetime(last_access_at) : '-'
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
