/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
import mutations from '../mutation-types.json'
export default {
  /**
   * Set authorization data
   *
   * @param   {object}  state
   * @param   {object}  userData
   */
  [mutations.Login.AUTH_USER](state, userData) {
    state.tokenId = userData.tokenId
    state.userId = userData.userId
    state.userName = userData.userName
    state.admin = userData.admin
  },

  /**
   * Clear authorization data
   *
   * @param   {object}  state
   */
  [mutations.Login.CLEAR_AUTH_DATA](state) {
    state.tokenId = null
    state.userId = null
    state.userName = null
    state.admin = null
  }
}