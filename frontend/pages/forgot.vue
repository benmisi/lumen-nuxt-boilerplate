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
                Password Reset
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
              </v-card-text>
               <v-card-actions>
                  <v-btn rounded block depressed color="primary" :loading="loading" :disabled="loading" @click="Forgot">Submit</v-btn>
                </v-card-actions>
          </v-card>
            </v-form>

             <div class="text-center mt-3">
                  <nuxt-link to="/Register">Do not have an account ??</nuxt-link>
            </div>
      </v-col>
  </v-row>
</template>

<script>
export default {
  auth: false,
 data() {
     return {
        loading:false,
        valid:true,
        email: '',
        emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ]
     }
 },methods: {
     Forgot(){
         if( this.$refs.form.validate())
          {
              this.loading = true
               const formdata = {"email":this.email}
                this.$axios.post('api/forgot-password',formdata).then(response=>{
                this.loading = false;              
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