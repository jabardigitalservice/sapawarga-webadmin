<script>
  import EDatepicker from '../../index'

  export default {
    extends: EDatepicker,
    data: function() {
      return {
        localDefaults: {
          mode: 'range',
          dateFormat: 'd M y',
        }
      }
    }
  }
</script>
