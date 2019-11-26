<template>
  <div>
    <el-col :lg="23" :sm="23" :xs="23" style="background-color: #f2f2f3;position: relative;left: 45px;pointer-events: auto;">
      <nav style="padding: 0 15px;">
        <div class="nav-left-section" style="margin-top: 10px;">
          <FilterUser />
        </div>
      </nav>
      <div class="user-list">
        <div v-for="user in listUser" :key="user.id" class="users-containers">
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
    </el-col>
  </div>
</template>

<script>
import FilterUser from './filterUser'
export default {
  components: {
    FilterUser
  },
  props: {
    listUser: {
      type: Array,
      required: true
    },
    loading: {
      type: Boolean,
      required: false
    }
  }
}
</script>
