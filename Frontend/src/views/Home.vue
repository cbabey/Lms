<template>
    <div>
      <!-- <h1>Home</h1> -->
        <base-header type="gradient-success" class="pb-6 pb-8 pt-5 pt-md-8">
            <!-- Card stats -->
            <!-- <button @click="testing">check</button> -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <stats-card title="Current GPA"
                                type="gradient-red"
                                :sub-title="cGPA"
                               
                                class="mb-4 mb-xl-0"
                    >

                        <!-- <template slot="footer">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="text-nowrap">Since last month</span>
                        </template> -->
                    </stats-card>
                </div>
                <!-- <div class="col-xl-3 col-lg-6">
                    <stats-card title="Rank"
                                type="gradient-orange"
                                sub-title="2,356"
                                icon="ni ni-chart-pie-35"
                                class="mb-4 mb-xl-0"
                    >

                        <template slot="footer">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 12.18%</span>
                            <span class="text-nowrap">Since last month</span>
                        </template>
                    </stats-card>
                </div> -->
                <div class="col-xl-3 col-lg-6">
                    <stats-card title="Last Semster GPA"
                                type="gradient-green"
                                :sub-title="gpaTthis"
                               
                                class="mb-4 mb-xl-0"
                    >

                        <!-- <template slot="footer">
                            <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> 5.72%</span>
                            <span class="text-nowrap">Since last month</span>
                        </template> -->
                    </stats-card>

                </div>
                <!-- <div class="col-xl-3 col-lg-6">
                    <stats-card title="Current Semster Details"
                                type="gradient-info"
                                sub-title="49,65%"
                                icon="ni ni-chart-bar-32"
                                class="mb-4 mb-xl-0"
                    >

                        <template slot="footer">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 54.8%</span>
                            <span class="text-nowrap">Since last month</span>
                        </template>
                    </stats-card>
                </div> -->
            </div>
        </base-header>
        
        <div class="container-fluid mt--7">
            <div class="row" >
                <div class="col">
                    <div class="card shadow border-0">
                        <div id="map-canvas" class="map-canvas" data-lat="40.748817" data-lng="-73.985428 "  v-bind:style="{ height: heightSize + 'px' }">
                          <b-container fluid>
                               <!-- <add-Cource id="courceEdit" v-on:chiledToParent="onChiledClick"></add-Cource> -->
                               <resultTab></resultTab>
                          </b-container>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        

    </div>
</template>
<script>
  // Charts
//    import * as chartConfigs from '@/components/Charts/config';
//   import LineChart from '@/components/Charts/LineChart';
//    import BarChart from '@/components/Charts/BarChart';

  // // Tables
//    import SocialTrafficTable from './Dashboard/SocialTrafficTable';
//    import PageVisitsTable from './Dashboard/PageVisitsTable';
   import resultTab from './AdminPanel/Results/viewResults'


  export default {
    components: {
    //   LineChart,
    //   BarChart,
    //   PageVisitsTable,
    //   SocialTrafficTable,
      resultTab
    },
    data() {
      return {
        heightSize:2000,
        value:350897,
        cGPA:'234',
        gpaTthis:''
        
      };
    },
    methods: {
        testing(){
            var value = this.$session.get('index')
            value =value.split('/')
            var newList=""
            var isFirst = true;
            value.forEach(element => {
                if (isFirst) {
                    newList=newList+element    
                    isFirst=false
                }else{
                    newList=newList+'_'+element
                }
                
            });
            return newList
        }
    },
    mounted() {
        //  getTotalGPA(){
        // var index=this.$session.get('index')
        this.$http.get('http://localhost:8000/api/gettotalGPA/'+this.testing())
        .then(function(response){
            // console.log(response.body)
            this.cGPA=(response.body.gpa).toFixed(4)+" ";
           // console.log(this.allSem[0].sdid);
           // this.callSemster(this.allSem[0].sdid);
            
        });

         //this.sem=message;
      // this.dep='CM'
      // this.batch=2016;
         this.$http.get('http://127.0.0.1:8000/api/getCourceDetailsWithREsults/2/2016/'+this.testing())
         
        .then(function(response){
           // this.courcesCom=response.body.com;
            this.gpaTthis=response.body.gpa.toFixed(4)+" "
    
    
            //editable tab activation
            

            
            
        })

    //   },
     
    }
  };
</script>
<style></style>
