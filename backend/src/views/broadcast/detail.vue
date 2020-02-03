<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="10" :xl="10">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.target') }}</span>
          </div>
          <el-table stripe :data="tableDataTarget" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="14" :xl="14">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.description') }}</span>
          </div>
          <el-table stripe :data="tableDataPesan" :show-header="false" style="width: 100%">
            <el-table-column prop="title" />
            <el-table-column prop="content">
              <template slot-scope="{row}">
                <div v-if="isContainHtmlTags(row.content)" v-html="row.content" />
                <a v-else-if="validUrl(row.content)" :href="row.content" target="_blank" class="link">{{ row.content }}</a>
                <div v-else>{{ row.content }}</div>
              </template>
            </el-table-column>
          </el-table>
        </el-card>
        <el-button v-if="!buttonHidden" :disabled="btnKirimDisable" class="button-send" type="primary" @click="actionApprove(status.PUBLISHED)">{{ $t('crud.send') }}</el-button>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import moment from 'moment'
import { fetchRecord, update } from '@/api/broadcast'
import { parsingDatetime } from '@/utils/datetimeToString'
import { isContainHtmlTags, validUrl } from '@/utils/validate'
import { PopupFeature, PopupCategory } from '@/utils/constantVariable'

export default {
  data() {
    return {
      id: 0,
      tableDataTarget: [],
      tableDataPesan: [],
      isiPesan: null,
      broadcast: null,
      btnKirimDisable: false,
      buttonHidden: false,
      status: {
        DRAFT: 0,
        SCHEDULED: 5,
        PUBLISHED: 10
      }
    }
  },

  created() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },

  methods: {
    isContainHtmlTags,
    validUrl(str) {
      return validUrl(str)
    },
    getDetail() {
      fetchRecord(this.id).then(response => {
        const {
          title,
          description,
          category,
          kabkota,
          kecamatan,
          kelurahan,
          rw,
          status,
          status_label,
          scheduled_datetime,
          is_scheduled,
          updated_at,
          type,
          link_url,
          internal_object_type,
          internal_object_name
        } = response.data
        this.broadcast = response.data
        this.checkDate(response.data)
        if (status === this.status.DRAFT) {
          this.buttonHidden = false
        } else {
          this.buttonHidden = true
        }

        this.tableDataTarget = [
          {
            title: this.$t('label.area-kabkota'),
            content: ((kabkota !== null) ? kabkota.name : 'Semua Kab/Kota')
          },
          {
            title: this.$t('label.area-kec'),
            content: ((kecamatan !== null) ? kecamatan.name : 'Semua Kecamatan')
          },
          {
            title: this.$t('label.area-kel'),
            content: ((kelurahan !== null) ? kelurahan.name : 'Semua Desa/Kelurahan')
          },
          {
            title: this.$t('label.area-rw'),
            content: ((rw !== null) ? rw : 'Semua RW')
          }
        ]

        this.tableDataPesan = [
          {
            title: this.$t('label.title-broadcast'),
            content: (title !== null ? title : '-')
          },
          {
            title: this.$t('label.category'),
            content: (category !== null ? category.name : '-')
          },
          {
            title: this.$t('label.status'),
            content: this.checkStatus(status, status_label)
          },
          {
            title: this.$t('label.scheduled'),
            content: is_scheduled === false ? 'Sekarang' : 'Terjadwal'
          },
          {
            title: this.$t('label.scheduled_datetime'),
            content: status === this.status.PUBLISHED && !is_scheduled ? parsingDatetime(updated_at) : parsingDatetime(scheduled_datetime)
          },
          {
            title: this.$t('label.broadcast-source'),
            content: type || '-'
          },
          {
            title: this.$t('label.broadcast-url'),
            content: link_url || '-'
          },
          {
            title: this.$t('label.broadcast-feature'),
            content: internal_object_type === PopupFeature.NEWS_IMPORTANT ? this.$t('label.broadcast-newsImportant') : internal_object_type === PopupFeature.NEWS ? this.$t('label.broadcast-news') : internal_object_type
          },
          {
            title: this.$t('label.broadcast-feature-title'),
            content: internal_object_name || '-'
          },
          {
            title: this.$t('label.description'),
            content: (description !== null ? description : '-')
          }
        ]

        this.isiPesan = description
        if (status === this.status.DRAFT && scheduled_datetime === null) {
          this.tableDataPesan.splice(4, 1)
          if (type === null) {
            this.tableDataPesan.splice(4, 4)
          } else if (type === PopupCategory.INTERNAL) {
            this.tableDataPesan.splice(5, 1)
          } else {
            this.tableDataPesan.splice(6, 2)
          }
        } else if (status === this.status.PUBLISHED || status === this.status.SCHEDULED) {
          this.tableDataPesan.splice(3, 1)
          if (type === null) {
            this.tableDataPesan.splice(4, 4)
          } else if (type === PopupCategory.INTERNAL) {
            this.tableDataPesan.splice(5, 1)
          } else {
            this.tableDataPesan.splice(6, 2)
          }
        } else {
          if (type === null) {
            this.tableDataPesan.splice(5, 4)
          } else if (type === PopupCategory.INTERNAL) {
            this.tableDataPesan.splice(6, 1)
          } else {
            this.tableDataPesan.splice(7, 2)
          }
        }
      })
    },
    async submitForm(status) {
      const id = this.$route.params && this.$route.params.id
      const data = {}
      Object.assign(data, this.broadcast)
      data.status = status
      await update(id, data)
      this.$message.success(this.$t('crud.send-success'))
      this.$router.push('/broadcast/index')
    },
    async actionApprove(status) {
      await this.$confirm(this.$t('message.confirmation-send-message') + `${this.broadcast.title}` + '?', this.$t('message.title'), {
        confirmButtonText: this.$t('common.confirm'),
        cancelButtonText: this.$t('common.cancel'),
        type: 'success'
      })

      try {
        this.submitForm(status)
      } catch (e) {
        console.log(e)
      }
    },
    checkStatus(status, status_label) {
      if (status === this.status.SCHEDULED) {
        return `<span class="el-tag el-tag--warning el-tag--medium">` + status_label + `</span>`
      } else if (status === this.status.PUBLISHED) {
        return `<span class="el-tag el-tag--success el-tag--medium">` + status_label + `</span>`
      } else {
        return `<span class="el-tag el-tag--info el-tag--medium">` + status_label + `</span>`
      }
    },
    checkDate(response) {
      const { scheduled_datetime, is_scheduled, status } = response
      const now = moment()
      const dateTime = moment.unix(scheduled_datetime).isBefore(now)
      if (is_scheduled && status === this.status.DRAFT) {
        if (dateTime) {
          this.$message.warning(this.$t('errors.broadcast-datetime-edit'))
          this.btnKirimDisable = true
        } else {
          this.btnKirimDisable = false
        }
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.button-send {
  margin-top: 30px;
  display: block;
}

@media only screen and (max-width: 1200px) {
  .col-right {
    margin-top: 20px;
    margin-bottom: 20px;
  }
  .html-div {
    color: blue !important;
  }
}
</style>
