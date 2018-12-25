/*
|-------------------------------------------------------------------------------
| VUEX modules/auth.js
|-------------------------------------------------------------------------------
| The Vuex data store for user
*/

import userAPI from '../services/api/user.js';

export const user = {

   /*
    Defines the state being monitored for the module.
  */
state: {
  userStatus: 0,
  userData : '',
  editProfileStatus: 0,
  editProfileMessage: '',
  updateAvatarStatus: 0,
  updateAvatarMessage: '',
  removeSkillStatus: 0,
  removeSkillMessage: '',
  removeExperienceStatus: 0,
  removeExperienceMessage: '',
  removeAccomplishmentStatus: 0,
  removeAccomplishmentMessage: '',
},

/*
Defines the actions used to retrieve the data.
*/
actions: {

/*
  Adds a post
*/
getUser( { commit, state, dispatch } ){
  commit( 'setUserStatus', 1 );

  userAPI.getProfile()
      .then( function( response ){
        commit( 'setUserStatus', 2 );
        commit( 'setUserData', response.data);
      })
      .catch( function( error ){
        commit( 'setUserStatus', 3 );
        commit( 'setUserData', error.response.data.message );
      });
},

editProfile( { commit, state, dispatch }, data ){
  commit( 'setEditProfileStatus', 1 );

  userAPI.editProfile( data.profileData, data.experienceData, data.skillData, data.accomplishmentData )
      .then( function( response ){
        commit( 'setEditProfileStatus', 2 );
        commit( 'setEditProfileMessage', response.data.message);
        dispatch('getUser')
      })
      .catch( function( error ){
        commit( 'setEditProfileStatus', 3 );
        commit( 'setEditProfileMessage', error.response.data.message );
      });
},

removeSkill( { commit, state, dispatch }, data ){
  commit( 'setRemoveSkillStatus', 1 );

  userAPI.removeSkill( data.key )
      .then( function( response ){
        commit( 'setRemoveSkillStatus', 2 );
        commit( 'setRemoveSkillMessage', response.data.message);
        dispatch('getUser')
      })
      .catch( function( error ){
        commit( 'setRemoveSkillStatus', 3 );
        commit( 'setRemoveSkillMessage', error.response.data.message );
      });
},

removeExperience( { commit, state, dispatch }, data ){
  commit( 'setRemoveExperienceStatus', 1 );

  userAPI.removeExperience( data.key )
      .then( function( response ){
        commit( 'setRemoveExperienceStatus', 2 );
        commit( 'setRemoveExperienceMessage', response.data.message);
        dispatch('getUser')
      })
      .catch( function( error ){
        commit( 'setRemoveExperienceStatus', 3 );
        commit( 'setRemoveExperienceMessage', error.response.data.message );
      });
},

removeAccomplishment( { commit, state, dispatch }, data ){
  commit( 'setRemoveAccomplishmentStatus', 1 );

  userAPI.removeAccomplishment( data.key )
      .then( function( response ){
        commit( 'setRemoveAccomplishmentStatus', 2 );
        commit( 'setRemoveAccomplishmentMessage', response.data.message);
        dispatch('getUser')
      })
      .catch( function( error ){
        commit( 'setRemoveAccomplishmentStatus', 3 );
        commit( 'setRemoveAccomplishmentMessage', error.response.data.message );
      });
},

updateAvatar ({ commit, state, dispatch }, data ){
  commit( 'setUpdateAvatarStatus', 1 );

  userAPI.updateAvatar( data.formData )
      .then( function( response ){
        commit( 'setUpdateAvatarStatus', 2 );
        commit( 'setUpdateAvatarMessage', response.data.message);
        dispatch('getUser');
      })
      .catch( function( error ){
        commit( 'setUpdateAvatarStatus', 3 );
        commit( 'setUpdateAvatarMessage', error.response.data.message );
      });
},


},

/*
Defines the mutations used
*/
mutations: {
/*
  Set the cafe add status
*/
setUserStatus( state, status ){
  state.userStatus = status;
},

setUserData( state, data ){
  state.userData = data;
},

setEditProfileStatus( state, status ){
  state.editProfileStatus = status;
},

setEditProfileMessage( state, message ){
  state.editProfileMessage = message;
},

setRemoveSkillStatus( state, status ){
  state.removeSkillStatus = status;
},

setRemoveSkillMessage( state, message ){
  state.removeSkillMessage = message;
},

setRemoveExperienceStatus( state, status ){
  state.removeExperienceStatus = status;
},

setRemoveExperienceMessage( state, message ){
  state.removeExperienceMessage = message;
},

setRemoveAccomplishmentStatus( state, status ){
  state.removeAccomplishmentStatus = status;
},

setRemoveAccomplishmentMessage( state, message ){
  state.removeAccomplishmentMessage = message;
},

setUpdateAvatarStatus( state, status ){
  state.updateAvatarStatus = status;
},

setUpdateAvatarMessage( state, message ){
  state.updateAvatarMessage = message;
},
},

/*
  Defines the getters used by the module
*/
  getters: {
  /*
    Returns the posts load status.
  */
  getUserStatus( state ){
    return state.userStatus;
  },

  getUserData( state ){
    return state.userData;
  },

  getEditProfileStatus( state ){
    return state.editProfileStatus;
  },

  getEditProfileMessage( state ){
    return state.editProfileMessage;
  },

  getRemoveSkillStatus( state ){
    return state.removeSkillStatus;
  },

  getRemoveSkillMessage( state ){
    return state.removeSkillMessage;
  },

  getRemoveExperienceStatus( state ){
    return state.removeExperienceStatus;
  },

  getRemoveExperienceMessage( state ){
    return state.removeExperienceMessage;
  },

  getRemoveAccomplishmentStatus( state ){
    return state.removeAccomplishmentStatus;
  },

  getRemoveAccomplishmentMessage( state ){
    return state.removeAccomplishmentMessage;
  },

  getUpdateAvatarStatus( state ){
    return state.updateAvatarStatus;
  },

  getUpdateAvatarMessage( state ){
    return state.updateAvatarMessage;
  },
  }
}
