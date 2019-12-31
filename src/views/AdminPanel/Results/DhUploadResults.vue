<template>
   <div class="main">
      <!-- <addnewCourse-Panel :active="activeModelNewCource" :dataSet="dataObject" :dep="dep" :sem="sem" @close_model='closeNewCourse'></addnewCourse-Panel> -->
      <b-container fluid>
        <br>
        <b-row>
          <b-col v-if="this.$session.get('type')=='dean'">
             <b-dropdown text="Select Department">
            <!-- <div  v-for="ss in allSem">
               <b-dropdown-item @click="callSemster(ss.sdid)" >Semester {{ss.sem_number}}</b-dropdown-item>
            </div> -->
             <b-dropdown-item @click="calldep('CO')" >Computer Department</b-dropdown-item>
              <b-dropdown-item @click="calldep('CE')" >Civil Department</b-dropdown-item>
               <b-dropdown-item @click="calldep('CM')" >Internisiplinary Department</b-dropdown-item>
                <b-dropdown-item @click="calldep('ME')" >Mechanical Department</b-dropdown-item>
                 <b-dropdown-item @click="calldep('EE')" >Electrical And Tronic Department</b-dropdown-item>
            
         </b-dropdown>

         <span style="margin-left:14px; font-size:18px"> Department : {{dep}}</span>
            
          </b-col>
          <b-col>
             <b-dropdown text="Select Semsters">
            <div  v-for="ss in allSem" :key="ss.sdid">
               <b-dropdown-item @click="callSemster(ss.sdid)" >Semester {{ss.sem_number}}</b-dropdown-item>
            </div>
            
         </b-dropdown>

         <span style="margin-left:14px; font-size:18px"> Semster : {{sem}}</span>

          </b-col>
          <b-col>
            <b-dropdown text="Select Batch">
            <div  v-for="ss in yearsSet" :key="ss.year">
               <b-dropdown-item @click="yearSelect(ss.year)" > {{ss.year}}</b-dropdown-item>
            </div>
            
         </b-dropdown>
