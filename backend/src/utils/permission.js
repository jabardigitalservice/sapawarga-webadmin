import store from '@/store'
import { RolesUser } from '@/utils/constantVariabel'
import router from '@/router'

/**
 * @param {Array} value
 * @returns {Boolean}
 * @example see @/views/permission/directive.vue
 */
export default function checkPermission(value) {
  if (value && value instanceof Array && value.length > 0) {
    const roles = store.getters && store.getters.roles
    const permissionRoles = value

    const hasPermission = roles.some(role => {
      return permissionRoles.includes(role)
    })

    if (!hasPermission) {
      return false
    }
    return true
  } else {
    console.error(`need roles! Like v-permission="['admin','editor']"`)
    return false
  }
}

function isUserTrainerPublic(rolesUser, role_detail) {
  if (![RolesUser.ADMIN, RolesUser.STAFFPROV].includes(rolesUser) &&
  role_detail === RolesUser.TRAINER || role_detail === RolesUser.PUBLIK) {
    router.push('/403')
  } else {
    return true
  }
}

export function isUserKabKota(id_kabkota, role_detail) {
  const kabKotaUser = store.getters.user ? store.getters.user.kabkota_id : null
  const rolesUser = store.getters.roles ? store.getters.roles[0] : null
  if ([RolesUser.ADMIN, RolesUser.STAFFPROV].includes(rolesUser)) {
    return true
  } else if (kabKotaUser === id_kabkota) {
    isUserTrainerPublic(rolesUser, role_detail)
  } else {
    router.push('/403')
  }
}
