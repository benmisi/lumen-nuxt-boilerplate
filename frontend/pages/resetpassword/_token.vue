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
                  New Password
              </v-card-title>
              <v-card-text>
                     
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
                  <v-btn rounded block depressed color="primary" :loading="loading" :disabled="loading" @click="Login">Submit</v-btn>
                </v-card-actions>
          </v-card>
            </v-form>
           
        
      </v-col>
  </v-row>
</template>

<script>
export default {
  auth: false,
 data() {
     return {
        show1:false,
        loading:false,
        valid:true,
        password:'',
        passwordRules:[
          v=> !!v || "Password required",
          v=> (v && v.length >=10) || 'Password cannot be less than 10 characters'
      ],
      password_confirmation:'',
      password_confirmationRules:[
       v=> !!v || "Confirm Password required",
       v=> (v && v === this.password) || 'Confirm Password mismatch'
      ],
     }
 },methods: {
     Login(){
         if( this.$refs.form.validate())
          {
              this.loading = true
               const formdata = {"password_confirmation":this.password_confirmation,"password":this.password,'token':this.$route.params.token}
                this.$axios.post('api/reset-password',formdata).then(response=>{
                this.loading = false;           
                this.password=""               
                this.$swal.fire(
                'Yeep',
                  response.data.message,
                'success'
                ).then((result)=>{
                   this.$router.push('/Login')
                 })

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
 },
}
</script>

<style>

</style>