<template>
  <div>
    <el-card v-for="(data, index) in list" :key="index" class="box-card-qna">
      <router-link :to="'/question-answer/messages/'+data.id">
        <div class="header-box-qna">
          <img src="@/assets/notifications.svg">
          <span class="sender-name"> {{ data.user.name }}</span>
          <div class="card-qna-likes">
            <span class="total-likes-qna">{{ data.likes_count }}</span>
            <img src="@/assets/grey-like.svg">
          </div>
        </div>
        <div class="card-qna-content">
          <span>{{ data.text }}</span>
        </div>
      </router-link>
    </el-card>
  </div>
</template>

<script>

export default {
  props: {
    list: {
      type: Array,
      default: null
    },
    title: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      listLoading: false
    }
  }
}
</script>
<style lang="scss" scoped>
.box-card-qna {
  background: rgba(2, 147, 78, 0.15);
  border-radius: 10px;
  font-size: 13px;

  .header-box-qna {

    .sender-name {
      position: absolute;
      text-align: center;
      padding-left: 10px;
      color: rgb(0, 0, 0);
      font-weight: 600;
    }

    .card-qna-likes {
      float: right;
      .total-likes-qna {
        height: 25px;
        color: #3F3F3F;
      }
    }

  }
  .card-qna-content {
    font-size: 15px;
    padding-top: 10px;
    color: black;
  }

}
</style>
