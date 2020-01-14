<template>
  <div>
    <el-row v-loading="isLoading" :gutter="20">
      <el-col style="background-color: #f2f2f3;position: relative;pointer-events: auto;">
        <nav style="padding: 0 15px;">
          <FilterQuestions
            @changeNameInput="listQuery.search = $event"
            @changeKabKota="listQuery.kabkota_id = $event"
          />
        </nav>
        <div id="style-questions-list" class="questions-list">

          <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="1">
            <div
              v-for="question in data"
              :key="question.id"
              @click.stop.prevent="onSelectQuestions(question)"
            >
              <el-col>
                <el-card shadow="always">
                  <div class="questions-containers">
                    <el-row :key="question.user.name">
                      <el-col :lg="2" :sm="2" :xs="2">
                        <div>
                          <div class="img-container">
                            <img :src="(question.user.photo_url_full) ? question.user.photo_url_full: require('@/assets/user.png')" alt="" class="avatar">&nbsp;
                          </div>
                        </div>
                      </el-col>
                      <el-col :lg="12" :sm="12" :xs="12">
                        <div class="questions-details" style="margin-top: 16px;">
                          <div class="name-detail">
                            <span class="user-name">{{ question.user.name }}</span>
                            <div class="img-like">
                              <span class="el-tag el-tag--info el-tag--medium" style="height: 25px;background-color: transparent;">{{ question.likes_count }} Likes</span>
                              <div class="moderasi-switch" @click.stop.prevent="moderationUpdate(question)">
                                <el-tooltip content="Moderasi" placement="top">
                                  <el-switch
                                    v-model="question.is_flagged"
                                    :active-value="1"
                                    :inactive-value="0"
                                    active-color="#ff4949"
                                    inactive-color="#13ce66"
                                  />
                                </el-tooltip>
                              </div>
                            </div>
                          </div>
                          <div class="last-messages">
                            <span class="date-last-message">{{ parsingDatetime(question.created_at, 'DD/MM/YYYY') }}</span>
                          </div>
                          <div class="last-messages">
                            <span class="message">{{ question.text }}</span>
                          </div>
                        </div>
                      </el-col>
                    </el-row>
                  </div>
                </el-card>
              </el-col>
            </div>
          </div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import FilterQuestions from './filterQuestions'
import { fetchListQuestions, updateModeration } from '@/api/questionsAnswer'
import router from '@/router'
import { parsingDatetime } from '@/utils/datetimeToString'

export default {
  components: {
    FilterQuestions
  },
  props: {
    loading: {
      type: Boolean,
      required: false
    }
  },
  data() {
    return {
      data: [],
      value: false,
      busy: false,
      isLoading: false,
      listQuery: {
        page: 1,
        search: null,
        kabkota_id: null,
        limit: 10
      }
    }
  },
  watch: {
    async 'listQuery.search'() {
      const response = await fetchListQuestions(this.listQuery)
      this.data = []
      this.data.push(...response.data.items)
    },
    async 'listQuery.kabkota_id'() {
      const response = await fetchListQuestions(this.listQuery)
      this.data = []
      this.data.push(...response.data.items)
    }
  },
  methods: {
    parsingDatetime,
    onSelectQuestions(question) {
      router.push(`/question-answer/messages/${question.id}`)
    },
    async loadMore() {
      const response = await fetchListQuestions(this.listQuery)
      this.data.push(...response.data.items)
      if (this.listQuery.page >= response.data._meta.pageCount) {
        this.busy = true
      } else {
        this.listQuery.page++
        this.busy = false
      }
    },
    async moderationUpdate(data) {
      const response = await updateModeration(data.id, { 'is_flagged': data.is_flagged ? 1 : 0 })
      if (response.success) {
        data.is_flagged = data.is_flagged ? 1 : 0
      }
    }
  }
}
</script>
