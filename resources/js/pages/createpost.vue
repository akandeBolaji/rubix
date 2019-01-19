<template>
  <v-app id="inspire">
    <v-toolbar fixed color="blue lighten-1">
        <v-icon @click="goBack" dark>arrow_back</v-icon>
        <v-toolbar-title class="white--text" >Create Post</v-toolbar-title>
    </v-toolbar>
        <v-container mt-5 fluid>
        <v-layout>
          <v-flex xs12>
            <v-card class="elevation-12">
              <v-card-text>
                <v-form>
              <v-textarea v-validate="'required'" outline box auto-grow rows="1" v-if="videos == null && files == null || videos == 0 && files == 0"  v-model="text" name="text" label="Start typing here" type="text"></v-textarea>
              <v-textarea v-validate="'required'" outline box auto-grow rows="1" v-else v-model="text" name="text" label="Add a caption" type="text"></v-textarea>
              <v-card v-show=false>
              <input type="file" id="files" accept="image/*" multiple ref="files" @change="handleFileUpload()"/>
              </v-card>
              </v-form>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
        </v-container>

         <v-container
         v-if="!listVideo"
             mb-5
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

        <v-container v-if="listVideo" mb-5>
            <v-layout row wrap>
                <v-flex>
                <v-card v-if="videos != null">
                    <v-card-text><b>Uploaded Clip</b></v-card-text>
                    <v-list dense>
                    <v-list-tile class="grey lighten-3">
                    <v-list-tile-content>Name:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ videos.name }}</v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile>
                    <v-list-tile-content>Size:</v-list-tile-content>
                    <v-list-tile-content class="align-end">{{ videos.size }} bytes</v-list-tile-content>
                    </v-list-tile>
                    <v-btn @click="removeClip" class="white--text" color="blue">Remove Clip</v-btn>
                   </v-list>
                </v-card>
                </v-flex>
            </v-layout>
        </v-container>

         <v-footer fixed color="white">
            <v-layout>
          <v-flex xs3 v-if="imagedialog">
              <v-container fluid fill-height align-center justify-center>
                  <v-btn @click="addFiles()" flat outline color="blue">
              <v-icon color="black darken-3">image</v-icon>
                  </v-btn>
              </v-container>
          </v-flex>
          <v-flex xs3 v-if="videodialog">
              <v-container fluid fill-height align-center justify-center>
              <upload-btn
                title=""
                :fileChangedCallback="fileChanged"
                accept="video/*"
                :flat = true
                :outline = true
                >
                <template slot="icon">
                    <v-icon left>videocam</v-icon>
                </template>
                </upload-btn>
                </v-container>
          </v-flex>
          <v-flex v-if="!imagedialog || !videodialog" xs4 offset-xs5>
              <v-container fluid fill-height align-center justify-center>
              <v-btn type="submit" class="white--text align-center" @click="submitFile()" :disabled="!text || dialog" :loading="dialog" color="blue">Submit Post</v-btn>
              </v-container>
          </v-flex>
          <v-flex v-else xs4 offset-xs2>
              <v-container fluid fill-height align-center justify-center>
              <v-btn type="submit" class="white--text align-center" @click="submitFile()" :disabled="!text || dialog" :loading="dialog" color="blue">Submit Post</v-btn>
              </v-container>
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
      videodialog: true,
      imagedialog: true,
      info: false,
      infotext: '',
     noImage: true,
     files: [],
     videos: '',
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
       'postAddStatus': function(){
         if(this.postAddStatus == 2){
           this.$router.push("/feeds");
         }
          else if (this.postAddStatus == 3){
           this.dialog = false;
            if (this.$store.getters.getPostAddMessage) {
           this.infotext = this.$store.getters.getPostAddMessage;
           this.info = true;
           }
           else  {
             this.infotext = 'An error Occured.';
             this.info = true;
           };
         }
         else if (this.postAddStatus == 1){
           this.dialog = true;
         }
       },

   },

  methods: {
       goBack(){
                this.$router.go(-1);
            },
      fileChanged (file) {
      this.videos = file;
      this.listVideo = true;
      this.imagedialog = false;
      console.log(this.videos);
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
      this.videodialog = false;
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
    if (this.files.length == 1) {
     this.videodialog = true;
    }
     this.files.splice( key, 1);
    },
    removeClip(){
     this.videos = '';
     this.listVideo = false;
     this.imagedialog = true;
    },
    submitFile() {
      //initialize the form data
      let formData = new FormData();
      formData.append('text', this.text);
      //itirate over any file sent over appending the files to the form data
      if (this.files.length != 0 && !this.videos) {
      for ( var i = 0; i < this.files.length; i++){
        let file = this.files[i];
        formData.append('files[' + i + ']', file);
      };
      }
      else if (this.videos) {
        let video = this.videos;
        formData.append('videos', video);
      }
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
