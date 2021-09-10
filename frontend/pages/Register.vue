<template>
  <v-row>
      <v-col md="4" class="offset-md-4 mt-4">
          <v-alert v-model="alert" :type="alerttype" >{{message}}</v-alert>
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
          <v-card>
              <v-card-title>
                  Register
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
                  <v-btn rounded block depressed color="primary" :loading="loading" :disabled="loading" @click="Register">Submit</v-btn>

              </v-card-actions>
          </v-card>
            </v-form>
             <div class="text-center mt-3">
                  <nuxt-link to="/Login">Already got an account ??</nuxt-link>
            </div>
        
      </v-col>
  </v-row>
</template>

<script>
export default {
 auth: 'guest',
 data() {
     return {
         alerttype:"success",
         alert:false,
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
 },methods: {
     
     Register(){
          if( this.$refs.form.validate())
          {
              this.loading = true
               const formdata = {"name":this.name,"email":this.email,"password":this.password,"password_confirmation":this.password_confirmation}
                this.$axios.post('api/register',formdata).then(response=>{
                this.loading = false;             
                this.name=""
                this.email=""
                this.password=""
                this.password_confirmation=""
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