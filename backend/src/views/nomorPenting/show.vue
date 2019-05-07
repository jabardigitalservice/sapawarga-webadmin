<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col :sm="24" :lg="8" :xl="6">
        <PhotoBox :image="imageUrl" :height="height" />
      </el-col>
      <el-col :sm="24" :lg="16" :xl="18">
        <el-card>
          <div slot="header" class="clearfix">
            <span>Nomor Telepon</span>
          </div>
          <el-table :data="tableData" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" width="180" />
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
// TODO: make table dynamic from API
import PhotoBox from '@/components/PhotoBox'

export default {
  components: { PhotoBox },
  data() {
    return {
      id: 0,
      imageUrl: require('@/assets/user.png'),
      height: '220px',
      tableData: [
        {
          title: 'Nama Instansi',
          content: ': Tom'
        },
        {
          title: 'Alamat Instansi',
          content: ': Tom'
        },
        {
          title: 'Kategori Instansi',
          content: ': Tom'
        },
        {
          title: 'Deskripsi',
          content: ': Tom'
        }
      ]
    }
  },

  created() {
    const id = this.$route.params && this.$route.params.id
    this.id = id
    console.log(id)
    // this.fetchData(id);
  }
}
</script>

<style lang="scss" scoped>
</style>
