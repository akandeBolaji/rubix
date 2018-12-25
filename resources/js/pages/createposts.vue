<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      fixed
      temporary
      height="400px"
    >

      <v-list class="pt-0" dense>
            <v-list-tile @click="dashboard">
          <v-list-tile-action>
            <v-icon color="blue">dashboard</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Dashboard</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile @click="logout">
          <v-list-tile-action>
            <v-icon color="red">logout</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Logout</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
        <v-toolbar>
         <v-toolbar-title class="blue--text">Rubix</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-toolbar-side-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
         <div class="hidden-sm-and-down">
         <v-btn @click="dashboard" class="white--text" color="blue" >Go to Dashboard</v-btn>
         <v-btn @click="logout" class="white--text" color="blue" >Logout</v-btn>
        </div>
       </v-toolbar>
        <v-container fluid>
        <v-layout>
          <v-flex xs12>
            <v-card class="elevation-12">
              <v-toolbar dark color="blue">
                <v-toolbar-title>Create a Post</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
              <v-textarea v-if="videos == null && files == null || videos == 0 && files == 0" prepend-icon="info"  v-model="text" name="text" label="Start typing here" type="text"></v-textarea>
              <v-textarea v-else prepend-icon="info"  v-model="text" name="text" label="Add a caption" type="text"></v-textarea>
              <v-card v-show=false>
              <input type="file" id="files" accept="image/*" multiple ref="files" @change="handleFileUpload()"/>
              </v-card>
              </v-form>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
        </v-container>

        <v-container grid-list-md v-if="listVideo">
            <v-layout row wrap>
                <v-flex>
                <v-card v-if="videos != 0 && videos != null">
                    <v-card-text><b>Uploaded Clips</b></v-card-text>
                    <v-list dense v-for="(video, key) in videos" v-bind:key='video.name'>
                    <v-list-tile class="grey lighten-3">
                    <v-list-tile-content>Name:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ video.name }}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                    <v-list-tile-content>Size:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ video.size }} bytes</v-list-tile-content>
                    </v-list-tile>
                    <v-btn @click="removeClip( key )" class="white--text" color="blue">Remove Clip</v-btn>
                   </v-list>
                </v-card>
                </v-flex>
            </v-layout>
        </v-container>

             <v-container
          fluid
          grid-list-md
        >
        <v-layout row wrap>
            <v-flex
              v-for="(file, key) in files"
              :key="file.name"
            >
            <v-btn @click="removeFile( key )">Delete <v-icon color="red">cancel</v-icon></v-btn>
            <v-card>
                <img :ref="'image'+parseInt( key )" height="300px" width="300px"/>
           </v-card>

          </v-flex>
        </v-layout>
       </v-container>

      <v-container fluid>
        <v-layout>
          <v-flex xs12>
          <v-card>
               <v-card-actions>
              <v-btn @click="addFiles()" class="black--text" outline color="blue"><v-icon>image</v-icon>Add image</v-btn>
              <v-spacer></v-spacer>
              <upload-btn
                title="Add Clip"
                :fileChangedCallback="fileChanged"
                accept="video/*"
                :flat = true
                color = 'blue'
                :outline = true
                :uniqueId = true
                >
                <template slot="icon">
                    <v-icon left>videocam</v-icon>
                </template>
                </upload-btn>
              </v-card-actions>
              <v-container fluid fill-height align-center justify-center>
              <v-btn large type="submit" class="white--text align-center" @click="submitFile()" :disabled="dialog" :loading="dialog" color="blue">Submit Post</v-btn>
              </v-container>
       </v-card>
          </v-flex>
        </v-layout>
      </v-container>

        <v-footer height="auto" color="blue">
           <v-layout
      justify-center
      row
      wrap
    >
           <v-flex
        grey
        lighten-2
        py-3
        text-xs-center
        blue--text
        xs12
      >
        &copy;2018 — <strong>Rubix</strong>
      </v-flex>
      </v-layout>
      </v-footer>

      <v-dialog
      v-model="dialog"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="blue"
        dark
      >
        <v-card-text>
          Please wait...
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="info"
      max-width="290"
    >
     <v-card>
        <v-card-title class="headline">{{this.infotext}}</v-card-title>
        <div>
        <v-spacer></v-spacer>
        <v-btn color="blue" @click="info = false">OK</v-btn>
        </div>
     </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
