<template>
  <div class="components-container">
    <el-form
      :status-icon="true"
      label-width="310px"
      label-position="left"
    >
      <el-form-item label="Keterangan Kenapa Warga Ini Perlu Dibantu?">
        <el-input v-model="text_area" type="textarea" rows="4" />
      </el-form-item>
      <el-form-item label="Status ekonomi warga yang bersangkutan">
        <div>
          <el-radio-group v-model="radio_check">
            <el-radio label="0" style="line-height: 25px; font-weight: bold;">Miskin Baru  <br> <span style="margin-left: 25px; font-weight: normal;">Penjelasan miskin baru adalah orang miskin terdampak langsung COVID 19</span></el-radio>
          </el-radio-group>
        </div>

        <div style="margin-top: 10px;">
          <el-radio-group v-model="radio_check">
            <el-radio label="1" style="line-height: 25px; font-weight: bold;">Miskin Lama  <br> <span style="margin-left: 25px; font-weight: normal;">Penjelasan miskin lama adalah orang yang sebelum COVID 19 sudah masuk dalam status miskin</span></el-radio>
          </el-radio-group>
        </div>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  data() {
    const checkRadio = (rule, value, callback) => {
      const phoneStringFormat = value.toString()
      const checkStringPhone = phoneStringFormat.startsWith('0')
      if (checkStringPhone) {
        callback(new Error(this.$t('errors.rw-start-number')))
      } else {
        callback()
      }
    }
    return {
      text_area: '',
      radio_check: '0',
      rules: {
        text_area: [
          {
            required: true,
            message: 'Alamat harus diisi',
            trigger: 'blur'
          }
        ],
        radio_check: [
          {
            required: true,
            message: 'RT harus diisi',
            trigger: 'blur'
          },
          {
            validator: checkRadio,
            trigger: 'blur'
          }
        ]
      }
    }
  }
}
</script>

<style>

</style>
