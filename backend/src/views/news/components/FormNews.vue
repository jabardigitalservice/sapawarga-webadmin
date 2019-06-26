<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="16">
        <!-- <el-alert
          v-if="form.status === 10"
          type="error"
          description="Data sudah aktif, Anda tidak bisa mengubah data ini."
          show-icon
          style="margin-bottom: 15px"
        /> -->

        <el-form ref="news" :model="news" :rules="rules" :status-icon="true" label-width="160px">
          <el-form-item label="Judul Berita" prop="title">
            <el-input v-model="news.title" type="text" placeholder="Judul Berita" />
          </el-form-item>

          <el-form-item label="Sumber" prop="source">
            <el-select v-model="news.source" placeholder="Pilih Sumber">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.value"
                :value="item.value"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="Tanggal Berita" prop="date">
            <el-date-picker
              v-model="news.date"
              type="date"
              :editable="false"
              :clearable="false"
              format="dd-MM-yyyy"
              placeholder="Pilih Tanggal"
            />
          </el-form-item>

          <el-form-item label="URL Berita" prop="external_url">
            <el-input v-model="news.external_url" type="text" placeholder="http://form.google.com" />
          </el-form-item>

          <el-form-item label="Konten Berita" prop="">
            <el-input
              v-model="news.content"
              type="textarea"
              :rows="12"
              placeholder="Konten Berita"
            />
          </el-form-item>

          <el-form-item>
            <el-button type="primary" :loading="loading" @click="submitProcess">{{ $t('crud.save-create') }}</el-button>
          </el-form-item>

        </el-form>

      </el-col>
    </el-row>
  </div>
</template>
<script>
import InputCategory from '@/components/InputCategory'
export default {
  components: {
    InputCategory
  },
  data() {
    return {
      news: {
        title: null,
        category_id: null,
        start_date: null,
        external_url: null,
        content: null
      },
      rules: {}
    }
  }
}
</script>
