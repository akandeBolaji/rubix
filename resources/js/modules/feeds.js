/*
|-------------------------------------------------------------------------------
| VUEX modules/feeds.js
|-------------------------------------------------------------------------------
| The Vuex data store for the feeds
*/

import feedAPI from '../services/api/feed.js';

export const feeds = {

   /*
    Defines the state being monitored for the module.
  */
state: {
  posts: [],
  postsLoadStatus: 0,

  post: {},
  postLoadStatus: 0,

  postAddStatus: 0,
  postAddMessage: '',

  postLikeStatus: 0,
  postUnlikeStatus: 0,
  postUnliked: '',
  postLiked: '',
},

/*
Defines the actions used to retrieve the data.
*/
actions: {

/*
  Adds a post
*/
likePost( { commit, state }, data ){
    commit( 'setPostLikeStatus', 1 );

    feedAPI.postLike( data.id )
      .then( function( response ){
        commit( 'setPostLiked', response.data.message );
        commit( 'setPostLikeStatus', 2 );
      })
      .catch( function(){
        commit( 'setPostLikeStatus', 3 );
      });
  },

  /*
    Unlikes a cafe
  */
  unlikePost( { commit, state }, data ){
    commit( 'setPostUnlikeStatus', 1 );

    feedAPI.deleteLike( data.id )
      .then( function( response ){
        commit( 'setPostUnliked', response.data.message );
        commit( 'setPostUnlikeStatus', 2 );
      })
      .catch( function(){
        commit( 'setPostUnlikeStatus', 3 );
      });
  },

addPost( { commit, state, dispatch }, data ){
  commit( 'setPostAddedStatus', 1 );

  feedAPI.addNewPost( data.formData )
      .then( function( response ){
        commit( 'setPostAddedStatus', 2 );
        commit('setPostAddedMessage', response.data.message);
        //dispatch('getUser');
        dispatch( 'loadPosts' );
      })
      .catch( function(error){
        commit( 'setPostAddedStatus', 3 );
        commit('setPostAddedMessage', error.response.data.message);
      });
},
/*
Loads the posts from the API
*/
loadPosts( { commit } ){
  commit( 'setPostsLoadStatus', 1 );

  feedAPI.getPosts()
    .then( function( response ){
      commit( 'setPosts', response.data );
      commit( 'setPostsLoadStatus', 2 );
    })
    .catch( function(){
      commit( 'setPostsLoadStatus', 3 );
    });
},

/*
  Loads an individual cafe from the API
*/
loadPost( { commit }, data ){
  commit( 'setPostLoadStatus', 1 );

  feedAPI.getPost( data.id )
    .then( function( response ){
      commit( 'setPost', response.data );
      commit( 'setPostLoadStatus', 2 );
    })
    .catch( function(){
      commit( 'setPost', {} );
      commit( 'setPostLoadStatus', 3 );
    });
  }
},

/*
Defines the mutations used
*/
mutations: {
/*
  Set the cafe add status
*/
setPostLiked( state, message ){
    state.postLiked = message;
  },

  setPostUnliked( state, message ){
    state.postUnliked = message;
  },

  /*
    Set the cafe like action status
  */
  setPostLikeStatus( state, status ){
    state.postLikeStatus = status;
  },

  /*
    Set the cafe unlike action status
  */
  setPostUnlikeStatus( state, status ){
    state.postUnlikeStatus = status;
  },

setPostAddedStatus( state, status ){
  state.postAddStatus = status;
},

setPostAddedMessage( state, message){
  state.postAddMessage = message;
},

/*
  Sets the posts load status
*/
setPostsLoadStatus( state, status ){
  state.postsLoadStatus = status;
},

/*
  Sets the posts
*/
setPosts( state, posts ){
  state.posts = posts;
},

/*
  Set the post load status
*/
setPostLoadStatus( state, status ){
  state.postLoadStatus = status;
},
/*
      Set the post
    */
   setPost( state, post ){
    state.post = post;
  }
  },

/*
  Defines the getters used by the module
*/
  getters: {
  /*
    Returns the posts load status.
  */
 getPostLiked( state ){
    return state.postLiked;
  },

  getPostUnliked( state ){
    return state.postUnliked;
  },

  /*
    Gets the cafe liked action status
  */
  getPostLikeStatus( state ){
    return state.postLikeStatus;
  },

  /*
    Gets the cafe un-like action status
  */
  getPostUnlikeStatus( state ){
    return state.postUnlikeStatus;
  },
  getPostsLoadStatus( state ){
    return state.postsLoadStatus;
  },

  getPostAddStatus( state ){
    return state.postAddStatus;
  },

  getPostAddMessage( state ){
    return state.postAddMessage;
  },

  /*
    Returns the posts.
  */
  getPosts( state ){
    return state.posts;
  },

  /*
    Returns a post load status
  */
  getPostLoadStatus( state ){
    return state.postLoadStatus;
  },

  /*
    Returns a post
  */
  getPost( state ){
    return state.post;
  }
  }
}