import UploadButton from 'vuetify-upload-button';
export default {
    components: {
      'upload-btn': UploadButton
    },
  data() {
   return {
      drawer: null,
      disable: false,
      listVideo: false,
      dialog: false,
      info: false,
      infotext: '',
     gaugeValue: 0,
     noImage: true,
     files: [],
     videos: [],
     text: ''
   }
  },

  computed: {
     postAddStatus(){
       return this.$store.getters.getPostAddStatus;
     },
      logoutLoadStatus(){
       return this.$store.getters.getLogoutLoadStatus;
     }
   },

   watch: {
        'logoutLoadStatus': function(){
         if(this.logoutLoadStatus == 2){
           this.dialog = false;
           this.$router.push("/login");
         }
         else if (this.logoutLoadStatus == 3){
           this.dialog = false;
            if (this.$store.getters.getLogoutMessage) {
           this.infotext = this.$store.getters.getLogoutMessage
           this.info = true;
           }
           else {
             this.infotext = 'An error Occured. Please check your network';
             this.info = true;
           };
         }
         else if (this.logoutLoadStatus == 1){
           this.dialog = true;
         }
       },
       'postAddStatus': function(){
         if(this.postAddStatus == 2){
           //this.$f7router.navigate("/hometab/");
            this.infotext = this.$store.getters.getPostAddMessage;
           this.info = true;
           //this.$router.push("/dashboard");
         }
          else if (this.postAddStatus == 3){
           this.dialog = false;
            if (this.$store.getters.getPostAddMessage) {
           this.infotext = this.$store.getters.getPostAddMessage;
           this.info = true;
           }
           else {
             this.infotext = 'An error Occured. Please check your network';
             this.info = true;
           };
         }
         else if (this.postAddStatus == 1){
           this.dialog = true;
         }
       },

   },

  methods: {
      fileChanged (file) {
           let uploadedVideo = file;
      //Adds the uploaded files to tht file array
      for ( var i = 0; i < uploadedVideo.length; i++ ) {
        this.videos.push( uploadedVideo[i] );
      }
      this.listVideo = true;
      //this.noImage = false ;
        // handle file here. File will be an object.
        // If multiple prop is true, it will return an object array of files.
      },
      dashboard() {
          this.dialog = true;
          this.$router.push('/dashboard');
        },
        logout() {
          this.$store.dispatch( 'logoutUser');
        },
    //adds a file
    addFiles() {
     this.$refs.files.click();
    },
    //handles uploading of
    handleFileUpload() {
      //get uploaded files from input
      let uploadedFiles = this.$refs.files.files;
      //Adds the uploaded files to tht file array
      for ( var i = 0; i < uploadedFiles.length; i++ ) {
        this.files.push( uploadedFiles[i] );
      }
      //generate image previews for the uploaded files
      this.getImagePreviews();
    },
    //gets the image preview for the file
    getImagePreviews() {
      //iterate over all of the file and generate an image preview for each
     for( let i = 0; i < this.files.length; i++) {
       //ensure the file is an image file
       if ( /\.(jpe?g|png|gif)$/i.test( this.files[i].name )) {
         //create a new FileReader object
        let reader = new FileReader();
        //Add an event listener for when the file has been loaded to update the src on the file preview
        reader.addEventListener("load", function(){
          this.$refs['image'+parseInt( i )][0].src = reader.result;
        }.bind(this), false);
        //read the data for the file in through the reader
        reader.readAsDataURL( this.files[i] );
        //show the preview text
        this.noImage = false ;
       }
     }
    },
    removeFile( key ){
     this.files.splice( key, 1);
    },
    removeClip( key ){
     this.videos.splice( key, 1);
    },
    submitFile() {
      //initialize the form data
      let formData = new FormData();
      formData.append('text', this.text);
      //itirate over any file sent over appending the files to the form data
      for ( var i = 0; i < this.files.length; i++){
        let file = this.files[i];
        formData.append('files[' + i + ']', file);
      };
      for ( var i = 0; i < this.videos.length; i++){
        let video = this.videos[i];
        formData.append('videos[' + i + ']', video);
      };
      //makes a post request to the server
      this.$store.dispatch( 'addPost',
       {
         formData
       }
  );
    }
  }
}
</script>
