<template>
  <div>
    <el-col :lg="23" :sm="23" :xs="23" style="background-color: #f2f2f3;position: relative;left: 45px;pointer-events: auto;">
      <nav style="padding: 0 15px;">
        <div class="nav-left-section" style="margin-top: 10px;">
          <FilterUser
            :props-name="listQuery.name"
            :props-kab-kota="listQuery.kabkota_id"
            @changeNameInput="listQuery.name = $event"
            @changeKabKota="listQuery.kabkota_id = $event"
          />
        </div>
      </nav>
      <div id="style-user-list" class="user-list">

        <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="1">
          <div
            v-for="user in data"
            :key="user.id"
            class="users-containers"
            @click="onSelectUser(user)"
          >
            <div class="users-details">
              <div class="img-container">
                <img src="@/assets/user.png" alt="" class="avatar">&nbsp;
              </div>
            </div>
            <div class="users-details" style="margin-top: 16px;">
              <div class="name-detail">
                <span class="user-name">{{ user.name }}</span>
                <span class="date-last-message">25/11/2019</span>
              </div>
              <div class="last-messages">
                <span class="message">isi pesan yang panjang aja boleh kok</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </el-col>
  </div>
</template>

<script>
import FilterUser from './filterUser'
import { fetchListUser } from '@/api/questionsAnswer'

export default {
  components: {
    FilterUser
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
    onSelectUser: function(user) {
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
