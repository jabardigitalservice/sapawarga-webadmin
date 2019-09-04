<template>
  <el-card class="box-card">
    <div class="text item">
      <el-row :gutter="8">
        <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 16}" :xl="{span: 16}" style="padding-right:8px;margin-bottom:30px;">
          <div id="gmaps" :class="['gmap_canvas', classObj]" />
        </el-col>
        <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 8}" :xl="{span: 8}" style="margin-bottom:30px;">
          <el-table id="table-geo" :data="list" height="350" stripe style="width: 100%; margin-left:10px;">
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
        </el-col>
      </el-row>
    </div>
  </el-card>
</template>

<script>
import { fetchAspirasiMap } from '@/api/dashboard'
import gmapsInit from '@/utils/gmaps'
import { mapGetters } from 'vuex'

export default {
  data() {
    return {
      list: null,
      map: null,
      activeInfoWindow: null,
      labelTitle: 'Kota/Kabupaten',
      jawaBarat: {
        lat: -6.943097,
        lon: 107.633545
      },
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
    ...mapGetters([
      'sidebar'
    ]),
    classObj() {
      return {
        openSidebar: this.sidebar.opened
      }
    }
  },

  created() {
    this.getMap()
  },
  methods: {
    getMap() {
      fetchAspirasiMap(this.listQuery).then(response => {
        this.list = response.data
        this.createMap(this.list)
      })
    },
    async createMap(dataMap) {
      try {
        const google = await gmapsInit()
        const element = document.getElementById('gmaps')
        const options = {
          zoom: 8,
          center: new google.maps.LatLng(this.jawaBarat.lat, this.jawaBarat.lon)
        }
        this.map = new google.maps.Map(element, options)

        // Create LatLngBounds object.
        const latlngbounds = new google.maps.LatLngBounds()

        dataMap.forEach((coord) => {
          if (coord.latitude && coord.longitude) {
            const position = new google.maps.LatLng(coord.latitude, coord.longitude)
            const marker = new google.maps.Marker({
              position: position,
              map: this.map
            })

            const infoWindow = new google.maps.InfoWindow({
              content: `<div>${coord.name}</div><br>
                      <div style="text-align: center">${coord.counts} Usulan</div>`
            })

            marker.addListener('mouseover', () => {
              if (this.activeInfoWindow) {
                this.activeInfoWindow.close()
              }
              infoWindow.open(this.map, marker)
              this.activeInfoWindow = infoWindow
            })

            marker.addListener('click', () => {
              if (this.isChecked.kel) {
                return
              }

              this.checkLevel(coord.id)

              this.getMap()

              if (this.activeInfoWindow) {
                this.activeInfoWindow.close()
              }
              infoWindow.open(this.map, marker)
              this.activeInfoWindow = infoWindow
            })

            latlngbounds.extend(position)
          }
        })
        this.map.fitBounds(latlngbounds)
        this.map.panToBounds(latlngbounds)
      } catch (error) {
        console.error(error)
        this.$message.error(this.$t('dashboard-map-error'))
      }
    },
    checkLevel(id) {
      if (this.isChecked.kabkota) {
        this.listQuery.kabkota_id = id

        // change label
        this.labelTitle = 'Kecamatan'

        // isCheck
        this.isChecked = { kabkota: false, kec: true }
      } else if (this.isChecked.kec) {
        this.listQuery.kec_id = id

        // change label
        this.labelTitle = 'Kelurahan'

        // isCheck
        this.isChecked = { kec: false, kel: true }
      } else if (this.isChecked.kel) {
        this.listQuery.kel_id = id
      }
    },
    viewMarker(id) {
      if (this.isChecked.kel) {
        return
      }
      this.checkLevel(id)
      this.getMap()
    },
    resetLevel() {
      if (this.isChecked.kabkota) {
        return
      }

      this.labelTitle = 'Kota/Kabupaten'
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

      this.getMap()
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

  .gmap_canvas {
    background: none !important;
    width: 750px !important;
    height: 400px;
    margin-left: 0px;
    border-radius: 5px;
    margin-top: 0px;
  }

  #table-geo {
    cursor: pointer !important;
  }

  #gmaps {
    width: 700px;
  }

  .btn-reset {
    right: 0;
    position: absolute;
    margin-top: 15px;
  }

  .openSidebar {
    width: 650px !important;
  }

  @media only screen and (min-width: 992px) and (max-width: 1200px) {
    .gmap_canvas {
      width: 885px !important;
    }
  }

  @media only screen and (min-width: 768px) and (max-width: 992px) {
    .gmap_canvas {
      width: 660px !important;
    }
  }

</style>
