export default {
  login (data) {
    return axios.post('/api/auth/login', data)
  },

  logout () {
    return axios.post('/api/auth/logout')
  },

  register (data) {
    return axios.post('/api/auth/register', data)
  },

  activate (data) {
    return axios.get('/api/auth/activate/'+ data)
  },

  check () {
    return axios.post('/api/auth/check')
  },

  resetPass (data) {
    return axios.post('/api/auth/password', data)
  },

  getReferrer (data) {
    return axios.post('/api/auth/get-referrer', { referrer_id: data })
  },

  confirmResetPass (data) {
    return axios.post('/api/auth/validate-password-reset', { token: data})
  },

  changePass (data) {
    return axios.post('/api/auth/reset', data)
  },

  logOut ( payload ) {
    return axios.post('/api/posts', payload)
    .then(response => {
      //do anything
      return response.data
    })
  }
}
