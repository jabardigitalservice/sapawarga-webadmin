<template>
  <div name="release-management-form">
    <el-row :gutter="20">
      <el-button type="danger" style="float: right;" @click="deleteMisionRow(index)">
        <span>Hapus Misi</span>
      </el-button>
      <el-col :xs="24" :sm="16">
        <el-form ref="form" :status-icon="true" label-width="210px">

          <el-form-item label="Nama Misi">
            <el-input
              v-model="fitur"
              type="text"
              name="fitur"
              placeholder="Nama Misi"
            />
          </el-form-item>

          <el-form-item label="Jumlah Task">
            <el-input
              v-model="jumlah_task"
              type="text"
              name="jumlah_task"
              placeholder="Jumlah Task"
            />
          </el-form-item>

          <el-form-item label="Detail Misi">
            <el-input
              v-model="deskripsi"
              type="textarea"
              :autosize="{ minRows: 2, maxRows: 4}"
              name="deskripsi"
              placeholder="Detail Misi"
            />
          </el-form-item>

        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>

export default {
  props: {
    index: {
      type: Number,
      default: null
    },
    fitur: {
      type: String,
      default: ''
    },
    jumlahTask: {
      type: Number,
      default: 0
    },
    deskripsi: {
      type: String,
      default: ''
    }
  },
  data() {
    return {

    }
  },
  mounted() {

  },
  methods: {
    deleteMisionRow(index) {
      this.$store.commit('gamification/deleteMisionRow', index)
    }
  }
}
</script>
