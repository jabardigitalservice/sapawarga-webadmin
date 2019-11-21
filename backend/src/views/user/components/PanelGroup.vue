<template>
  <div class="app-container">
    <el-row :gutter="40" class="panel-group">
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>{{ $t('label.count-user-each-role') }}:</span>
        </div>
        <div style="margin-bottom:50px;">
          <el-col
            v-if="(pages == rolesWidget.ALL)"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-all"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-all">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-all-user') }}
                </div>
                <count-to :start-val="0" :end-val="totalAllUser" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
          <el-col
            v-if="(rolesWidget[RolesUser.STAFFPROV].includes(roleId) && (pages != rolesWidget.ALL || roleId != RolesUser.STAFFPROV))"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-province"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-province">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-province') }}
                </div>
                <count-to :start-val="0" :end-val="totalUserProvince" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
          <el-col
            v-if="(rolesWidget[RolesUser.STAFFKABKOTA].includes(roleId) && (pages != rolesWidget.ALL || roleId != RolesUser.STAFFKABKOTA))"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-kota"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-kota">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-kabkota') }}
                </div>
                <count-to :start-val="0" :end-val="totalUserKabKota" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
          <el-col
            v-if="(rolesWidget[RolesUser.STAFFKEC].includes(roleId) && (pages != rolesWidget.ALL || roleId != RolesUser.STAFFKEC))"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-kec"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-kec">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-kecamatan') }}
                </div>
                <count-to :start-val="0" :end-val="totalUserKec" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
          <el-col
            v-if="(rolesWidget[RolesUser.STAFFKEL].includes(roleId) && (pages != rolesWidget.ALL || roleId != RolesUser.STAFFKEL))"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-kel"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-kel">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-kelurahan') }}
                </div>
                <count-to :start-val="0" :end-val="totalUserKel" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
          <el-col
            v-if="(rolesWidget[RolesUser.STAFFRW].includes(roleId))"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-rw"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-rw">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-rw') }}
                </div>
                <count-to :start-val="0" :end-val="totalUserRw" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
          <el-col
            v-if="(rolesWidget[RolesUser.STAFFSABERHOAX].includes(roleId))"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-saber-hoax"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-saber-hoax">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-saber-hoax') }}
                </div>
                <count-to :start-val="0" :end-val="totalUserSaberHoax" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
          <el-col
            v-if="(rolesWidget[RolesUser.TRAINER].includes(roleId))"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-trainer"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-trainer">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-trainer') }}
                </div>
                <count-to :start-val="0" :end-val="totalUserTrainer" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
          <el-col
            v-if="(rolesWidget[RolesUser.PUBLIK].includes(roleId))"
            :xs="12"
            :sm="12"
            :lg="6"
            class="card-panel-col total-user"
          >
            <div class="card-panel">
              <div class="card-panel-icon-wrapper icon-people-user">
                <svg-icon icon-class="peoples" class-name="card-panel-icon" />
              </div>
              <div class="card-panel-description">
                <div class="card-panel-text">
                  {{ $t('label.widget-user') }}
                </div>
                <count-to :start-val="0" :end-val="totalUserPublik" :duration="duration" class="card-panel-num" />
              </div>
            </div>
          </el-col>
        </div>
      </el-card>
    </el-row>
  </div>
</template>

<script>
import CountTo from 'vue-count-to'
import { RolesUser, rolesWidget } from '@/utils/constantVariabel'

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
    pages: {
      type: String,
      default: null
    },
    duration: {
      type: Number,
      default: 2600
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
    totalUserTrainer: {
      type: Number,
      default: 0
    },
    totalUserSaberHoax: {
      type: Number,
      default: 0
    },
    totalUserPublik: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      RolesUser,
      rolesWidget
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
    .icon-people-trainer {
      color: #7a4880;
    }
    .icon-people-user {
      color: #4eaaff;
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
      margin: 20px;
      margin-left: 0px;
      .card-panel-text {
        line-height: 18px;
        color: rgba(0, 0, 0, 0.45);
        font-size: 16px;
        margin-bottom: 12px;
      }
      .card-panel-text-jsh {
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
