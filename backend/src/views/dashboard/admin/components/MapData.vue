<template>
  <el-card class="box-card">
    <div class="text item">
      <el-row :gutter="8">
        <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 16}" :xl="{span: 16}" style="padding-right:8px;margin-bottom:30px;">
          <div id="gmaps" class="gmap_canvas" />
        </el-col>
        <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 8}" :xl="{span: 8}" style="margin-bottom:30px;">
          <el-table :data="list" stripe style="width: 100%; margin-left:10px">
            <el-table-column prop="name" label="Kota/Kabupaten" align="left" min-width="200" />
            <el-table-column prop="counts" label="Usulan" align="center" min-width="100" />
          </el-table>
        </el-col>
      </el-row>
    </div>
  </el-card>
</template>

<script>
import { fetchAspirasiMap } from '@/api/dashboard'
import gmapsInit from '@/utils/gmaps'
export default {
  data() {
    return {
      list: null,
      map: null,
      activeInfoWindow: null,
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
          zoom: this.zoom,
          center: this.markerCenter ? this.markerCenter : new google.maps.LatLng(this.jawaBarat.lat, this.jawaBarat.lon)
        }
        this.map = new google.maps.Map(element, options)

        dataMap.forEach((coord) => {
          const position = new google.maps.LatLng(coord.latitude, coord.longitude)
          const marker = new google.maps.Marker({
            position: position,
            map: this.map
          })

          const infoWindow = new google.maps.InfoWindow({
            content: `<div>${coord.name}</div><br>
                    <div style="text-align: center">${coord.counts} Usulan</div>`
          })

          marker.addListener('click', () => {
            if (this.isChecked.kel) {
              console.log(this.isChecked.kel)
              return
            }

            this.checkLevel(coord.id)

            this.getMap()

            console.log(position)
            this.map.setZoom(this.zoom)

            this.markerCenter = marker.getPosition()
            // this.map.setCenter(marker.getPosition())
            if (this.activeInfoWindow) {
              this.activeInfoWindow.close()
            }
            infoWindow.open(this.map, marker)
            this.activeInfoWindow = infoWindow
          })
        })
      } catch (error) {
        console.error(error)
        this.$message.error(this.$t('dashboard-map-error'))
      }
    },
    checkLevel(id) {
      if (this.isChecked.kabkota) {
        this.listQuery.kabkota_id = id

        this.zoom = 10

        // isCheck
        this.isChecked = { kabkota: false, kec: true }
      } else if (this.isChecked.kec) {
        this.listQuery.kec_id = id

        this.zoom = 12

        // isCheck
        this.isChecked = { kec: false, kel: true }
      } else if (this.isChecked.kel) {
        this.listQuery.kel_id = id
        this.zoom = 13
      }
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
    width: 700px;
    height: 400px;
    margin-left: 0px;
    border-radius: 5px;
    margin-top: 0px;

    iframe {
      width: 640px;
      height: 400px;
    }
  }

  #gmaps {
    width: 700px;
  }

  .map-title {
    width: 400px;
    margin-left: 20px;
    margin-bottom: 10px;
    margin-top: 50px;
    padding: 10px;
  }

  @media only screen and (min-width: 1200px) and (max-width: 1570px) {
    .gmap_canvas {
      background: none !important;
      width: 640px;
      height: 400px;
      margin-left: 0px;
      border-radius: 5px;
      margin-top: 0px;

      iframe {
        width: 640px;
        height: 400px;
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

   @media only screen and (max-width: 610px)  {
    #gmaps {
      width: 450px;
    }
   }

</style>
