<template>
<f7-page>
    <f7-navbar class="elevation-5">
      <f7-nav-left></f7-nav-left>
      <f7-nav-title>Create a Post</f7-nav-title>
       <f7-nav-right>
         <f7-gauge
        type="circle"
        :value="gaugeValue"
        :size="45"
        borderColor="#2196f3"
        :borderWidth="8"
        :valueText="`${gaugeValue * 100}%`"
        :valueFontSize="14"
        valueTextColor="#2196f3"
      />
      </f7-nav-right>
    </f7-navbar>
    <f7-toolbar tabber labels :bottom-md="true" class="elevation-24">
      <f7-button @click="addFiles()">
        <f7-icon class="icon-fill" ios="f7:camera" md="material:home">
        </f7-icon>
        Add image
      </f7-button>
       <f7-button fill tab-link @click="submitFile()">
       ADD POST
      </f7-button>
    </f7-toolbar>
    <b>
    <f7-block strong v-show="noImage">
        <f7-input placeholder="Start typing here" type="textarea" @input="text = $event.target.value" clear-button></f7-input>
    </f7-block>
    <f7-block strong v-show="!noImage">
        <f7-input placeholder="Add a caption" type="text" @input="text = $event.target.value" clear-button></f7-input>
    </f7-block>
    </b>
     <f7-list>
      <f7-list-item class="fileInput">
        <input type="file" id="files" accept="image/*" multiple ref="files" @change="handleFileUpload()"/>
      </f7-list-item>
    </f7-list>
    <f7-block strong class="showPreview" v-for="(file, key) in files" :key="file.name">
       <f7-button fill color="red">
          <b @click="removeFile( key )"><f7-icon class="icon-fill" ios="f7:close_round" md="material:close"></f7-icon> cancel</b>
        </f7-button>
       <img class="preview" :ref="'image'+parseInt( key )" />
    </f7-block>
</f7-page>
</template>
<script>
export default {
  data() {
   return {
     gaugeValue: 0,
     noImage: true,
     files: [],
     text: ''
   }
  },

  computed: {
     postAddStatus(){
       return this.$store.getters.getPostAddStatus;
     },
   },

   watch: {
       'postAddStatus': function(){
         if(this.postAddStatus == 2){
           this.$f7router.navigate("/hometab/");
         }
       },

   },

  methods: {
    //adds a file
    addFiles() {
     this.$refs.files.click();
    },
    //handles uploading of files
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
    submitFile() {
      //initialize the form data
      let formData = new FormData();
      formData.append('text', this.text);
      //itirate over any file sent over appending the files to the form data
      for ( var i = 0; i < this.files.length; i++){
        let file = this.files[i];
        formData.append('files[' + i + ']', file);
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
<style scoped>
.fileInput {
  display: none;
}
.showPreview img {
  max-width: 100%;
  align-content: center;
}
</style>
