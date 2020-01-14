<template>
  <el-row class="aspiration-maps" :gutter="8">
    <el-col :md="24" :lg="14" :xl="14" style="padding-right:8px;margin-bottom:30px;">
      <div id="leafletmap" :class="['leaflet_canvas', classObj]" />
    </el-col>
    <el-col :md="24" :lg="10" :xl="10" style="margin-bottom:30px;">
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <div class="header-aspiration">
            <span class="title">{{ $t('label.total-aspiration') }}</span>
            <span>:</span>
            <span class="total-aspiration">{{ totalAspiration }}</span>
          </div>
          <div class="header-aspiration">
            <span class="title">{{ $t('label.publish-aspiration') }}</span>
            <span>:</span>
            <span class="total-aspiration">{{ totalPublishedAspiration }}</span>
          </div>
        </div>
        <el-table id="table-geo" :data="list" height="250" stripe style="width: 100%; margin-left:10px;">
          <el-table-column prop="name" fixed :label="labelTitle" align="left" min-width="200" style="cursor:pointer">
            <template slot-scope="scope">
              <div @click="viewMarker(scope.row.id)">{{ scope.row.name }}</div>
            </template>
          </el-table-column>
          <el-table-column prop="counts" label="Usulan" align="center" min-width="100">
            <template slot-scope="scope">
              <div @click="viewMarker(scope.row.id)">{{ scope.row.counts }}</div>
            </template>
          </el-table-column>
        </el-table>
        <el-button class="btn-reset" type="danger" @click="resetLevel">Reset</el-button>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
import { fetchAspirasiMap, fetchAspirasiCounts } from '@/api/dashboard'
import { mapGetters } from 'vuex'
import leaflet from 'leaflet'

export default {
  name: 'MapAspiration',
  data() {
    return {
      list: null,
      map: null,
      activeInfoWindow: null,
      totalAspiration: 0,
      totalPublishedAspiration: 0,
      labelTitle: 'Kota/Kabupaten',
      zoom: 8,
      markerCenter: null,
      isChecked: {
        kabkota: true,
        kec: false,
        kel: false
      },
      listQuery: {
        kabkota_id: null,
        kec_id: null,
        kel_id: null
      }
    }
  },

  computed: {
    ...mapGetters(['sidebar', 'user']),
    classObj() {
      return {
        openSidebar: this.sidebar.opened
      }
    }
  },

  async mounted() {
    if (this.user.kabkota_id) {
      this.listQuery.kabkota_id = this.user.kabkota_id
      this.labelTitle = this.$t('label.area-kec')
      this.isChecked = { kabkota: false, kec: true }
    }

    this.getAspirasiCounts()
    this.getAPIData()
  },

  methods: {
    getAPIData() {
      fetchAspirasiMap(this.listQuery).then(response => {
        this.list = response.data
        const validData = this.list.filter(
          data => data.latitude !== null && data.longitude !== null
        )
        this.initMap(validData)
      })
    },
    async getAspirasiCounts() {
      this.listLoading = true
      const response = await fetchAspirasiCounts()
      if (response.data) {
        this.totalAspiration = parseInt(response.data.STATUS_APPROVAL_PENDING) + parseInt(response.data.STATUS_APPROVAL_REJECTED) + parseInt(response.data.STATUS_PUBLISHED) + parseInt(response.data.STATUS_UNPUBLISHED)
        this.totalPublishedAspiration = parseInt(response.data.STATUS_PUBLISHED)
      }
    },
    initMap(dataMap) {
      try {
        this.map = leaflet
          .map('leafletmap')
          .setView([dataMap[0].latitude, dataMap[0].longitude], this.zoom)
        this.tileLayer = leaflet.tileLayer(
          'https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png',
          {
            maxZoom: 18,
            attribution:
              '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>'
          }
        )
        this.tileLayer.width = 1500
        this.tileLayer.addTo(this.map)
        this.initMarkers(dataMap)
      } catch (error) {
        this.$message.error(this.$t('errors.map-load-error'))
      }
    },
    initMarkers(dataMap) {
      const coordinates = []
      dataMap.forEach(feature => {
        feature.leafletObject = leaflet
          .marker([feature.latitude, feature.longitude])
          .bindTooltip(`${feature.name} : ${feature.counts} Usulan`)
          .on('click', () => {
            this.checkLevel(feature.id)
          })
          .addTo(this.map)
        coordinates.push([feature.latitude, feature.longitude])
      })
      this.map.fitBounds(coordinates)
    },
    checkLevel(id) {
      if (this.isChecked.kabkota) {
        this.listQuery.kabkota_id = id

        // change label
        this.labelTitle = this.$t('label.area-kec')

        // isCheck
        this.isChecked = { kabkota: false, kec: true }
      } else if (this.isChecked.kec) {
        this.listQuery.kec_id = id

        // change label
        this.labelTitle = this.$t('label.area-kel')

        // isCheck
        this.isChecked = { kec: false, kel: true }
      } else if (this.isChecked.kel) {
        this.listQuery.kel_id = id
      }
      this.reinitMap()
    },
    viewMarker(id) {
      if (this.isChecked.kel) {
        return
      }
      this.checkLevel(id)
    },
    resetLevel() {
      if (this.user.kabkota_id) {
        this.labelTitle = this.$t('label.area-kec')
        this.isChecked = {
          kabkota: false,
          kec: true,
          kel: false
        }

        this.listQuery = {
          kabkota_id: this.user.kabkota_id,
          kec_id: null,
          kel_id: null
        }

        this.reinitMap()
      } else {
        if (this.isChecked.kabkota) {
          return
        }

        this.labelTitle = this.$t('label.area-kabkota')
        this.isChecked = {
          kabkota: true,
          kec: false,
          kel: false
        }

        this.listQuery = {
          kabkota_id: null,
          kec_id: null,
          kel_id: null
        }

        this.reinitMap()
      }
    },
    reinitMap() {
      this.map.off()
      this.map.remove()
      this.getAPIData()
    }
  }
}
</script>

<style lang="scss" scoped>
.text {
  font-size: 14px;
}

.item {
  padding: 0px 0;
}

.box-card {
  width: 100%;
  height: 440px;
}

.header-aspiration {
  padding: 4px 0px;
  .title {
    font-size: 15px;
  }
  .total-aspiration {
    float:right;
    color:#52797e;
    font-size: 15px;
    font-weight: bold;
  }
}

#leafletmap {
  background: none !important;
  width: 100%;
  height: 440px;
  margin-left: 0px;
  border-radius: 5px;
  margin-top: 0px;
}

#table-geo {
  cursor: pointer !important;
}

.btn-reset {
  right: 0;
  position: absolute;
  margin-top: 9px;
  margin-right: 12px;
}

@media only screen and (max-width: 992px) {
  #leafletmap {
    width: 100%;
    height: 330px;
  }
  .box-card {
    width: 100%;
    height: 380px;
  }
  .btn-reset {
    margin-top: 25px;
    margin-right: 12px;
  }
}
</style>
