<template>
<div>
  <v-row>
    <v-col cols="12" md="11">
         <v-breadcrumbs :items="items">
      <template #divider>
        <v-icon>mdi-forward</v-icon>
      </template>
    </v-breadcrumbs>
    </v-col>
  </v-row>
   <v-container>
        <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
     
         <v-card>
           <v-card-title>

           </v-card-title>
           <v-card-text>
                 <v-text-field
                    v-model="name"
                    :rules="nameRules"
                    outlined
                    label="Name"
                    required
                    ></v-text-field>
                      <v-text-field
                    v-model="email"
                    outlined
                    :rules="emailRules"
                    label="Email"
                    type="email"
                    required
                    ></v-text-field>
                    <v-text-field
                    v-model="password"
                    outlined
                    :rules="passwordRules"
                    label="Password"
                       :type="show1 ? 'text' : 'password'"
                    required
                     :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                       @click:append="show1 = !show1"
                    ></v-text-field>
                        <v-text-field
                    v-model="password_confirmation"
                    outlined
                    label="Confirm Password"
                       :type="show1 ? 'text' : 'password'"
                     :rules="password_confirmationRules"
                    required
                     :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                       @click:append="show1 = !show1"
                    ></v-text-field>
           </v-card-text>
            <v-card-actions>
                  <v-btn  block depressed color="primary" :loading="loading" :disabled="loading" @click="updateProfile">Submit</v-btn>

              </v-card-actions>
         </v-card>
          
        </v-form>
   </v-container>
</div>
</template>

<script>
export default {
layout: 'user',
  middleware: 'auth',
  data() {
    return {
      profile:"",
        items: [
        {
          text: 'Dashboard',
          disabled: false,
          href: '/cpanel',
        },
       
        {
          text: 'Profile',
          disabled: true,
          href: 'breadcrumbs_link_2',
        },
      ],
      show1:false,
         valid: true,
         loading:false,
         message:"",
         name:"",
         nameRules:[ v=> !!v || "Name is required"],
         email: '',
          emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      password:'',
      password_confirmation:'',
      password_confirmationRules:[
       v=> !!v || "Confirm Password required",
       v=> (v && v === this.password) || 'Confirm Password mismatch'
      ],
      passwordRules:[
          v=> !!v || "Password required",
          v=> (v && v.length >=10) || 'Password cannot be less than 10 characters'
      ]
    }
  },
  async fetch(){
    try {
         const response = await this.$axios.get('api/getProfile')
         this.name = response.data.user.name
         this.email = response.data.user.email
    } catch (error) {
         this.loading = false;
                  this.$swal.fire(
                'Oooh NO!!',
                  error.response.data.message,
                'error'
                )
    }
 
  },
  methods: {
      updateProfile(){
          if( this.$refs.form.validate())
          {
              this.loading = true
               const formdata = {"name":this.name,"email":this.email,"password":this.password,"password_confirmation":this.password_confirmation}
                this.$axios.post('api/updateProfile',formdata).then(response=>{
                this.loading = false;             
                 
                this.$swal.fire(
                'Yeep',
                  response.data.message,
                'success'
                )

           }).catch(error=>{
                 this.loading = false;
                  this.$swal.fire(
                'Oooh NO!!',
                  error.response.data.message,
                'error'
                )
                
           })
          }
      }
  }
}
</script>

<style>

</style>