<!-- g -->
         <span style="margin-left:14px; font-size:18px"> Batch : {{batch}}</span>

          </b-col>
        </b-row>
      </b-container>
      <upload-result :show="activatingUploadingResultModel" :dataSet="dataObject" :dep="dep" :sem="sem" :batch="batch" @close_model='closeUploadModel'> </upload-result>
      <edit-result :show="activatingEditingResultModel" :dataSet="dataObject" :dep="dep" :sem="sem" :batch="batch" @close_model='closeEditModel'> </edit-result>
      <!-- <button @click="OpenUploadModel">Fuck</button>   -->
      <hr>
      <!-- Compulsory Cources -->
      
      <b-container fluid>
        <div class="card shadow container-fluid"
         :class="type === 'dark' ? 'bg-default': ''">
         <div class="card-header border-0"
            :class="type === 'dark' ? 'bg-transparent': ''">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0" :class="type === 'dark' ? 'text-white': ''">
                     Compulsory Cources
                  </h3>
               </div>
               <div class="col text-right">
                  <base-button type="primary" size="sm">See all</base-button>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <base-table class="table align-items-center table-flush"
               :class="type === 'dark' ? 'table-dark': ''"
               :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
               tbody-classes="list"
               :data="courcesCom">
               <template slot="columns">
                  <!-- <th>Cource Code</th>
                     <th>Budget2121</th>
                     <th>Status</th>
                     <th>Users</th>
                     <th>Completion</th> -->
                  <th >Cource Code</th>
                  <th >Title</th>
                  <!-- <th scope="col">Credit</th> -->
                  <!-- <th scope="col">GPA Contribution</th> -->
                  <th>Result State</th>
                  <th>Upload/Edit</th>
                  <!-- <th></th> -->
               </template>
               <template slot-scope="{row}">
                  <th scope="row">
                     <div class="media-body">
                        <span class="name mb-0 text-sm">{{row.courceCode}}</span>
                     </div>
                     <!-- <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" :src="row.img">
                        </a>
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{row.title}}</span>
                        </div>
                        </div> -->
                  </th>
                  <td class="budget">
                     <span class="name mb-0 text-sm">{{row.title[0]}}</span>
                  </td>
                  <td v-if="row.title[1]=='0'"><i class="material-icons" style="color:red">
                     assignment_late
                     </i>
                  </td>
                  <td v-if="row.title[1]=='1'"><i style="color:green" class="material-icons">
                     assignment_turned_in
                     </i>
                  </td>
                  <!-- <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                     <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button> -->
                  <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                  <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>
                  </td>
               </template>
            </base-table>
         </div>
      </div>
      </b-container>
      <br>

      <!-- Elective Cources -->
      <!-- <dir v-for="(i,k) in courcesele"> -->
        
        <b-container fluid  v-for="(i,k) in courcesele " :key="i">
          <br>
      <div class="card shadow container-fluid"
         :class="type === 'dark' ? 'bg-default': ''">
         <div class="card-header border-0"
            :class="type === 'dark' ? 'bg-transparent': ''">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0" :class="type === 'dark' ? 'text-white': ''">
                     Elective Bucket  : {{i[0].buctNumber}}
                  </h3>
               </div>
               <div class="col text-right">
                  <base-button type="primary" size="sm">See all</base-button>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <base-table class="table align-items-center table-flush"
               :class="type === 'dark' ? 'table-dark': ''"
               :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
               tbody-classes="list"
               :data="courcesele[k]">
               <template slot="columns">
                  <!-- <th>Cource Code</th>
                     <th>Budget2121</th>
                     <th>Status</th>
                     <th>Users</th>
                     <th>Completion</th> -->
                  <th >Cource Code</th>
                  <th >Title</th>
                  <!-- <th scope="col">Credit</th> -->
                  <!-- <th scope="col">GPA Contribution</th> -->
                  <th>Result State</th>
                  <th>Upload/Edit</th>
                  <!-- <th></th> -->
               </template>
               <template slot-scope="{row}">
                  <th scope="row">
                     <div class="media-body">
                        <span class="name mb-0 text-sm">{{row.courceCode}}</span>
                     </div>
                     <!-- <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" :src="row.img">
                        </a>
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{row.title}}</span>
                        </div>
                        </div> -->
                  </th>
                  <td class="budget">
                     <span class="name mb-0 text-sm">{{row.title[0]}}</span>
                  </td>
                  <td v-if="row.title[1]=='0'"><i class="material-icons" style="color:red">
                     assignment_late
                     </i>
                  </td>
                  <td v-if="row.title[1]=='1'"><i style="color:green" class="material-icons">
                     assignment_turned_in
                     </i>
                  </td>
                  <!-- <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                     <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button> -->
                  <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                  <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>
                  </td>
               </template>
            </base-table>
         </div>
      </div>
      </b-container>
      <!-- </dir> -->

      <!-- Optional Bucket -->
     
        <b-container  fluid  v-for="(i,k) in courcesopo" :key="i">
          <br>
      <div class="card shadow container-fluid"
         :class="type === 'dark' ? 'bg-default': ''">
         <div class="card-header border-0"
            :class="type === 'dark' ? 'bg-transparent': ''">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0" :class="type === 'dark' ? 'text-white': ''">
                     Optional Bucket : {{i[0].buctNumber}}
                  </h3>
               </div>
               <div class="col text-right">
                  <base-button type="primary" size="sm">See all</base-button>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <base-table class="table align-items-center table-flush"
               :class="type === 'dark' ? 'table-dark': ''"
               :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
               tbody-classes="list"
               :data="courcesele[k]">
               <template slot="columns">
                  <!-- <th>Cource Code</th>
                     <th>Budget2121</th>
                     <th>Status</th>
                     <th>Users</th>
                     <th>Completion</th> -->
                  <th >Cource Code</th>
                  <th >Title</th>
                  <!-- <th scope="col">Credit</th> -->
                  <!-- <th scope="col">GPA Contribution</th> -->
                  <th>Result State</th>
                  <th>Upload/Edit</th>
                  <!-- <th></th> -->
               </template>
               <template slot-scope="{row}">
                  <th scope="row">
                     <div class="media-body">
                        <span class="name mb-0 text-sm">{{row.courceCode}}</span>
                     </div>
                     <!-- <div class="media align-items-center">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" :src="row.img">
                        </a>
                        <div class="media-body">
                          <span class="name mb-0 text-sm">{{row.title}}</span>
                        </div>
                        </div> -->
                  </th>
                  <td class="budget">
                     <span class="name mb-0 text-sm">{{row.title[0]}}</span>
                  </td>
                  <td v-if="row.title[1]=='0'"><i class="material-icons" style="color:red">
                     assignment_late
                     </i>
                  </td>
                  <td v-if="row.title[1]=='1'"><i style="color:green" class="material-icons">
                     assignment_turned_in
                     </i>
                  </td>
                  <!-- <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                     <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button> -->
                  <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                  <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>
                  </td>
               </template>
            </base-table>
         </div>
      </div>
       </b-container>
      <!-- <b-container fluid style="text-align:center">
         <div class="" style="width:90%;margin:auto">
              
              <table class="table table-striped">
         <thead>
         
         
         
         <tr>
         <th scope="col">Cource Code</th>
         <th scope="col">Title</th>
         
         <th scope="col">Result State</th>
         <th scope="col">Upload/Edit</th>
         </tr>
         </thead>
         <tbody>
         <tr v-for="obj in courcesCom">
         
         <th scope="row">{{obj.courceCode}}</th>
         <td>{{obj.title[0]}}</td>
         
         <td v-if="obj.title[1]=='0'"><i class="material-icons">
         assignment_late
         </i></td>
         <td v-if="obj.title[1]=='1'"><i class="material-icons">
         assignment_turned_in
         </i></td>
         <td v-if="obj.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
         <td v-if="obj.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>
         
         
         </td>
         </tr>
         
         </tbody>
         </table>
         </div>
         
         </b-container> -->
      <!-- <div v-for="bb in editPanelActivation"> -->
         <!-- <edit-panel v-if="bb" :active="activeModel" :dataSet="dataObject" :dep="dep" :sem="sem" @close_model='close'></edit-panel>   -->
      <!-- </div> -->
      <!-- <b-container fluid style="text-align:center">
         <div v-for="(i,k) in courcesele" class="" style="width:90%;margin:auto">
            <br>
            <span class="tag is-medium">Elective Bucket  : {{i[0].buctNumber}}  </span>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th scope="col">Cource Code</th>
                     <th scope="col">Title</th> -->
                     <!-- <th scope="col">Credit</th> -->
                     <!-- <th scope="col">GPA Contribution</th> -->
                     <!-- <th scope="col">Minor Subject</th> -->
                     <!-- <th scope="col">Result State</th>
                     <th scope="col">Upload/Edit</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="obj in i">
                     <th scope="row">{{obj.courceCode}}</th>
                     <td>{{obj.title[0]}}</td> -->
                     <!-- <td>{{obj.credits}}</td> -->
                     <!-- <td v-if="obj.gpaContribution==0">NO</td> -->
                     <!-- <td v-if="obj.gpaContribution==1">YES</td> -->
                     <!-- <td>{{obj.name}}</td> -->
                     <!-- <td v-if="obj.title[1]=='0'"><i class="material-icons">
                        assignment_late
                        </i>
                     </td>
                     <td v-if="obj.title[1]=='1'"><i class="material-icons">
                        assignment_turned_in
                        </i>
                     </td>
                     <td v-if="obj.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                     <td v-if="obj.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div> -->
      <!-- </b-container>
      <b-container fluid style="text-align:center">
         <div v-for="i in courcesopo" class="" style="width:90%;margin:auto">
            <br>
            <span class="tag is-medium">Optional Bucket : {{i[0].buctNumber}} </span>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th scope="col">Cource Code</th>
                     <th scope="col">Title</th> -->
                     <!-- <th scope="col">Credit</th> -->
                     <!-- <th scope="col">GPA Contribution</th> -->
                     <!-- <th scope="col">Result State</th>
                     <th scope="col">Upload/Edit</th>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="obj in i">
                     <th scope="row">{{obj.courceCode}}</th>
                     <td>{{obj.title[0]}}</td> -->
                     <!-- <td>{{obj.credits}}</td> -->
                     <!-- <td v-if="obj.credits==1">NO</td> -->
                     <!-- <td v-if="obj.credits!=1">YES</td> -->
                     <!-- <td v-if="obj.title[1]=='0'"><i class="material-icons">
                        assignment_late
                        </i>
                     </td>
                     <td v-if="obj.title[1]=='1'"><i class="material-icons">
                        assignment_turned_in
                        </i>
                     </td>
                     <td v-if="obj.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                     <td v-if="obj.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </b-container> -->
   </div>
