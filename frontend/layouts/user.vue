<template>
  <v-app id="inspire">
      <v-navigation-drawer 
       v-model="drawer"
      color="primary"
    dark
      width="200px"
      app>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h6">
            Application
          </v-list-item-title>
          <v-list-item-subtitle>
            subtext
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list
        dense
        nav
      >
        <v-list-item link to="/cpanel">
          <v-list-item-icon>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    
    <v-app-bar  app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Application</v-toolbar-title>
      <v-spacer/>
         <div  v-if="$auth.loggedIn">
        
  
         <v-menu
      rounded="0"
      offset-y
    >
      <template #activator="{ attrs, on }">
        <v-btn
        
          v-bind="attrs"
          plain
          v-on="on"
        >
     <v-avatar>
      <img
        src="https://cdn.vuetifyjs.com/images/john.jpg"
        alt="John"
        class="mr-2"
      >
    </v-avatar> {{$auth.user.name}}
        </v-btn>
      </template>
      <v-list>
       <v-list-item link to="/cpanel/profile">
          <v-list-item-title>Profile</v-list-item-title>
        </v-list-item>
         <v-list-item link @click="$auth.logout()">
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
      
      </div>
    </v-app-bar>

    <v-main class="grey lighten-3">
       
      <Nuxt/>
       
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
                      drawer: null,
                      logo:"",
                       items: [
                                { title: 'Dashboard', icon: 'mdi-view-dashboard' },
                                { title: 'Photos', icon: 'mdi-image' },
                                { title: 'About', icon: 'mdi-help-box' },
                              ]
                 }),
  }
</script>