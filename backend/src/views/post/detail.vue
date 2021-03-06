<template>
  <div class="app-container">
    <p class="warn-content"><a href="#">{{ $t('label.post-detail') }}</a></p>

    <el-row>
      <el-col :sm="24" :md="9">
        <el-card :body-style="{ padding: '15px'}" class="post-image">
          <div slot="header" class="clearfix">
            <span>{{ $t('label.image') }}</span>
          </div>

          <img v-if="!imageArray" :src="imageNone" class="multiple-images">

          <el-carousel v-else indicator-position="outside" :autoplay="false" trigger="click">
            <el-carousel-item v-for="(item, index) in imageArray" :key="index">
              <img :src="item.url" class="multiple-images">
            </el-carousel-item>
          </el-carousel>
        </el-card>
      </el-col>
      <el-col :sm="24" :md="15">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.post-data') }}</span>
          </div>
          <detail-data :table-content-data="tableDataRecord" />

          <detail-data :table-content-data="tableDataDescription" />
        </el-card>

        <el-button :disabled="status === 10" class="button-send" type="primary" @click="activateRecord">{{ $t('label.post-detail-accept') }}</el-button>
        <el-button :disabled="status === 0" class="button-send" type="info" @click="deactivateRecord">{{ $t('label.post-detail-reject') }}</el-button>

      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, deactivate, activate } from '@/api/post'
import DetailData from '@/components/DetailData'
import { parsingDatetime } from '@/utils/datetimeToString'

export default {
  components: {
    DetailData
  },
  data() {
    return {
      id: null,
      status: null,
      imageArray: null,
      tableDataRecord: [],
      tableDataDescription: [],
      tableImageAttachment: [],
      imageNone: require('@/assets/none.png')
    }
  },
  async created() {
    this.id = await this.$route.params && this.$route.params.id
    await this.getDetail(this.id)
  },
  methods: {
    getDetail(id) {
      fetchRecord(id).then(response => {
        const { user, status_label, created_at, text, tags } = response.data
        this.status = response.data.status
        this.imageArray = response.data.images
        this.tableDataRecord = [
          {
            title: this.$t('label.post-detail-name'),
            content: user.name
          },
          {
            title: this.$t('label.post-tag'),
            content: tags || '-'
          },
          {
            title: this.$t('label.post-detail-area'),
            content: user.kabkota || '-'
          },
          {
            title: this.$t('label.status'),
            content: status_label
          },
          {
            title: this.$t('label.created_at'),
            content: parsingDatetime(created_at)
          }
        ]

        this.tableDataDescription = [
          {
            title: this.$t('label.post-detail-description'),
            content: text
          }
        ]
      })
    },
    async deactivateRecord() {
      const id = this.id
      try {
        await this.$confirm(this.$t('crud.deactivate-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })

        this.listLoading = true

        await deactivate(id)

        this.$message.success(this.$t('crud.deactivate-success'))

        this.$router.push('/post/index')
      } catch (e) {
        console.log(e)
      }
    },
    async activateRecord() {
      const id = this.id
      try {
        await this.$confirm(this.$t('crud.activate-confirm'), 'Warning', {
          confirmButtonText: this.$t('common.confirm'),
          cancelButtonText: this.$t('common.cancel'),
          type: 'warning'
        })
        this.listLoading = true

        await activate(id)

        this.$message.success(this.$t('crud.activate-success'))

        this.$router.push('/post/index')
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.button-send {
	float: right;
	margin: 10px 5px 100px 5px;
}
.multiple-images {
  width: 100%;
  height: 100%;
  display: block;
  border-radius: 7px;
  margin: auto;
}
</style>
