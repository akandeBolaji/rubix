/*
|-------------------------------------------------------------------------------
| VUEX modules/auth.js
|-------------------------------------------------------------------------------
| The Vuex data store for   Auth
*/

import authAPI from '../services/api/auth.js';

export const auth = {

   /*
    Defines the state being monitored for the module.
  */
state: {
  loginLoadStatus: 0,
  logoutLoadStatus: 0,
  checkStatus:0,
  activateLoadStatus:0,
  activateMessage: '',
  checkMessage: '',
  loginMessage : '',
  logoutMessage : '',
  registerLoadStatus: 0,
  registerMessage : '',
  referrerLoadStatus: 0,
  referrerMessage : '',
  resetPassStatus: 0,
  resetMessage : '',
  confirmResetPassStatus: 0,
  confirmResetMessage : '',
  changePassStatus: 0,
  changePassMessage : '',
  token : ''
},

/*
Defines the actions used to retrieve the data.
*/
actions: {

/*
  Adds a post
*/
loginUser( { commit, state, dispatch }, data ){
  commit( 'setLoginLoadStatus', 1 );

  authAPI.login( data.loginData )
      .then( function( response ){
        commit( 'setLoginLoadStatus', 2 );
        commit( 'setLoginMessage', response.data.message );
        commit( 'setToken', response.data.token );
      })
      .catch( function( error ){
        commit( 'setLoginLoadStatus', 3 );
        commit( 'setLoginMessage', error.response.data.message );
      });
},

activateUser( { commit, state, dispatch }, data ){
    commit( 'setActivateLoadStatus', 1 );

    authAPI.activate( data.activateData )
        .then( function( response ){
          commit( 'setActivateLoadStatus', 2 );
          commit( 'setActivateMessage', response.data.message );
        })
        .catch( function( error ){
          commit( 'setActivateLoadStatus', 3 );
          commit( 'setActivateMessage', error.response.data.message );
        });
  },

logoutUser( { commit, state, dispatch }, data ){
    commit( 'setLogoutLoadStatus', 1 );

    authAPI.logout()
        .then( function( response ){
          commit( 'setLogoutLoadStatus', 2 );
          commit( 'setLogoutMessage', response.data.message );
        })
        .catch( function( error ){
          commit( 'setLogoutLoadStatus', 3 );
          commit( 'setLogoutMessage', error.response.data.message );
        });
  },

check( { commit, state, dispatch } ){
  commit( 'setCheckStatus', 1 );

  authAPI.check()
      .then( function( response ){
        commit( 'setCheckStatus', 2 );
        commit( 'setCheckMessage', response.data.authenticated );
      })
      .catch( function( error ){
        commit( 'setCheckStatus', 3 );
        //commit( 'setCheckMessage', error.data.authenticated );
      });
},

registerUser( { commit, state, dispatch }, data ){
  commit( 'setRegisterLoadStatus', 1 );

  authAPI.register( data.registerData )
      .then( function( response ){
        commit( 'setRegisterLoadStatus', 2 );
        commit( 'setRegisterMessage', response.data.message );
      })
      .catch( function( error ){
        commit( 'setRegisterLoadStatus', 3 );
        commit( 'setRegisterMessage', error.response.data.message );
      });
},

getReferrer( { commit, state, dispatch }, data ){
    commit( 'setReferrerLoadStatus', 1 );

    authAPI.getReferrer( data.referrer_id )
        .then( function( response ){
          commit( 'setReferrerLoadStatus', 2 );
          commit( 'setReferrerMessage', response.data.message );
        })
        .catch( function( error ){
          commit( 'setReferrerLoadStatus', 3 );
          commit( 'setReferrerMessage', error.response.data.message );
        });
  },

resetPass( { commit, state, dispatch }, data ){
  commit( 'setResetPassStatus', 1 );

  authAPI.resetPass( data.resetData )
      .then( function( response ){
        commit( 'setResetPassStatus', 2 );
        commit( 'setResetMessage', response.data.message );
      })
      .catch( function( error ){
        commit( 'setResetPassStatus', 3 );
        commit( 'setResetMessage', error.response.data.message );
      });
},

confirmResetPass( { commit, state, dispatch }, data ){
    commit( 'setConfirmResetPassStatus', 1 );

    authAPI.confirmResetPass( data.confirmResetData )
        .then( function( response ){
          commit( 'setConfirmResetPassStatus', 2 );
          commit( 'setConfirmResetMessage', response.data.message );
        })
        .catch( function( error ){
          commit( 'setConfirmResetPassStatus', 3 );
          commit( 'setConfirmResetMessage', error.response.data.message );
        });
  },

  changePass( { commit, state, dispatch }, data ){
    commit( 'setChangePassStatus', 1 );

    authAPI.changePass( data.passData )
        .then( function( response ){
          commit( 'setChangePassStatus', 2 );
          commit( 'setChangePassMessage', response.data.message );
        })
        .catch( function( error ){
          commit( 'setChangePassStatus', 3 );
          commit( 'setChangePassMessage', error.response.data.message );
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
setLoginLoadStatus( state, status ){
  state.loginLoadStatus = status;
},

setLoginMessage( state, message ){
  state.loginMessage = message;
},

setActivateLoadStatus( state, status ){
    state.activateLoadStatus = status;
  },

setActivateMessage( state, message ){
    state.activateMessage = message;
  },

setLogoutLoadStatus( state, status ){
    state.logoutLoadStatus = status;
  },

setLogoutMessage( state, message ){
    state.logoutMessage = message;
  },

setCheckStatus( state, status ){
  state.checkStatus = status;
},

setCheckMessage( state, message ){
  state.checkMessage = message;
},

setResetPassStatus( state, status ){
  state.resetPassStatus = status;
},

setResetMessage( state, message ){
  state.resetMessage = message;
},

setConfirmResetPassStatus( state, status ){
    state.confirmResetPassStatus = status;
  },

setConfirmResetMessage( state, message ){
    state.confirmResetMessage = message;
  },

setChangePassStatus( state, status ){
        state.changePassStatus = status;
      },

setChangePassMessage( state, message ){
        state.changePassMessage = message;
      },

setRegisterLoadStatus( state, status ){
  state.registerLoadStatus = status;
},

setRegisterMessage( state, message ){
  state.registerMessage = message;
},

setReferrerLoadStatus( state, status ){
    state.referrerLoadStatus = status;
  },

setReferrerMessage( state, message ){
    state.referrerMessage = message;
  },

setToken( state, token ){
  state.token = token;
},
},

/*
  Defines the getters used by the module
*/
  getters: {
  /*
    Returns the posts load status.
  */
  getLoginLoadStatus( state ){
    return state.loginLoadStatus;
  },

  getLoginMessage( state ){
    return state.loginMessage;
  },

  getActivateLoadStatus( state ){
    return state.activateLoadStatus;
  },

  getActivateMessage( state ){
    return state.activateMessage;
  },

  getLogoutLoadStatus( state ){
    return state.logoutLoadStatus;
  },

  getLogoutMessage( state ){
    return state.logoutMessage;
  },

  getCheckStatus( state ){
    return state.checkStatus;
  },

  getCheckMessage( state ){
    return state.checkMessage;
  },

  getResetPassStatus( state ){
    return state.resetPassStatus;
  },

  getResetMessage( state ){
    return state.resetMessage;
  },

  getConfirmResetPassStatus( state ){
    return state.confirmResetPassStatus;
  },

  getConfirmResetMessage( state ){
    return state.confirmResetMessage;
  },

  getChangePassStatus( state ){
    return state.changePassStatus;
  },

  getChangePassMessage( state ){
    return state.changePassMessage;
  },

  getRegisterLoadStatus( state ){
    return state.registerLoadStatus;
  },

  getRegisterMessage( state ){
    return state.registerMessage;
  },

  getReferrerLoadStatus( state ){
    return state.referrerLoadStatus;
  },

  getReferrerMessage( state ){
    return state.referrerMessage;
  },

  getToken( state ){
    return state.token;
  },
  }
}
