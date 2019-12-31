<template>
    <div>
        <!-- <h1>User Regstration</h1> -->
        <base-header type="gradient-success" class="pb-6 pb-8 pt-5 pt-md-6">
            
        </base-header>


        <div class="container-fluid mt--7">
            <div class="row" >
                <div class="col">
                    <div class="card shadow border-0">
                        <div id="map-canvas" class="map-canvas" data-lat="40.748817" data-lng="-73.985428" style="height: 900px;">
                            <!-- <res-up></res-up> -->
                            <b-container fluid>
                                <!-- start -->
                                <br>
                                <br>
                                    <us-table title="Admin Registrations for departments"></us-table>
  <!-- end -->
                            </b-container>

                            
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// import resultUpload from './AdminPanel/StudentRegistation/studentRegstariontoFac.vue'
import tableUser from './Tables/userRegistrationTable'
  export default {
      components:{
        //   'res-up':resultUpload,
          'us-table':tableUser
      },
     
    data() {
      return {
      }
    },

  }
</script>
<style>
</style>
