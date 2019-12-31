<template>
  <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
    <side-bar
      :background-color="sidebarBackground"
      short-title="Argon"
      title="Argon"
    >
      <template slot="links">
        <!-- <sidebar-item
          :link="{
            name: 'Dashboard',
            icon: 'ni ni-tv-2 text-primary',
            path: '/dashboard'
          }"
        /> -->

        <!-- <sidebar-item :link="{name: 'Icons', icon: 'ni ni-planet text-blue', path: '/icons'}"/> -->
        <sidebar-item v-if="this.$session.get('type')=='SU' " :link="{name: 'View Repeat subjects ', icon: 'ni ni-circle-08 text-pink', path: '/view-Repeat-subjects'}"/>
        <sidebar-item v-if="this.$session.get('type')=='dean'" :link="{name: 'Registering new Batch', icon: 'ni ni-pin-3 text-orange', path: '/student-Registering'}"/>
        <sidebar-item v-if="this.$session.get('type')!='SU' " :link="{name: 'Semster Cordinates ', icon: 'ni ni-circle-08 text-pink', path: '/courceDetail-Controller'}"/>
          <sidebar-item  v-if="this.$session.get('type')!='SU' " :link="{name: 'Uploding Results ', icon: 'ni ni-calendar-grid-58', path: '/Result-Upload'}"/>
           <sidebar-item  v-if="this.$session.get('type')=='SU' " :link="{name: 'Home ', icon: 'ni ni-tv-2 text-primary', path: '/Home'}"/>
            <sidebar-item v-if="this.$session.get('type')=='dean'"  :link="{name: 'User Registration ', icon: 'ni ni-single-02 text-yellow', path: '/user-Regstration'}"/>
        <!-- <sidebar-item :link="{name: 'User Profile', icon: 'ni ni-single-02 text-yellow', path: '/profile'}"/> -->
        <!-- <sidebar-item :link="{name: 'Tables', icon: 'ni ni-bullet-list-67 text-red', path: '/tables'}"/> -->
        <!-- <sidebar-item :link="{name: 'Login', icon: 'ni ni-key-25 text-info', path: '/login'}"/> -->
        <!-- <sidebar-item :link="{name: 'Register', icon: 'ni ni-circle-08 text-pink', path: '/register'}"/> -->

      </template>
    </side-bar>
    
    <div class="main-content" :data="sidebarBackground">
      <dashboard-navbar></dashboard-navbar>
    
    

      <div @click="toggleSidebar">
        <fade-transition :duration="200" origin="center top" mode="out-in">
          <!-- your content here -->
          <router-view></router-view>
        </fade-transition>
        <content-footer v-if="!$route.meta.hideFooter"></content-footer>
      </div>
    </div>
  </div>
</template>
<script>
  import DashboardNavbar from './DashboardNavbar.vue';
  import ContentFooter from './ContentFooter.vue';
  import { FadeTransition } from 'vue2-transitions';

  export default {
    components: {
      DashboardNavbar,
      ContentFooter,
      FadeTransition
    },
    created(){
      if(this.$session.get('jwt')==null){
         this.$router.push('/login')
      }
    },
    data() {
      return {
        sidebarBackground: 'vue' //vue|blue|orange|green|red|primary
      };
    },
    methods: {
      toggleSidebar() {
        if (this.$sidebar.showSidebar) {
          this.$sidebar.displaySidebar(false);
          
        }
      }
    }
  };
</script>

