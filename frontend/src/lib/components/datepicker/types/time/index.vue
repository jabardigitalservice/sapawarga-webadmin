<script>
  import EDatepicker from '../../index'

  export default {
    extends: EDatepicker,
    data: function() {
      return {
        localDefaults: {
          enableTime: true,
          noCalendar: true,
          time_24hr: true
        }
      }
    }
  }
</script>
