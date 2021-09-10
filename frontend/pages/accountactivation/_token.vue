<template>
<v-row>
      <v-col md="4" class="offset-md-4 mt-4">
             <v-card>
              <v-card-text class="text-center">
                   <v-progress-circular
                    :size="150"
                    :width="7"
                    color="purple"
                    indeterminate
                    ></v-progress-circular>
                    <div class="mt-2">PLEASE WAIT VERIFYING YOUR ACCOUNT ...</div>
              </v-card-text>
             </v-card>
      </v-col>
</v-row>
</template>

<script>
export default {created() {
       this.activate()
   },
   methods: {
       activate(){
           this.$axios.get(`/api/activateaccount/${this.$route.params.token}`).then(response=>{
            
                   this.$router.push('/Login')
          
           })
   },
}
}
</script>

<style>

</style>