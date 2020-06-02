<template>
  <el-row :gutter="20" class="pb-2">
    <el-col :span="8">
      <div>
        <el-card shadow="never" class="section-box-upload" :body-style="{'border-radius': '8px','background-color': '#FF834E', 'color': '#fff' }">
          <el-row :gutter="20" class="pb-2 box-upload-info">
            <el-col :span="7">
              <div>
                <img src="@/assets/upload-data.svg">
              </div>
            </el-col>
            <el-col :span="17"><div class="text-24 text-bold pl-1 line-height-29">Upload manual data calon penerima Bantuan <br> Sosial</div></el-col>
          </el-row>

          <div class="text-14">
            Sekarang Anda dapat melakukan input calon penerima bantuan sosial secara manual, sehingga dapat membantu kami lebih baik lagi untuk memperbaiki perlayanan di Sapawarga
          </div>

          <el-row class="section-action-upload">
            <el-button size="medium" class="bg-sw-green text-white text-16 border-radius-8 border-green text-bold p-2 mr-1">UPLOAD SEKARANG</el-button>
            <el-button size="medium" class="bg-transparant text-white text-16 border-radius-8 border-none text-bold p-2 border-2">LIHAT PANDUAN</el-button>
          </el-row>
        </el-card>
      </div>
    </el-col>
    <el-col :span="16">2</el-col>
  </el-row>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.color-sw-green {
  color: #02964D;
}

.bg-sw-green {
  background-color: #02964D;
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
