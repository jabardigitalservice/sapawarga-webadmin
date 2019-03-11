export default class Errors {
  constructor () {
    this.errors = {}
  }

  getAll () {
    return this.errors
  }

  any () {
    return Object.keys(this.getAll()).length > 0
  }

  set (field, message) { /* eslint-disable-line */
    //
  }

  has (field) {
    return typeof this.errors[field] !== 'undefined'
  }

  get (field) {
    if (this.has(field)) {
      return this.errors[field][0]
    }
  }

  clear (field) {
    if (!field) {
      this.errors = {}
      return this
    }
  }

  record (errors) {
    this.errors = errors

    return this
  }
}
