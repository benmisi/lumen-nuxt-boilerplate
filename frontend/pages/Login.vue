<template>
  <v-row>
      <v-col md="4" class="offset-md-4 mt-4">
           <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
          <v-card>
              <v-card-title>
                  Login
              </v-card-title>
              <v-card-text>
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
                        <v-btn block depressed color="primary" :loading="loading" :disabled="loading" @click="Login">Submit</v-btn>
         
              </v-card-text>
               <v-card-actions>
                  <v-row>
              <v-col class="text-left">
                 <nuxt-link to="/Register">Create An Account</nuxt-link>
              </v-col>
               <v-col class="text-right">
                  <nuxt-link to="/forgot">Forgot password ??</nuxt-link>
               </v-col>
            </v-row>
                </v-card-actions>
          </v-card>
            </v-form>
           
           
        
      </v-col>
  </v-row>
</template>

<script>
export default {
auth: 'guest',
 data() {
     return {
        show1:false,
        loading:false,
        valid:true,
        email: '',
        password:'',
        emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passwordRules:[
          v=> !!v || "Password required",
          v=> (v && v.length >=10) || 'Password cannot be less than 10 characters'
      ]
     }
 },methods: {
     async Login(){
         if( this.$refs.form.validate())
          {
          this.loading = true
          try {

             await this.$auth.loginWith('local',{
            data:{
              email:this.email,
              password:this.password
            }
          }) 
             this.loading = false
      
            
          } catch (error) {
               this.loading = false
                 this.$swal.fire(
                'Oooh NO!!',
                  error.response.data.message,
                'error'
                )
             
          }
         
          }
     }
 },
}
</script>

<style>

</style>