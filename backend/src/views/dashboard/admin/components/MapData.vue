<template>
  <el-card class="box-card">
    <div class="text item">
      <el-row :gutter="8">
        <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 16}" :xl="{span: 16}" style="padding-right:8px;margin-bottom:30px;">
          <div class="mapouter">
            <div class="gmap_canvas">
              <iframe
                id="gmap_canvas"
                :src="`https://maps.google.com/maps?q=${latitude},${longitude}&t=&z=16&ie=UTF8&iwloc=&output=embed`"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
              />
            </div>
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
export default {
  data() {
    return {
      list: null,
      latitude: -6.914744,
      longitude: 107.609810
    }
  },
  created() {
    this.getMap()
  },
  methods: {
    getMap() {
      fetchAspirasiMap().then(response => {
        this.list = response.data.items
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

  .mapouter {
      position: relative;
      text-align: right;
      height: 400px;
      width: 640px;
    }
    .gmap_canvas {
      background: none !important;
      width: 640px;
      height: 400px;
      margin-left: 0px;
      border-radius: 5px;
      margin-top: 0px;
      // -webkit-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
      // -moz-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
      // box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);

      iframe {
        width: 640px;
        height: 400px;
      }
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

</style>
