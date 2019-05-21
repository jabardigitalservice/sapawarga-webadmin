<template>
  <div class="app-container">
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="9" :xl="9">
        <el-card style="margin-bottom: 10px">
          <div slot="header" class="clearfix">
            <span>Target</span>
          </div>
        </el-card>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="15" :xl="15">
        <el-card>
          <div slot="header" class="clearfix">
            <el-row>
              <el-col :span="20">
                <span class="aspiration-title">{{ title }}</span>
              </el-col>
              <el-col :span="4">
                <span class="aspiration-date"> {{ created_at | moment('D MMMM YYYY') }} </span>
              </el-col>
            </el-row>
          </div>
          <el-table stripe :data="author" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-card style="margin-top: 10px">
          <el-table stripe :data="aspirationDetail" :show-header="false" style="width: 100%">
            <el-table-column prop="title" width="180" />
            <el-table-column prop="content" />
          </el-table>
        </el-card>
        <el-button v-if="status" class="button-send" type="primary">{{ $t('crud.accept') }}</el-button>
        <el-button v-if="status" class="button-send" type="info">{{ $t('crud.reject') }}</el-button>
      </el-col>
    </el-row>
  </div>
</template>
