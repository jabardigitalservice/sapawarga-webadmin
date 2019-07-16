<template>
  <div class="mapouter">
    <div class="gmap_canvas">
      <iframe
        :id="id"
        :src="urlMap"
        frameborder="0"
        scrolling="no"
        marginheight="0"
        marginwidth="0"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'MapThumb',
  props: {
    latitude: {
      type: String,
      default: '-6.8675185',
      required: true
    },
    longitude: {
      type: String,
      default: '107.0446946',
      required: true
    },
    id: {
      type: String,
      default: 'gmap_canvas'
    }
  },
  data() {
    return {
      urlMap: `https://maps.google.com/maps?q=${this.latitude},${this.longitude}&t=&z=16&ie=UTF8&iwloc=&output=embed`
    }
  }
}
</script>

<style lang="scss" scoped>
.map {
  margin-top: 50px;
  height: 50px;
  width: 270px;
}

.mapouter {
    position: relative;
    text-align: right;
    height: 350px;
    width: 400px;
  }
  .gmap_canvas {
    background: none !important;
    width: 400px;
    height: 350px;
    margin-left: 20px;
    border-radius: 5px;
    margin-top: 20px;
    -webkit-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);

    iframe {
      width: 400px;
      height: 350px;
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
