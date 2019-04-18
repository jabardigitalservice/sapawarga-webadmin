<template>
  <div>
    <el-row :gutter="10" type="flex" justify="end">
      <el-col :span="8">
        <el-select v-model="kabkota_selected" clearable filterable placeholder="Pilih Kabupaten/Kota" style="width: 100%" @change="changeSelection($event, 'changeKabkota')">
          <el-option
            v-for="item in kabkota_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>

      <el-col :span="8">
        <el-select v-model="kecamatan_selected" clearable filterable placeholder="Pilih Kecamatan" style="width: 100%" @change="changeSelection($event, 'changeKecamatan')">
          <el-option
            v-for="item in kecamatan_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>

      <el-col :span="8">
        <el-select v-model="kelurahan_selected" clearable filterable placeholder="Pilih Kelurahan" style="width: 100%" @change="changeSelection($event, 'changeKelurahan')">
          <el-option
            v-for="item in kelurahan_options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  props: {
    //
  },

  data() {
    return {
      kabkota_selected: null,
      kecamatan_selected: null,
      kelurahan_selected: null,
      kabkota_options: [
        {
          value: 1,
          label: 'Kota Bandung'
        },
        {
          value: 2,
          label: 'Kabupaten Bandung'
        }
      ],
      kecamatan_options: [
        {
          value: 1,
          label: 'Kota Bandung'
        },
        {
          value: 2,
          label: 'Kabupaten Bandung'
        }
      ],
      kelurahan_options: [
        {
          value: 1,
          label: 'Kota Bandung'
        },
        {
          value: 2,
          label: 'Kabupaten Bandung'
        }
      ]
    }
  },

  methods: {
    changeSelection(value, type) {
      this.$emit(type, value)
    }
  }
}
</script>
