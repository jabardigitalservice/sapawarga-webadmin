<template>
  <div class="app-container gamification-detail">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.gamification-detail') }}</span>
          </div>
          <detail-data :table-content-data="tableDataNews" />
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import DetailData from '@/components/DetailData'

export default {
  components: {
    DetailData
  },
  data() {
    return {
      tableDataNews: [],
      news: null
    }
  },
  mounted() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },
  methods: {
    getDetail() {
      this.tableDataNews = [
        {
          title: 'Background',
          content: '-'
        },
        {
          title: 'Judul',
          content: 'Membaca 10 Berita'
        },
        {
          title: 'Fitur',
          content: 'Berita'
        },
        {
          title: 'Action',
          content: '-'
        },
        {
          title: 'Dibuat',
          content: '10 Desember 2020'
        },
        {
          title: 'Berakhir',
          content: '10 Desember 2020'
        },
        {
          title: 'Deskripsi',
          content: '-'
        },
        {
          title: 'Penghargaan',
          content: '-'
        },
        {
          title: 'Jumlah Hit',
          content: '-'
        }
      ]
    }

  }
}
</script>