</template>


<script>

// import editPanel from './updateNewCourse.vue'
// import addNewCourses from './addNewCource.vue'

// import {bus} from '../../../main.js';
import uploadResult from './UploadingResultModel'
import editResult from './EditResultsodel'
export default {
  components:{
      'upload-result':uploadResult,
      'edit-result':editResult
  },
    props: {
      type: {
        type: String
      },
      title: String
    },
    created(){
      this.yearsret();
     this.domOfcreated();
    },
    data(){
        return{
          ccount:0,
          dep:'CM',
          sem:'',
          batch:'',
          dataObject:'',
           activeModel:false,
           activeModelNewCource:false,
           activatingUploadingResultModel:false,
           activatingEditingResultModel:false,
          optional:[],
          electives:[],
          allSem:[],
          courcesCom:[],
           courcesele:[],
            courcesopo:[],
            editPanelActivation:[],
            yearsSet:[],
        

         

        }
    },
   
    methods:{
        yearsret(){
            this.$http.get('http://127.0.0.1:8000/api/getallYears')
        .then(function(response){
            this.yearsSet=response.body.years;
           // console.log(this.allSem[0].sdid);
           // this.callSemster(this.allSem[0].sdid);
            this.batch=this.yearsSet[0].year;
         //  console.log( this.yearsSet[0].year)    
        });
        
       // this.batch=this.yearsSet[0].year;
          
        },
        domOfcreated(){
        //   this.formType='CM';
     // this.dep=this.formType;
     if (this.$session.get('type')!='dean') {
        this.dep=this.$session.get('type');
     }
      this.$http.get('http://127.0.0.1:8000/api/getSem/'+this.dep)
        .then(function(response){
            this.allSem=response.body.allDep;
           // console.log(this.allSem[0].sdid);
            this.callSemster(this.allSem[0].sdid);
            
        });
        //value =this.allSem[0].sem_number;
        //console.log(value);
        
      //this.callSemster(this.allSem[0].sdid);
      this.dataObject=this.courcesCom[0];
        },
        OpenUploadModel(obj){
           this.dataObject=obj;
            this.activatingUploadingResultModel=true;
        },
        closeUploadModel(){
            this.activatingUploadingResultModel=false;
            this.domOfcreated();
        },
          OpenEditModel(obj){
           this.dataObject=obj;
            this.activatingEditingResultModel=true;
        },
        closeEditModel(){
            this.activatingEditingResultModel=false;
            this.domOfcreated();
        },
        calldep(val){
          this.dep=val;
          this.domOfcreated()
        },
        yearSelect(batcg1){
          this.batch=batcg1;
          this.callSemster(this.sem);
        },
        supitingWords(){
          
          this.courcesCom.forEach(element => {
            element.title=element.title.split("/")
          });
          this.courcesele.forEach(element => {
            element.forEach(element1 => {
              element1.title=element1.title.split("/")
            });
          });
           this.courcesopo.forEach(element => {
            element.forEach(element1 => {
              element1.title=element1.title.split("/")
            });
          });
        },
      
     
      callSemster(message){
       // alert('abc');
       this.sem=message;
      // this.dep='CM'
      // this.batch=2016;
         this.$http.get('http://127.0.0.1:8000/api/getCourwithRes/'+message+'/'+this.batch)
         
        .then(function(response){
            this.courcesCom=response.body.com;
            //editable tab activation
            

            // this.courcesCom.forEach(element => {
            //   this.editPanelActivation.push(false);
            // });
            for (let index = 0; index < this.courcesCom.length; index++) {
               this.editPanelActivation.push(false);
               
            }
            this.courcesele=response.body.ele;
           this.courcesopo=response.body.opo;
           this.supitingWords();
            
        })
      },
      
       
    }
    
    
}
</script>

