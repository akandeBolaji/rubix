import networkAPI from '../services/api/network.js';

export const networks = {

   /*
    Defines the state being monitored for the module.
  */
state: {
  connects: [],
  connectsLoadStatus: 0,
},

/*
Defines the actions used to retrieve the data.
*/
actions: {

/*
  Adds a post
*/

getConnect( { commit} ){
    commit( 'setConnectsLoadStatus', 1 );

    networkAPI.getConnect()
      .then( function( response ){
        commit( 'setConnects', response.data );
        commit( 'setConnectsLoadStatus', 2 );
      })
      .catch( function(){
        commit( 'setConnectsLoadStatus', 3 );
      });
  },
},

/*
Defines the mutations used
*/
mutations: {
    setConnects( state, data ){
        state.connects = data;
      },

      /*
        Set the post load status
      */
      setConnectsLoadStatus( state, status ){
        state.connectsLoadStatus = status;
      },
  },

/*
  Defines the getters used by the module
*/
  getters: {
  /*
    Returns the posts load status.
  */

  getConnects( state ){
    return state.connects;
  },

  /*
    Returns a post load status
  */
  getConnectsLoadStatus( state ){
    return state.connectsLoadStatus;
  },
  }
}
