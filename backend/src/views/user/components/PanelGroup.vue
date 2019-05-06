<template>
  <el-row :gutter="40" class="panel-group">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>Total user per:</span>
      </div>
      <div style="margin-bottom:50px;">
        <el-col v-if="(roleId == null && totalAllUser != null)" :xs="12" :sm="12" :lg="6" class="card-panel-col total-all">
          <div class="card-panel">
            <div class="card-panel-icon-wrapper icon-people-all">
              <svg-icon icon-class="peoples" class-name="card-panel-icon" />
            </div>
            <div class="card-panel-description">
              <div class="card-panel-text">
                Semua
              </div>
              <count-to :start-val="0" :end-val="totalAllUser" :duration="duration" class="card-panel-num" />
            </div>
          </div>
        </el-col>
        <el-col v-if="(roleId == null && totalUserProvince != null) || (roleId == 'staffProv') && (totalUserProvince != null)" :xs="12" :sm="12" :lg="6" class="card-panel-col total-province">
          <div class="card-panel">
            <div class="card-panel-icon-wrapper icon-people-province">
              <svg-icon icon-class="peoples" class-name="card-panel-icon" />
            </div>
            <div class="card-panel-description">
              <div class="card-panel-text">
                Provinsi
              </div>
              <count-to :start-val="0" :end-val="totalUserProvince" :duration="duration" class="card-panel-num" />
            </div>
          </div>
        </el-col>
        <el-col v-if="(roleId == null && totalUserKabKota != null) || (roleId == 'staffProv') || (roleId == 'staffKabkota')" :xs="12" :sm="12" :lg="6" class="card-panel-col total-kota">
          <div class="card-panel">
            <div class="card-panel-icon-wrapper icon-people-kota">
              <svg-icon icon-class="peoples" class-name="card-panel-icon" />
            </div>
            <div class="card-panel-description">
              <div class="card-panel-text">
                Kota/Kab
              </div>
              <count-to :start-val="0" :end-val="totalUserKabKota" :duration="duration" class="card-panel-num" />
            </div>
          </div>
        </el-col>
        <el-col v-if="(roleId == null && totalUserKec != null) || (roleId == 'staffProv') || (roleId == 'staffKabkota') || (roleId == 'staffKec')" :xs="12" :sm="12" :lg="6" class="card-panel-col total-kec">
          <div class="card-panel">
            <div class="card-panel-icon-wrapper icon-people-kec">
              <svg-icon icon-class="peoples" class-name="card-panel-icon" />
            </div>
            <div class="card-panel-description">
              <div class="card-panel-text">
                Kecamatan
              </div>
              <count-to :start-val="0" :end-val="totalUserKec" :duration="duration" class="card-panel-num" />
            </div>
          </div>
        </el-col>
        <el-col v-if="(roleId == null && totalUserKel != null) || (roleId == 'staffProv') || (roleId == 'staffKabkota') || (roleId == 'staffKec') || (roleId == 'staffKel')" :xs="12" :sm="12" :lg="6" class="card-panel-col total-kel">
          <div class="card-panel">
            <div class="card-panel-icon-wrapper icon-people-kel">
              <svg-icon icon-class="peoples" class-name="card-panel-icon" />
            </div>
            <div class="card-panel-description">
              <div class="card-panel-text">
                Kelurahan
              </div>
              <count-to :start-val="0" :end-val="totalUserKel" :duration="duration" class="card-panel-num" />
            </div>
          </div>
        </el-col>
        <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col total-rw">
          <div class="card-panel">
            <div class="card-panel-icon-wrapper icon-people-rw">
              <svg-icon icon-class="peoples" class-name="card-panel-icon" />
            </div>
            <div class="card-panel-description">
              <div class="card-panel-text">
                RW
              </div>
              <count-to :start-val="0" :end-val="totalUserRw" :duration="duration" class="card-panel-num" />
            </div>
          </div>
        </el-col>
        <!-- <el-col :xs="12" :sm="12" :lg="6">
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>Total Pengguna</span>
            </div>
            <div class="component-item">
              <count-to :start-val="0" :end-val="totalAllUser" :duration="duration" class="" />
            </div>
          </el-card>
        </el-col> -->
      </div>
    </el-card>
  </el-row>
</template>

<script>
import CountTo from 'vue-count-to'

export default {
  name: 'PanelGroupUser',
  components: {
    CountTo
  },
  props: {
    roleId: {
      type: String,
      default: null
    },
    totalAllUser: {
      type: Number,
      default: 0
    },
    totalUserProvince: {
      type: Number,
      default: 0
    },
    totalUserKabKota: {
      type: Number,
      default: 0
    },
    totalUserKec: {
      type: Number,
      default: 0
    },
    totalUserKel: {
      type: Number,
      default: 0
    },
    totalUserRw: {
      type: Number,
      default: 0
    },
    duration: {
      type: Number,
      default: 2600
    }
  }
}
</script>

<style lang="scss" scoped>
.panel-group {
  margin-top: 18px;
  .card-panel-col{
    margin-bottom: 32px;
  }
  .card-panel {
    height: 108px;
    cursor: pointer;
    font-size: 12px;
    position: relative;
    overflow: hidden;
    color: #666;
    background: #fff;
    box-shadow: 4px 4px 40px rgba(0, 0, 0, .05);
    border-color: rgba(0, 0, 0, .05);
    &:hover {
      .card-panel-icon-wrapper {
        color: #fff;
      }
      .icon-people-all {
         background: #40c9c6;
      }
      .icon-people-province {
         background: #4048c9;
      }
      .icon-people-kota {
         background: #c94096;
      }
      .icon-people-kec {
         background: #6cc940;
      }
      .icon-people-kel {
         background: #c8da49;
      }
      .icon-people-rw {
         background: #dabd49;
      }
      .icon-people-rt {
         background: #76888e;
      }
      .icon-message {
        background: #36a3f7;
      }
      .icon-money {
        background: #f4516c;
      }
      .icon-shopping {
        background: #34bfa3
      }
    }
    .icon-people-all {
      color: #40c9c6;
    }
    .icon-people-province {
      color: #4048c9;
    }
    .icon-people-kota {
      color: #c94096;
    }
    .icon-people-kec {
      color: #6cc940;
    }
    .icon-people-kel {
      color: #c8da49;
    }
    .icon-people-rw {
      color: #dabd49;
    }
    .icon-people-rt {
      color: #76888e;
    }
    .icon-message {
      color: #36a3f7;
    }
    .icon-money {
      color: #f4516c;
    }
    .icon-shopping {
      color: #34bfa3
    }
    .card-panel-icon-wrapper {
      float: left;
      margin: 14px 0 0 14px;
      padding: 16px;
      transition: all 0.38s ease-out;
      border-radius: 6px;
    }
    .card-panel-icon {
      float: left;
      font-size: 48px;
    }
    .card-panel-description {
      float: right;
      font-weight: bold;
      margin: 26px;
      margin-left: 0px;
      .card-panel-text {
        line-height: 18px;
        color: rgba(0, 0, 0, 0.45);
        font-size: 16px;
        margin-bottom: 12px;
      }
      .card-panel-num {
        font-size: 20px;
      }
    }
  }
}
</style>
