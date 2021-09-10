<template>
  <v-app id="inspire">
    <v-app-bar app flat>
      <v-toolbar-title>Todo List</v-toolbar-title>
      <v-spacer/>
      

      <div  v-if="$auth.loggedIn">
        
      <v-btn rounded  depressed color="success" @click="$auth.logout()">Logout</v-btn>
         <v-menu
      rounded="0"
      offset-y
    >
      <template #activator="{ attrs, on }">
        <v-btn
          color="primary"
          v-bind="attrs"
          v-on="on"
        >
     Welcome {{$auth.user.name}}
        </v-btn>
      </template>
      <v-list>
        <v-list-item link to="/cpanel">
          <v-list-item-title>Dashboard</v-list-item-title>
        </v-list-item>
        <v-list-item link >
          <v-list-item-title>Profile</v-list-item-title>
        </v-list-item>
         <v-list-item link @click="$auth.logout()">
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
      
      </div>
      <div v-else>
         <v-btn small primary depressed  to="/Login">Login</v-btn>
         <v-btn small primary depressed to="/Register" >Register</v-btn>
      </div>
    </v-app-bar>

    <v-main>
     <Nuxt/>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data() {
      return {
        
      }
    },
  }
</script>