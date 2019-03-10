<template>
  <v-multiselect
    v-model="selected"
    :options="options"
    :placeholder="placeholder"
    :close-on-select="false"
    :multiple="multiple"
    select-label=""
    selected-label=""
    deselect-label=""></v-multiselect>
</template>

<script>
  import VMultiselect from 'vue-multiselect'

  export default {
    components: { VMultiselect },
    props: {
      options: {
        type: Array,
        default: []
      },
      value: {
        default: null
      },
      multiple: {
        type: Boolean,
        default: false
      },
      placeholder: {
        type: String,
        default: 'Select'
      }
    },
    data: function() {
      return {
        selected: this.value || null
      }
    },
    watch: {
      selected: function(value) {
        this.$emit('update:value', value)
      }
    }
  }
</script>

<style lang="scss">
  @import "~bootstrap/scss/functions";
  @import "../../scss/bootstrap/functions";
  @import "../../scss/bootstrap/variables";
  @import "~bootstrap/scss/variables";
  @import "~vue-multiselect/dist/vue-multiselect.min.css";

  $innerHeight: ($input-btn-padding-y * 2) + ($font-size-base * $input-btn-line-height);
  $borders: 2 * $input-btn-border-width;
  $height: calc(#{$innerHeight} + #{$borders});
  $caret: calc(#{$input-btn-padding-x * 2} + 10px);

  .multiselect {
    min-height: $height;
    color: $body-color;
    z-index: 2;

    &, &__input, &__single {
      font-size: 14px;
    }

    &__tags {
      padding: 0 $input-btn-padding-x $input-btn-padding-y;
      padding-right: $caret;
      font-size: $font-size-base;
      line-height: $input-btn-line-height;
      color: $input-color;

      border: $input-btn-border-width solid $input-border-color;
      border-radius: $input-border-radius;
    }

    &__select {
      height: $innerHeight;
      width: $caret;
      line-height: inherit;
      transition: none;

      &:before {
        display: inline-block;
        position: static;
      }
    }

    &__spinner {
      height: $innerHeight;
      width: $caret;
    }

    &__tags {
      min-height: $height;
    }

    &__input {
      padding: 0;
      margin: 0;
      margin-top: $input-btn-padding-y;

      &::placeholder {
        color: $input-placeholder-color;
        opacity: 1;
      }
    }

    &__single {
      padding-left: 0px;
      margin-bottom: 0px;
      margin-top: 6px;
    }

    &__content-wrapper {
      border-color: $dropdown-border-color;
      z-index: 1000;
    }

    &__option {
      color: $body-color;

      &--selected,
      &--selected:after {
        background: $gray-100;
        // font-weight: normal;
        color: $body-color;
      }

      &--highlight,
      &--highlight:after,
      &--selected.multiselect__option--highlight,
      &--selected.multiselect__option--highlight:after {
        background: $gray-100;
        color: $body-color;
      }
    }

    &__tags-wrap {
      vertical-align: top;
    }

    &__tag {
      padding: $badge-padding-y $badge-padding-x;
      padding-right: calc(19px + #{$badge-padding-x});
      border-radius: $badge-border-radius;
      background: map-get($theme-colors, 'light');
      color: $gray-600;
      font-size: 75%;
      border: 1px solid rgba(0, 0, 0, 0.10);
      vertical-align: top;
      margin-bottom: 0;
      margin-top: $input-btn-padding-y;
      margin-right: $input-btn-padding-y;
    }

    &__tag-icon {
      width: 19px;
      line-height: 1.3;
      border-radius: $badge-border-radius;
      border-top-left-radius:0;
      border-bottom-left-radius:0;
      margin-left: $badge-padding-x;
      transition: none;
      border-left: 1px solid rgba(0, 0, 0, 0.10);

      &:after {
        color: $gray-600;
      }

      &:hover {
        background: rgba(0, 0, 0, 0.05);

        &:after {
          color: $gray-600;
        }
      }
    }
  }
</style>
