<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="9" :xl="9">
        <el-card style="margin-bottom: 10px">
          <div slot="header" class="clearfix">
            <span>Lampiran</span>
          </div>
          <img :src="defaultImage || imageNone" :index="index" class="aspiration-gallery">
          <div class="aspiration-image">
            <div v-for="(image, imageIndex) in images" :key="imageIndex" :value="image.url" :class="['image', classObj]" :style="{ backgroundImage: 'url(' + image.url + ')'}" @click="imageGallery(imageIndex)" />
          </div>
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
          <el-table v-if="note !== null" :data="approvalNote" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-button v-if="status && roles" class="button-send" type="primary" @click="actionApprove">{{ $t('crud.accept') }}</el-button>
        <el-button v-if="status && roles" class="button-send" type="info" @click="actionReject">{{ $t('crud.reject') }}</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, approval } from '@/api/aspiration'
import checkPermission from '@/utils/permission'
import { mapState } from 'vuex'

export default {
  data() {
    return {
      id: 0,
      title: null,
      created_at: null,
      status: false,
      author: [],
      aspirationDetail: [],
      approvalNote: [],
      imageNone: require('@/assets/none.png'),
      defaultImage: null,
      images: [],
      index: null,
      note: null,
      roles: checkPermission(['admin', 'staffProv'])
    }
  },
  computed: {
    ...mapState({
      sidebar: state => state.app.sidebar,
      device: state => state.app.device
    }),
    classObj() {
      return {
        hideSidebar: !this.sidebar.opened,
        openSidebar: this.sidebar.opened,
        mobile: this.device === 'mobile'
      }
    }

  },
  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },
  methods: {
    imageGallery(index) {
      this.defaultImage = this.images[index].url
    },
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { title, created_at, author, category, description, status, status_label, attachments, approval_note } = response.data
        this.title = title
        this.created_at = created_at
        if (status === 10 || status === 3) {
          this.status = false
        } else if (status === 5) {
          this.status = true
        }
        this.images = attachments
        this.defaultImage = attachments ? attachments[0].url : null
        this.note = approval_note

        this.author = [
          {
            title: 'Dari',
            content: (author ? author.name : '-')
          },
          {
            title: 'Email',
            content: (author ? author.email : '-')
          },
          {
            title: 'Telepon',
            content: (author ? author.phone : '-')
          },
          {
            title: 'Alamat',
            content: (author ? author.address : '-')
          }
        ]

        this.aspirationDetail = [
          {
            title: 'Kategori',
            content: category.name
          },
          {
            title: 'Usulan',
            content: description
          },
          {
            title: 'Status',
            content: (status === 5 ? <el-tag type='warning'>{status_label}</el-tag> : status === 3 ? <el-tag type='danger'>{status_label}</el-tag> : status === 10 ? <el-tag type='success'>{status_label}</el-tag> : <el-tag type='info'>{status_label}</el-tag>)
          }
        ]

        this.approvalNote = [
          {
            title: 'Keterangan',
            content: (status === 3 || (approval_note && status === 5) ? approval_note : '-')
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

<style lang="scss" scoped>
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
  background-size: 65px 65px;
  background-repeat: no-repeat;
  cursor: pointer;
  margin: 5px;
  position: relative;
}

.aspiration-image {
  margin: auto;
  padding: 5px;
  width: 100%;
  text-align: center;
}

.openSidebar {
  width: 50px;
  height: 50px;
}

.hideSidebar {
  width: 65px;
  height: 65px;
}

.aspiration-gallery {
  width: 100%;
  height: 60%;
  display: block;
  border-radius: 7px;
  margin: auto;
}

</style>
