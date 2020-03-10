<template>
  <div class="app-container gamification-detail">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.gamification-detail') }}</span>
          </div>
          <detail-data :table-content-data="tableDataNews" />
          <detail-data :table-content-data="tableImageAttachment" :input-image="image || imageNone" :width="'width:50px'" />
          <detail-data :table-content-data="tableDataDescription" />
        </el-card>
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.list-participant') }}</span>
          </div>
          <user-participant :list-participant="listParticipant" :list-query="listQuery" :total="totalListParticipant" />
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { fetchRecord, fetchListParticipant } from '@/api/gamification'
import DetailData from '@/components/DetailData'
import moment from 'moment'
import UserParticipant from './components/_listUserParticipant'

export default {
  components: {
    DetailData,
    UserParticipant
  },
  data() {
    return {
      tableDataNews: [],
      tableImageAttachment: [],
      tableDataDescription: [],
      image: null,
      imageNone: require('@/assets/none.png'),
      news: null,
      listParticipant: {},
      listQuery: {
        id: this.id,
        page: 1,
        limit: 10
      },
      totalListParticipant: 0
    }
  },
  watch: {
    'listQuery.page': {
      handler: function(value) {
        this.getListParticipant()
      }
    }
  },
  mounted() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
    this.getListParticipant()
  },
  methods: {
    async getDetail() {
      const detail = await fetchRecord(this.id)
      this.image = detail.data.image_badge_path_url
      this.tableDataNews = [
        {
          title: this.$t('label.gamification-title-mision'),
          content: detail.data.title
        },
        {
          title: this.$t('label.gamification-title-fitur'),
          content: this.$t(`label.gamification-fitur-${detail.data.object_type}`)
        },
        {
          title: this.$t('label.gamification-action-fitur'),
          content: this.$t(`label.gamification-event-${detail.data.object_event}`)
        },
        {
          title: this.$t('label.start-date'),
          content: moment(detail.data.start_date).format('D MMMM YYYY')
        },
        {
          title: this.$t('label.end-date'),
          content: moment(detail.data.end_date).format('D MMMM YYYY')
        },
        {
          title: this.$t('label.gamification-amount-hit'),
          content: detail.data.total_hit
        },
        {
          title: this.$t('label.gamification-name-reward'),
          content: detail.data.title_badge
        }

      ]
      this.tableImageAttachment = [
        {
          title: this.$t('label.gamification-badge-logo'),
          content: detail.data.image_badge_path_url
        }
      ]
      this.tableDataDescription = [
        {
          title: this.$t('label.gamification-description-mision'),
          content: detail.data.description
        }
      ]
    },
    async getListParticipant() {
      const response = await fetchListParticipant(this.listQuery)
      this.listParticipant = await response.data
      this.totalListParticipant = await response.data._meta.totalCount
    }
  }
}
</script>
