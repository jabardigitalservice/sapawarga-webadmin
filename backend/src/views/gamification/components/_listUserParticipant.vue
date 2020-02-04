<template>
  <el-table
    :data="listParticipant"
    style="width: 100%"
  >
    <el-table-column
      type="index"
      width="50"
      align="center"
      :index="getTableRowNumbering"
    />
    <el-table-column
      prop="name"
      label="Nama"
      width="180"
    />
    <el-table-column
      prop="address"
      label="Kedudukan"
    />
    <el-table-column
      prop="task"
      label="Task"
      width="180"
    />
    <el-table-column
      prop="date"
      label="Tanggal Bergabung"
      width="180"
    />
  </el-table>
</template>

<script>
export default {
  name: 'UserParticipant',
  props: {
    listParticipant: {
      type: Array,
      default: null,
      require: true
    }
  },
  methods: {
    getTableRowNumbering(index) {
      return (index + 1)
    }
  }
}
</script>
