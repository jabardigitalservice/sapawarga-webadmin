<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card>
          <div slot="header" class="clearfix">
            <span>{{ $t('label.banner-data') }}</span>
          </div>
          <el-table stripe :data="tableDataBanner" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content">
              <template slot-scope="{row}">
                <a v-if="validUrl(row.content)" :href="row.content" target="_blank" class="link">{{ row.content }}</a>
                <span v-else>{{ row.content }}</span>
              </template>
            </el-table-column>
          </el-table>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { PopupFeature, PopupCategory } from '@/utils/constantVariable'
import { fetchRecord } from '@/api/banner'
import { validUrl } from '@/utils/validate'
export default {
  data() {
    return {
      tableDataBanner: [],
      banner: null
    }
  },
  mounted() {
    this.id = this.$route.params && this.$route.params.id
    this.getDetail()
  },
  methods: {
    getDetail() {
      fetchRecord(this.id).then(response => {
        const { title, status_label, link_url, internal_category, internal_entity_name, type } = response.data
        this.banner = response.data

        this.tableDataBanner = [
          {
            title: this.$t('label.banner-title'),
            content: title || '-'
          },
          {
            title: this.$t('label.category'),
            content: type || '-'
          },
          {
            title: this.$t('label.banner-feature'),
            content: internal_category === PopupFeature.NEWS_IMPORTANT ? this.$t('label.banner-newsImportant') : internal_category === PopupFeature.NEWS ? this.$t('label.banner-news') : internal_category
          },
          {
            title: this.$t('label.banner-feature-title'),
            content: internal_entity_name || '-'
          },
          {
            title: this.$t('label.status'),
            content: status_label || '-'
          },
          {
            title: this.$t('label.banner-url'),
            content: link_url || '-'
          }
        ]

        if (type === PopupCategory.INTERNAL) {
          this.tableDataBanner.pop()
        } else if (type === PopupCategory.EXTERNAL) {
          this.tableDataBanner.splice(2, 2)
        }
      })
    },

    validUrl(str) {
      return !!validUrl(str)
    }
  }
}
</script>

<style>
.link {
  color: blue;
  text-decoration: underline;
}
</style>
