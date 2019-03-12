<template>
  <layout-default>
    <div class="row flex-lg-nowrap">
      <div class="col">
        <e-panel title="Articles">
          <b-table class="fa-sort-icons table-rounded mt-3 mb-0"
                   :items="items"
                   :fields="fields"
                   :busy="loading"
                   responsive
                   bordered
                   show-empty>
            <template slot="action" slot-scope="data">
              <div class="btn-group align-top">
                <router-link :to="`articles/${data.item.id}`" class="btn btn-sm btn-outline-secondary badge">Edit</router-link>

                <button
                        class="btn btn-sm btn-outline-secondary badge"
                        type="button"
                        @click="remove(data.item.id)">
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </template>

            <template slot="empty">
              <div v-if="loading" class="text-center">
                Loading...
              </div>
              <div v-else class="text-center">
                No rows to display!
              </div>
            </template>
          </b-table>
        </e-panel>
      </div>

      <div class="col-12 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="text-center px-xl-3">
              <router-link class="btn btn-success btn-block" to="/articles/create">New Article</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout-default>
</template>

<script>
import articlesService from '@/services/articles.service'

import LayoutDefault from '@/pages/layouts/Default'
import EPanel from '@/lib/components/panel'

const fields = [
  { key: 'id', label: 'ID', thClass: 'text-center', tdClass: 'text-center' },
  { key: 'brand', tdClass: 'text-nowrap' },
  { key: 'model', thClass: 'max-width', tdClass: 'text-nowrap', sortable: true },
  { key: 'action', tdClass: 'text-center align-middle' }
]

export default {
  components: {
    LayoutDefault,
    EPanel
  },

  data () {
    return {
      loading: false,
      fields: fields,
      items: []
    }
  },

  created () {
    this.fetchData()
  },

  watch: {
    '$route': 'fetchData'
  },

  methods: {
    fetchData () {
      this.loading = true

      return articlesService.getList().then(response => {
        this.items = response.data
      }).catch(error => alert(error))
        .finally(() => this.loading = false)
    },

    remove (id) {
      return articlesService.remove(id)
        .then(() => this.fetchData())
        .catch(error => alert(error))
    }
  }
}
</script>
