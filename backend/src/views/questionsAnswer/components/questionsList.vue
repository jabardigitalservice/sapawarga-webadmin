<template>
  <div>
    <el-row :gutter="20">
      <el-col style="background-color: #f2f2f3;position: relative;pointer-events: auto;">
        <nav style="padding: 0 15px;">
          <FilterQuestions
            @changeNameInput="listQuery.name = $event"
            @changeKabKota="listQuery.kabkota_id = $event"
          />
        </nav>
        <div id="style-user-list" class="user-list">

          <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="1">
            <div
              v-for="question in data"
              :key="question.id"
              @click="onSelectQuestions(question)"
            >
              <el-col>
                <el-card shadow="always">
                  <div class="questions-containers">
                    <el-row :key="question.user_name">
                      <el-col :lg="2" :sm="2" :xs="2">
                        <div>
                          <div class="img-container">
                            <img src="@/assets/user.png" alt="" class="avatar">&nbsp;
                          </div>
                        </div>
                      </el-col>
                      <el-col :lg="12" :sm="12" :xs="12">
                        <div class="questions-details" style="margin-top: 16px;">
                          <div class="name-detail">
                            <span class="user-name">{{ question.user_name }}</span>
                            <div class="img-like">
                              <span class="el-tag el-tag--primary el-tag--medium" style="height: 25px;">{{ question.likes_count }}</span>
                              <img src="@/assets/like.svg" alt="" class="like-icon">
                            </div>
                          </div>
                          <div class="last-messages">
                            <span class="date-last-message">{{ formatDatetime(question.created_date, 'DD/MM/YYYY') }}</span>
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
import { fetchListQuestions } from '@/api/questionsAnswer'
import router from '@/router'
import { formatDatetime } from '@/utils/datetimeToString'

export default {
  components: {
    FilterQuestions
  },
  props: {
    listUser: {
      type: Array,
      required: false,
      default: function() { return [] }
    },
    loading: {
      type: Boolean,
      required: false
    }
  },
  data() {
    return {
      data: [],
      busy: false,
      listQuery: {
        page: 0,
        name: null,
        kabkota_id: null,
        limit: 10
      }
    }
  },
  watch: {
    async 'listQuery.name'() {
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
    onSelectQuestions(question) {
      router.push(`/question-answer/messages/${question.id}`)
    },
    async loadMore() {
      this.busy = true
      const response = await fetchListQuestions(this.listQuery)
      this.data.push(...response.data.items)
      if (response.data.items.length < 10) {
        this.busy = true
      } else {
        this.listQuery.page++
        this.busy = false
      }
    },
    formatDatetime
  }
}
</script>
