<template>
  <el-card class="box-card">
    <div class="text item">
      <el-row :gutter="8">
        <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 16}" :xl="{span: 16}" style="padding-right:8px;margin-bottom:30px;">
            <div class="gmap_canvas" id="gmaps">
          </div>
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
    async mounted() {
    try {
      const google = await gmapsInit()
      const element = document.getElementById('gmaps')
      const options = {
      zoom: 8,
      center: new google.maps.LatLng(-6.943097,107.633545)
    }
      this.map = new google.maps.Map(element, options)
      
    } catch (error) {
      console.error(error);
      this.$message.error(this.$t('dashboard-map-error'))
    }
  },
  data() {
    return {
      list: null,
      map: null,
      activeInfoWindow: null
    }
  },
  created() {
    this.getMap()
  },
  methods: {
    getMap() {
      fetchAspirasiMap().then(response => {
        this.list = response.data.items
        this.createMarker()
      })
    },
    createMarker() {
      this.list.forEach((coord) => {
        const position = new google.maps.LatLng(coord.longitude, coord.latitude)
          const marker = new google.maps.Marker({ 
            position: position,
            map: this.map
        })

        const infoWindow = new google.maps.InfoWindow({
          content: `<div>${coord.name}</div><br>
                    <div style="text-align: center">${coord.counts} Usulan</div>`
        })

        marker.addListener('click', () => {
          if (this.activeInfoWindow) {
            this.activeInfoWindow.close()
          }          
          infoWindow.open(this.map, marker)
          this.activeInfoWindow = infoWindow

        })
      })
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
