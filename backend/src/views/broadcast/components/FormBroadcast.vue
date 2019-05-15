<template>
  <div class="components-container">
    <el-row :gutter="20">
      <el-col :sm="24" :md="10" :lg="10" :xl="12">
        <p class="warn-content">Target</p>
        <div class="broadcast-target">
          <!-- <el-form
            :model="broadcast"
            ref="broadcast"
            :rules="rules"
            label-width="150px"
            label-position="left"
          >
            <el-form-item label="Kab/Kota" :prop="kabkota">
              <el-select v-model="broadcast.kabkota" placeholder="Pilih Kab/Kota">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Kecamatan" :prop="kecamatan">
              <el-select v-model="broadcast.kecamatan" placeholder="Pilih Kecamatan">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Kelurahan" :prop="kelurahan">
              <el-select v-model="broadcast.kelurahan" placeholder="Pilih Kelurahan">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="RW" :prop="rw">
              <el-select v-model="broadcast.rw" placeholder="Pilih RW">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </el-form> -->
        </div>
      </el-col>
      <el-col :sm="24" :md="14" :lg="14" :xl="12">
        <p class="warn-content">Isi Pesan</p>
        <div class="broadcast-message">
          <el-form
            ref="broadcast"
            :model="broadcast"
            :rules="rules"
            label-width="150px"
            label-position="left"
          >
            <el-form-item label="Judul Pesan">
              <el-input v-model="broadcast.title" type="text" />
            </el-form-item>
            <el-form-item label="Kategori" prop="category">
              <InputCategory v-model="broadcast.category_id" category-type="broadcast" />
            </el-form-item>
            <el-form-item label="Isi Pesan" prop="message">
              <el-input
                v-model="broadcast.description"
                type="textarea"
                :rows="8"
                placeholder="Please input"
              />
            </el-form-item>
            <el-form-item>
              <el-button type="info" :loading="loading" @click="submitForm(status.draft)">{{ $t('crud.draft') }}</el-button>
              <el-button type="primary" :loading="loading" @click="submitForm(status.active)"> {{ $t('crud.send') }}</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import InputCategory from '@/components/InputCategory'
// import InputSelectArea from '@/components/InputSelectArea'
import { create } from '@/api/broadcast'
export default {
  components: {
    InputCategory
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      loading: false,
      status: {
        draft: 0,
        active: 10
      },
      options: [
        {
          value: 'Option1',
          label: 'Option1'
        }, {
          value: 'Option2',
          label: 'Option2'
        }, {
          value: 'Option3',
          label: 'Option3'
        }, {
          value: 'Option4',
          label: 'Option4'
        }, {
          value: 'Option5',
          label: 'Option5'
        }
      ],
      broadcast: {
        kabkota: '',
        kecamatan: '',
        kelurahan: '',
        rw: '',
        title: '',
        category_id: '',
        description: ''
      },
      rules: {

      }
    }
  },
  methods: {
    async submitForm(status) {
      // Fill with validation

      try {
        this.loading = true
        const data = {}

        Object.assign(data, this.broadcast)

        data.status = status

        if (this.isEdit) {
          console.log('edit')
        } else {
          await create(data)
          if (status === 10) {
            this.$message.success(this.$t('crud.send-success'))
            this.$router.push('/broadcast/index')
          } else if (status === 0) {
            this.$message.info(this.$t('crud.draft-success'))
            this.$router.push('/broadcast/index')
          }
        }
      } catch (error) {
        console.log(error.response)
      } finally {
        this.loading = false
      }
    }
  }

}
</script>
<style lang="scss" scoped>
.broadcast-target, .broadcast-message {
  margin: 20px;
}

</style>
