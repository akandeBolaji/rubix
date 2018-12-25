<template>
  <f7-page>
    <f7-navbar class="elevation-5">
      <f7-nav-left></f7-nav-left>
      <f7-nav-title>Rubik</f7-nav-title>
       <f7-nav-right>
        <f7-link icon-only>
          <f7-icon ios="f7:bell" md="material:bell">
            <f7-badge color="red">5</f7-badge>
          </f7-icon>
        </f7-link>
      </f7-nav-right>
    </f7-navbar>
    <f7-toolbar tabber labels :bottom-md="true" class="elevation-24">
      <f7-link tab-link route-tab-id="tab-1" href="/hometab/">
        <f7-icon class="icon-fill" ios="f7:home" md="material:home">
          <f7-badge color="red">5</f7-badge>
        </f7-icon>
        <span class="tabbar-label">Home</span>
      </f7-link>
      <f7-link tab-link route-tab-id="tab-2" href="/messagestab/">
         <f7-icon class="icon-fill" ios="f7:email_fill" md="material:email">
          <f7-badge color="red">12</f7-badge>
        </f7-icon>
        <span class="tabbar-label">Messages</span>
      </f7-link>
      <f7-link tab-link route-tab-id="tab-3" href="/networktab/">
        <f7-icon class="icon-fill" ios="f7:persons" md="material:people">
          <f7-badge color="red">4</f7-badge>
        </f7-icon>
        <span class="tabbar-label">Network</span>
      </f7-link>
       <f7-link tab-link route-tab-id="tab-4" href="/profiletab/">
         <f7-icon class="icon-fill" ios="f7:person" md="material:person">
          <f7-badge color="red">5</f7-badge>
        </f7-icon>
        <span class="tabbar-label">Profile</span>
       </f7-link>
    </f7-toolbar>
   <f7-tabs routable>
    <f7-tab id="tab-1"></f7-tab>
    <f7-tab id="tab-2"></f7-tab>
    <f7-tab id="tab-3"></f7-tab>
     <f7-tab id="tab-4"></f7-tab>
  </f7-tabs>
  </f7-page>
</template>
<script>
export default {
  name:'HomePage',
  data() {
     return {
      loading:false,
      loaded: null,
      error: null,
     };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.$store.dispatch( 'getUser');
  }
}
}
</script>
