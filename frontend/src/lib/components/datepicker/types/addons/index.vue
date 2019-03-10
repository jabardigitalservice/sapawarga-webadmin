<template>
  <div class="input-group">
    <span v-if="prepend" class="input-group-prepend">
      <span class="input-group-text">
        <i :class="prepend"></i>
      </span>
    </span>
    <flat-pickr
      class="form-control"
      ref="picker"
      :value="date"
      :config="options"
      :placeholder="placeholder"
      @on-change="handleDateChange"></flat-pickr>
    <div v-if="clear && isDate" class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" @click="clearDate">
        <i class="fa fa-close"></i>
      </button>
    </div>
    <span v-if="append" class="input-group-append">
      <span class="input-group-text">
        <i :class="append"></i>
      </span>
    </span>
  </div>
</template>

<script>
  import EDatepicker from '../../index'

  export default {
    extends: EDatepicker,
    props: {
      prepend: {
        type: String,
        default: ''
      },
      append: {
        type: String,
        default: ''
      },
      clear: {
        type: Boolean,
        default: false
      }
    },
    data: function() {
      return {
        localDefaults: {
          wrap: true
        }
      }
    },
    methods: {
      clearDate: function() {
        this.$refs.picker.fp.clear()
      }
    }
  }
</script>
