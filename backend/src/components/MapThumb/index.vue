<template>
  <div id="leafletmap" ref="mapElement" />
</template>

<script>
import leaflet from 'leaflet'

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
      map: null,
      zoom: 12
    }
  },
  mounted() {
    this.initMap()
  },
  methods: {
    initMap() {
      try {
        this.map = leaflet
          .map('leafletmap')
          .setView([this.latitude, this.longitude], this.zoom)
        this.tileLayer = leaflet.tileLayer(
          'https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png',
          {
            maxZoom: 18,
            attribution:
              '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>'
          }
        )

        this.tileLayer.addTo(this.map)
        this.initMarker()
      } catch (error) {
        console.error(error)
        // this.$message.error(this.$t('map-error'))
      }
    },
    initMarker() {
      leaflet.marker([this.latitude, this.longitude]).addTo(this.map)
    }
  }
}
</script>
