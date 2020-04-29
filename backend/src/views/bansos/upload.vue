<template>
  <div class="app-container">
    <el-row>
      <el-col :span="24">
        <el-card class="box-card green body-nopadding">
          <div slot="header">
            <span>Upload Data KRTS Non DTKS</span>
          </div>
          <div class="text item card-description">
            <p><strong>Pilih pintu bantuan untuk upload KRTS</strong></p>
            <p>Sebelum melakukan upload Data KRTD Non DTKS, diharapkan data dipecah berdasarkan alokasi sesuai pintu bantuan. Untuk melakukan upload data, pilih pintu bantuan yang akan di upload.</p>
          </div>
        </el-card>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="24">
        <router-link to="/bansos/upload-form?type=1">
          <el-card class="box-card">
            <p>Bantuan Sosial Provinsi</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=2">
          <el-card class="box-card">
            <p>Bantuan Sosial Kota / Kabupaten</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=3">
          <el-card class="box-card">
            <p>Bantuan Dana Desa</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=4">
          <el-card class="box-card">
            <p>Bantuan Sosial Presiden Sembako (Bodebek)</p>
          </el-card>
        </router-link>

        <router-link to="/bansos/upload-form?type=5">
          <el-card class="box-card">
            <p>Bantuan Sosial Tunai Kemensos</p>
          </el-card>
        </router-link>
      </el-col>
    </el-row>

    <el-row style="margin-top: 50px">
      <el-col :span="24">
        <el-card class="box-card green">
          <div slot="header">
            <span>Daftar Riwayat Upload Data KRTS Non DTKS</span>
          </div>
          <div class="text item">
            <el-table
              :data="tableData"
              border
              style="width: 100%"
            >
              <el-table-column
                prop="date"
                label="Tanggal Upload"
                width="180"
              />
              <el-table-column
                prop="name"
                label="Jenis Pintu Bantuan"
                width="250"
              />
              <el-table-column
                prop="target"
                label="Target Upload"
              />
            </el-table>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tableData: [{
        date: '2020-04-03 18:00:00',
        name: 'Bantuan Sosial Provinsi',
        target: 'KOTA BANDUNG'
      }, {
        date: '2020-04-03 18:00:00',
        name: 'Bantuan Sosial Provinsi',
        target: 'KOTA BANDUNG'
      }, {
        date: '2020-04-03 18:00:00',
        name: 'Bantuan Sosial Provinsi',
        target: 'KOTA BANDUNG'
      }, {
        date: '2020-04-03 18:00:00',
        name: 'Bantuan Sosial Provinsi',
        target: 'KOTA BANDUNG'
      }]
    }
  }
}
</script>
