# Table `Advanced`

The styling wrapper on the [Bootstrap-Vue b-table](https://bootstrap-vue.js.org/docs/components/table) component.

<!-- STORY -->

### Usage

```html
<div class="card">
  <div class="card-body">
    <div class="e-advanced-table">
      <div class="d-flex mb-3">
        <div class="mr-3" style="flex-grow: 1">
          <form class="form-inline">
            <div class="input-with-ico w-100">
              <i class="input-ico fa fa-fw fa-search"></i>
              <div class="input-group flex-nowrap w-100">
                <input class="form-control w-100" type="search" v-model="filters.search" placeholder="Search" aria-label="Search">
                <span v-if="filters.search.length" class="input-group-append">
                  <button class="btn btn-secondary" type="button" @click="clearSearch()">
                    <i class="fa fa-times"></i>
                  </button>
                </span>
              </div>
            </div>
          </form>
        </div>
        <div class="">
          <b-dropdown variant="success" split right>
            <template slot="button-content">
              <span>
                <i class="fa fa-plus"></i>
                <span class="d-none d-md-inline-block ml-1">Create</span>
              </span>
            </template>
            <h6 class="dropdown-header">With selected:</h6>
            <a class="dropdown-item" href="#" @click.prevent>Remove</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Toggle:</h6>
            <a class="dropdown-item" href="#" @click.prevent>Status</a>
            <a class="dropdown-item" href="#" @click.prevent>Bookmark</a>
          </b-dropdown>
        </div>
      </div>
      <div class="row flex-lg-nowrap">
        <div class="col">
          <e-navlist active-bold>
            <ul class="nav">
              <li class="nav-item" :class="{ active: tab == 'all' }">
                <a href="" class="nav-link" @click.prevent="tab = 'all'">
                  <span>All</span>
                  <small>/ {{ all.length }}</small>
                </a>
              </li>
              <li class="nav-item" :class="{ active: tab == 'bookmarks' }">
                <a href="" class="nav-link" @click.prevent="tab = 'bookmarks'">
                  <span>Bookmarks</span>
                  <small>/ {{ bookmarks.length }}</small>
                </a>
              </li>
              <li class="nav-item" :class="{ active: tab == 'selected' }">
                <a href="" class="nav-link" @click.prevent="tab = 'selected'">
                  <span>Selected</span>
                  <small>/ {{ selected.length }}</small>
                </a>
              </li>
            </ul>
          </e-navlist>
          <hr class="mb-3">
          <div class="px-2">
            <label class="custom-control custom-checkbox m-0">
              <input type="checkbox" class="custom-control-input" id="actives-check" v-model="filters.actives">
              <span class="custom-control-label" for="actives-check">Actives Only</span>
            </label>
          </div>
          <hr class="my-3 d-md-none">
        </div>
        <div class="col-12 col-md-9">
          <b-table class="table-rounded fa-sort-icons mb-0"
            :items="display"
            :fields="fields"
            :per-page="perPage"
            :current-page="currentPage"
            show-empty
            responsive
            bordered>
            <template slot="HEAD_check" slot-scope="data">
              <div @click.stop class="custom-control custom-control-nameless custom-checkbox m-0 align-top">
                <input type="checkbox" class="custom-control-input" v-model="selectedAll" :id="'item-'+data.key">
                <label class="custom-control-label" :for="'item-'+data.key"></label>
              </div>
            </template>
            <template slot="check" slot-scope="data">
              <div class="custom-control custom-control-nameless custom-checkbox m-0 align-top">
                <input type="checkbox" class="custom-control-input" @click.stop :value="data.item" v-model="selectedItems" :id="'item-'+data.index">
                <label class="custom-control-label" :for="'item-'+data.index"></label>
              </div>
            </template>
            <template slot="date" slot-scope="data">
              <span>{{ data.item.date | moment('DD MMM YYYY') }}</span>
            </template>
            <template slot="status" slot-scope="data">
              <span class="badge" :class="data.value ? 'badge-light' : 'badge-secondary'">{{ data.value }}</span>
            </template>
            <template slot="bookmark" slot-scope="data">
              <span class="e-advanced-table__bookmark" :class="{ active: data.item.bookmark }">
                <i class="fa fa-bookmark fa-fw" @click.stop="data.item.bookmark = !data.item.bookmark"></i>
              </span>
            </template>
          </b-table>
          <b-pagination v-if="display.length > perPage" class="pagination-separated m-0 mt-3" size="sm" align="center" :total-rows="display.length" :per-page="perPage" v-model="currentPage" />
        </div>
      </div>
    </div>
  </div>
</div>
```
```js
import ENavlist from 'elements/navlist'
import search from 'modules/search-array'

const items = [
  { name: 'Adam Cotter',       date: 1512792908, status: true,  bookmark: true  },
  { name: 'Pauline Noble',     date: 1516977768, status: false, bookmark: true  },
  { name: 'Sherilyn Metzel',   date: 1517042476, status: true,  bookmark: false },
  { name: 'Terrie Boaler',     date: 1516439865, status: true,  bookmark: false },
  { name: 'Rutter Pude',       date: 1515850922, status: false, bookmark: false },
  { name: 'Clifford Benjamin', date: 1516898701, status: true,  bookmark: false },
  { name: 'Thedric Romans',    date: 1515707885, status: false, bookmark: false },
  { name: 'Haily Carthew',     date: 1517056707, status: true,  bookmark: true  },
  { name: 'Dorothea Joicey',   date: 1513090469, status: true,  bookmark: false },
  { name: 'Mikaela Pinel',     date: 1512892304, status: false, bookmark: false },
  { name: 'Donnell Farries',   date: 1512299369, status: true,  bookmark: false },
  { name: 'Letizia Puncher',   date: 1512769349, status: false, bookmark: false },
  { name: 'Kania Yallowley',   date: 1515521487, status: true,  bookmark: false },
  { name: 'Clay De Francesco', date: 1515012234, status: false, bookmark: true  },
  { name: 'Ina Queree',        date: 1514458367, status: false, bookmark: false },
  { name: 'Rasia Awty',        date: 1516943842, status: false, bookmark: false },
  { name: 'Basil Crosham',     date: 1512108299, status: true,  bookmark: false },
  { name: 'Alexis Dodworth',   date: 1516814115, status: false, bookmark: true  },
  { name: 'Greg Onyon',        date: 1517071308, status: true,  bookmark: false },
  { name: 'Barry Carbett',     date: 1515450742, status: true,  bookmark: false },
  { name: 'Carlyle Adran',     date: 1512498261, status: true,  bookmark: false },
  { name: 'Guillaume Petel',   date: 1512742913, status: false, bookmark: true  },
  { name: 'Wendeline Glasner', date: 1513319267, status: false, bookmark: false },
  { name: 'Sylvia Petrollo',   date: 1516080489, status: false, bookmark: false },
  { name: 'Meade Quoit',       date: 1513972299, status: true,  bookmark: true  },
  { name: 'Eugine Planke',     date: 1515488407, status: false, bookmark: false },
  { name: 'Thoma Drakeley',    date: 1515023660, status: false, bookmark: false },
  { name: 'Web Margetson',     date: 1513557231, status: true,  bookmark: false },
  { name: 'Erskine Stivens',   date: 1515233788, status: true,  bookmark: true  },
  { name: 'Jedidiah Emmer',    date: 1512614842, status: false, bookmark: false },
  { name: 'Wolfie Drakers',    date: 1512381522, status: false, bookmark: false },
  { name: 'Allie Quiney',      date: 1515488202, status: true,  bookmark: false }
]

const fields = [
  { key: 'check' },
  { key: 'name', sortable: true, thClass: 'max-width', tdClass: 'text-nowrap' },
  { key: 'date', sortable: true, tdClass: 'text-nowrap' },
  { key: 'status', tdClass: 'text-center align-middle' },
  { key: 'bookmark', label: ' ', tdClass: 'align-middle' },
]

export default {
  components: { ENavlist },
  data: function() {
    return {
      items,
      fields,
      currentPage: 1,
      perPage: 5,
      tab: 'all',
      filters: {
        search: '',
        actives: false,
      },
      selectedItems: [],
      test: true
    }
  },
  computed: {
    all: function() {
      let items = this.items;

      if (this.filters.search) {
        items = search(this.items, this.filters.search)
      }

      if (this.filters.actives) {
        items = items.filter(i => i.status)
      }

      return items
    },
    bookmarks: function() {
      return this.all.filter(i => i.bookmark)
    },
    selected: function() {
      return this.all.filter(i => this.selectedItems.indexOf(i) > -1)
    },
    selectedAll: {
      get: function() {
        return this.display.length && this.display.every(i => this.selected.indexOf(i) > -1)
      },
      set: function(value) {
        if (value) {
          this.selectedItems = [...this.display]
        } else {
          this.selectedItems = this.selectedItems.filter(i => this.display.indexOf(i) < 0)
        }
      }
    },
    display: function() {
      return this[this.tab] || []
    }
  },
  methods: {
    clearSearch: function() {
      this.filters.search = ''
    }
  }
}
```

### Props and Slots
For the complete table configuration notes, please, refer to the original [Bootstrap-Vue b-table](https://bootstrap-vue.js.org/docs/components/table) documentation.

### See Also
- [Bootstrap-Vue b-table](https://bootstrap-vue.js.org/docs/components/table)
