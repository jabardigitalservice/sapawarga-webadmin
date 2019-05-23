<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="9" :xl="9">
        <el-card style="margin-bottom: 10px">
          <div slot="header" class="clearfix">
            <span>Dokumentasi</span>
          </div>
          <div class="aspiration-image">
            <gallery class="aspiration-gallery" :images="gambar" :index="index" />
            <div v-for="(image, imageIndex) in gambar" :key="image.src" :value="image.src" class="image" :style="{ backgroundImage: 'url(' + image + ')', width: '50px', height: '50px'}" @click="index = imageIndex" />
          </div>
          <!-- <lingallery :width="100" :height="70" :items="images" :responsive="true" /> -->
          <!-- <img :src="images[0].src"> -->
        </el-card>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="15" :xl="15">
        <el-card>
          <div slot="header" class="clearfix">
            <el-row>
              <el-col :span="20">
                <span class="aspiration-title">{{ title }}</span>
              </el-col>
              <el-col :span="4">
                <span class="aspiration-date"> {{ created_at | moment('D MMMM YYYY') }} </span>
              </el-col>
            </el-row>
          </div>
          <el-table stripe :data="author" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-card style="margin-top: 10px">
          <el-table stripe :data="aspirationDetail" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-button v-if="status" class="button-send" type="primary" @click="actionApprove">{{ $t('crud.accept') }}</el-button>
        <el-button v-if="status" class="button-send" type="info" @click="actionReject">{{ $t('crud.reject') }}</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, approval } from '@/api/aspiration'
import VueGallery from 'vue-gallery'
import Lingallery from 'lingallery'
export default {
  components: {
    'gallery': VueGallery,
    'lingallery': Lingallery
  },
  data() {
    return {
      id: 0,
      title: null,
      created_at: null,
      status: false,
      author: [],
      aspirationDetail: [],
      gambar: [
        require('@/assets/twitter.svg'),
        require('@/assets/facebook.svg'),
        require('@/assets/user.png'),
      ],
      images: [
        {
          src: require('@/assets/twitter.svg'),
          thumbnail: require('@/assets/twitter.svg'),
        },
        {
          src: require('@/assets/facebook.svg'),
          thumbnail: require('@/assets/facebook.svg')
        },
        {
          src: require('@/assets/instagram.svg'),
          thumbnail: require('@/assets/instagram.svg')
        },
        {
          src: require('@/assets/user.png'),
          thumbnail: require('@/assets/user.png')
        }        
      ],
      index: null
    }
  },
  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },
  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        console.log(response)
        const { title, created_at, author, category, description, status, status_label, attachments } = response.data
        this.title = title
        this.created_at = created_at
        if (status === 10 || status === 3) {
          this.status = false
        } else if (status === 5) {
          this.status = true
        }

        this.author = [
          {
            title: 'Dari',
            content: author.name || '-'
          },
          {
            title: 'Email',
            content: author.email || '-'
          },
          {
            title: 'Telepon',
            content: author.phone || '-'
          },
          {
            title: 'Alamat',
            content: author.address || '-'
          },
          {
            title: 'Lampiran',
            content: attachments || '-'
          }

        ]

        this.aspirationDetail = [
          {
            title: 'Kategori',
            content: category.name
          },
          {
            title: 'Aspirasi',
            content: description
          },
          {
            title: 'Status',
            content: (status === 5 ? <el-tag type='warning'>{status_label}</el-tag> : status === 3 ? <el-tag type='danger'>{status_label}</el-tag> : status === 10 ? <el-tag type='success'>{status_label}</el-tag> : <el-tag type='info'>{status_label}</el-tag>)
          },
          {
            title: 'Keterangan',
            content: ''
          }
        ]
      })
    },

    async actionApprove() {
      const id = this.id

      await this.$confirm('Apakah Anda yakin ingin memberikan persetujuan untuk aspirasi ini?', 'Konfirmasi', {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'success'
      })

      try {
        await approval(id, {
          action: 'APPROVE'
        })

        this.$message.success(this.$t('crud.update-success'))

        this.$router.push('/aspirasi/index')
      } catch (e) {
        console.log(e)
      }
    },

    validateInput(input) {
      if (_.isEmpty(input)) {
        return 'Catatan harus diisi.'
      }

      return true
    },

    async actionReject() {
      const id = this.id

      const prompt = await this.$prompt('Apakah Anda yakin ingin menolak aspirasi ini? Masukkan catatan untuk pengguna.', 'Konfirmasi Penolakan', {
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        inputPlaceholder: 'Isikan catatan untuk pengguna',
        inputValidator: this.validateInput
      })

      try {
        await approval(id, {
          action: 'REJECT',
          note: prompt.value
        })

        this.$message.success(this.$t('crud.update-success'))

        this.$router.push('/aspirasi/index')
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>

<style lang="scss">
.aspiration-date {
  float: right;
  font-size: 14px;
}

.aspiration-title {
  font-size: 18px;
  font-weight: bold;
  line-height: 25px;
}

.button-send {
  margin: 10px;
  float: right;
}

.image {
    display: inline-block;
    background-size: 50px 50px;
    background-repeat: no-repeat;
    cursor: pointer;
    margin: 5px;
    align-content: center;
  }

.aspiration-image {
  margin: auto;
}

.aspiration-gallery {
  width: 300px;
  height: 300px;
  position: relative;
  border-radius: 5px;
  margin: auto;
}

</style>
