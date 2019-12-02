<template>
  <div>
    <el-col :lg="23" :sm="23" :xs="23" style="background-color: #f2f2f3;position: relative;left: 45px;pointer-events: auto;">
      <nav style="padding: 0 15px;">
        <FilterQuestions
          :props-name="listQuery.name"
          :props-kab-kota="listQuery.kabkota_id"
          @changeNameInput="listQuery.name = $event"
          @changeKabKota="listQuery.kabkota_id = $event"
        />
      </nav>
      <div id="style-user-list" class="user-list">

        <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="1">
          <div
            v-for="user in data"
            :key="user.id"
            class="users-containers"
            @click="onSelectQuestions(user)"
          >
            <el-col>
              <el-card shadow="always">
                {{ user.name }}
              </el-card>
            </el-col>
          </div>
        </div>
      </div>
    </el-col>
  </div>
</template>

<script>
import FilterQuestions from './filterQuestions'
import { fetchListUser } from '@/api/questionsAnswer'

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
      const response = await fetchListUser(this.listQuery)
      this.data = []
      this.data.push(...response.data.items)
    },
    async 'listQuery.kabkota_id'() {
      const response = await fetchListUser(this.listQuery)
      this.data = []
      this.data.push(...response.data.items)
    }
  },
  methods: {
    onSelectQuestions: function(user) {
      console.log(user.name)
    },
    async loadMore() {
      this.busy = true
      this.listQuery.page++
      const response = await fetchListUser(this.listQuery)
      this.data.push(...response.data.items)
      this.busy = false
    }
  }
}
</script>
