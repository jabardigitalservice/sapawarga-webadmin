<script>
  import EDatepicker from '../../index'

  export default {
    extends: EDatepicker,
    data: function() {
      return {
        localDefaults: {
          dateFormat: 'j M Y H:i',
          enableTime: true,
          time_24hr: true
        }
      }
    }
  }
</script>
