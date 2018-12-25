export default {
  getProfile () {
    return axios.get('/api/auth/user')
  },

  editProfile (profileData, experienceData, skillData, accomplishmentData) {
    return axios.post('/api/user/update-profile', {
      profileData,
      experienceData,
      skillData,
      accomplishmentData
    })
  },

  removeSkill ( key ) {
    return axios.post('/api/user/remove-skill/' + key )
  },

  removeExperience ( key ) {
    return axios.post('/api/user/remove-experience/' + key )
  },

  removeAccomplishment ( key ) {
    return axios.post('/api/user/remove-accomplishment/' + key )
  },

  updateAvatar ( formData ) {
    const config = {
      headers: {'content-type': 'multipart/form-data'}
    }
    return axios.post('/api/user/update-avatar', formData, config  )
  },



  getNotifications (id) {
    return axios.get('/api/post' + id)
    .then(response => {
      //do anything
      return response.data
    })
  },

  getConnects ( payload ) {
    return axios.post('/api/posts', payload)
    .then(response => {
      //do anything
      return response.data
    })
  }
}
