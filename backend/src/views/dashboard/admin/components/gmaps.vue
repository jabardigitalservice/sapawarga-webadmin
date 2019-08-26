<template>
  <div class="google-map" :id="mapName"></div>
</template>


<script>
import gmapsInit from "@/utils/gmaps";
export default {
    name: 'googleMap',
  props: ['name'],
  data: function () {
    return {
      mapName: this.name,
    }
  },
  async mounted() {
    try {
      const google = await gmapsInit()
      const element = document.getElementById(this.mapName)
      const geocoder = new google.maps.Geocoder()
      const map = new google.maps.Map(this.mapName)

      geocoder.geocode({ address: "Austria" }, (results, status) => {
        if (status !== 'OK' || !results[0]) {
          throw new Error(status);
        }

        map.setCenter(results[0].geometry.location)
        map.fitBounds(results[0].geometry.viewport)
      });
    } catch (error) {
      console.error(error);
    }
  }
};
</script>

<style scoped>
.google-map {
  width: 800px;
  height: 600px;
  margin: 0 auto;
  background: gray;
}
</style>