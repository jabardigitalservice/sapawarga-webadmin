<template>
  <el-row :gutter="20" class="pb-2">
    <el-col :span="8" style="position:relative">
      <div>
        <el-card shadow="never" class="section-box-upload" :body-style="{'border-radius': '8px','background-color': '#FF834E', 'color': '#fff' }">
          <el-row :gutter="20" class="pb-2 box-upload-info">
            <el-col :span="7">
              <div>
                <img src="@/assets/upload-data.svg" alt="icon-upload">
              </div>
            </el-col>
            <el-col :span="17"><div class="text-24 text-bold pl-1 line-height-29">Import manual data calon penerima Bantuan <br> Sosial</div></el-col>
          </el-row>

          <div class="text-14">
            Sekarang Anda dapat melakukan input calon penerima bantuan sosial secara manual, sehingga dapat membantu kami lebih baik lagi untuk memperbaiki perlayanan di Sapawarga
          </div>

          <el-row class="section-action-upload">
            <el-button size="medium" class="bg-sw-green text-white text-16 border-radius-8 border-green text-bold p-2 mr-1">IMPORT SEKARANG</el-button>
            <el-button size="medium" class="bg-transparant text-white text-16 border-radius-8 border-none text-bold p-2 border-2">LIHAT PANDUAN</el-button>
          </el-row>
        </el-card>
      </div>
      <div class="bg-upload">
        <img src="@/assets/bg-upload-manual.png" alt="bg-upload">
      </div>
    </el-col>
    <el-col :span="16">
      <el-card shadow="never" class="section-box-table border-radius-8" :body-style="{'border-radius': '8px' }">
        <div class="title-table">
          <el-row :gutter="20">
            <el-col :span="12">
              <div class="text-22 text-bold">
                Riwayat Import Data Manual
              </div>
            </el-col>
            <el-col :span="6" :offset="6" style="text-align:end">
              <el-button size="medium" class="text-16 border-orange text-orange border-radius-8">Unduh Template Excel</el-button>
            </el-col>
          </el-row>
        </div>
        <el-table
          :data="tableData"
          stripe
          :header-row-style="{'color': '#000' }"
          height="245"
          style="width: 100%"
        >
          <el-table-column
            prop="no"
            label="NO"
            width="100"
          />
          <el-table-column
            prop="namaFile"
            label="NAMA FILE"
          />
          <el-table-column
            prop="status"
            label="STATUS"
          />
          <el-table-column
            prop="date"
            label="WAKTU UPLOAD"
          />
          <el-table-column
            label="AKSI"
          >
            <template slot-scope="scope">
              <el-button
                size="mini"
                type="primary"
                icon="el-icon-share"
                @click="handleEdit(scope.$index, scope.row)"
              />
            </template>
          </el-table-column>
        </el-table>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
export default {
  data() {
    return {
      tableData: [
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'asdasdas  adasdsadas asdadasdas assa dad asdas da',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        },
        {
          no: 1,
          namaFile: 'Tom',
          status: 'gagal',
          date: '2016-05-03',
          action: 1
        }
      ]
    }
  }
}
</script>

<style lang="scss" scoped>

.title-table {
  padding-bottom: 1rem;
  border-bottom: 1px solid #E0E0E0;
}

.color-sw-green {
  color: #02964D;
}

.bg-sw-green {
  background-color: #02964D;
}

.bg-upload {
    position: absolute;
    bottom: 0;
    right: 0;
}

.line-height-29 {
  line-height: 29px;
}

.bg-transparant {
  background-color: transparent;
}

.text-white {
  color: #fff;
}

.text-orange {
  color: #FF9A08;
}

.mr-1 {
  margin-right: 1rem;
}

.border-radius-8 {
  border-radius: 8px;
}

.border-none {
  border: none;
}

.border-green {
  border: 2px solid #02964D;
}

.border-orange {
  border: 2px solid #FF9A08;
}

.border-2 {
  border: 2px solid #FFFFFF;
}

.pl-1 {
  padding-left: 1rem;
}

.p-2 {
  padding: 1rem;
}

.pb-2 {
  padding-bottom: 2rem;
}

.bg-orange-upload {
  background-color: #FF834E;
}

.text-24 {
  font-size: 24px;
}

.text-22 {
  font-size: 22px;
}

.text-14 {
  font-size: 14px;
}

.text-16 {
  font-size: 16px;
}

.text-bold {
  font-weight: bold;
}

.section-box-upload {
  border: unset;
}

.box-upload-info {
  display: flex;
  align-items: flex-end;
  padding-top: 1rem;
}

.section-action-upload {
  padding-top: 1.5rem;
  padding-bottom: 1rem;
}
</style>
