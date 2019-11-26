<template>
  <div>
    <el-col :lg="23" :sm="23" :xs="23" style="background-color: #f2f2f3;position: relative;left: 36px;">
      <nav>
        <div class="nav-left-section">
          <span class="welcome-message"><b>List Pengguna</b> </span>&nbsp;
        </div>
      </nav>
      <div class="user-list">
        <ul>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
          <li><i class="el-icon-message"></i>User 1</li>
        </ul>
      </div>
    </el-col>
  </div>
</template>

<script>
export default {
  props: {
    listUser: {
      type: Array,
      required: false
    },
    loading: {
      type: Boolean,
      required: false
    }
  },
  created() {
    console.log(this.listUser);
  },
}
</script>
