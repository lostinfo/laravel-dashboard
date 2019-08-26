// v-if、v-show 与 v-permission 冲突
// v-if="you_condition && checkPermission('you_permission')"
// v-permission="'you_permission'"
import store from '../store'

export default function (permission) {
  if (!store.state.admin) {
    return false
  }
  if (!permission || store.state.admin.is_supper_admin || store.state.admin.permissions.indexOf(permission) >= 0) {
    return true
  }
  return false
}