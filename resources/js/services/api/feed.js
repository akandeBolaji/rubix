
export default {
    postLike: function( postID ){
        return axios.post( '/api/posts/' + postID + '/like' );
      },

      deleteLike: function( postID ){
        return axios.delete( '/api/posts/' + postID + '/like' );
      },

  addNewPost ( formData) {
    const config = {
      headers: {'content-type': 'multipart/form-data'}
    }
    return axios.post('/api/posts', formData, config)
    },

  getPosts () {
    return axios.get('/api/posts')
  },

  getPost (id) {
    return axios.get('/api/post' + id)
    .then(response => {
      //do anything
      return response.data
    })
  },

  createPost ( payload ) {
    return axios.post('/api/posts', payload)
    .then(response => {
      //do anything
      return response.data
    })
  }
}
