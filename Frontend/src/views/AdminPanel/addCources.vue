<template>
  <div>
    <!-- <nav-Bar></nav-Bar> -->
    <!-- <edit-panel :active="activeModel" :dataSet="dataObject" :dep="dep" :sem="sem" @close_model='close'   ></edit-panel>  -->
     <!-- <addnewCourse-Panel :active="activeModelNewCource" :dataSet="dataObject" :dep="dep" :sem="sem" @close_model='closeNewCourse'></addnewCourse-Panel> -->

   
  

    <div class="container">
        <div class="btn-group">
          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Select Semester
          </button>
          <div class="dropdown-menu">
            <div v-for="ss in allSem">
              <a @click="callSemster(ss.sdid)" class="dropdown-item " href="#">Semester {{ss.sem_number}}</a>
            </div> 
            
          </div>
        </div>


       <div class="row"></div>
           
       </div>

    <br>
    <div class="container">
      <div class="row">
        <div class="col">
          <button @click="increseElectives"     type="button" class="btn btn-secondary">Add New Elective Bucket</button>
          <button @click="increseOptional" type="button" class="btn btn-secondary">Add New Optional Bucket</button>
          
    
        </div>    
      </div>
<br>
<br>
      <div class="container">
    <div class="row">
       <div class="container">
         <span class="tag is-medium">Compulsory Cources</span>
       <a href="#" class="btn btn-info btn-sm" @click="addNewCoursesRunIt(courcesCom[0])">
          <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
        </a>
       </div>
       <table class="table table-striped">
  <thead>



    <tr>
      <th scope="col">Cource Code</th>
      <th scope="col">Title</th>
      <th scope="col">Credit</th>
      <th scope="col">GPA Contribution</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="obj in courcesCom">
      
      <th scope="row">{{obj.courceCode}}</th>
      <td>{{obj.title}}</td>
      <td>{{obj.credits}}</td>
      <td v-if="obj.gpaContribution==0">NO</td>
      <td v-if="obj.gpaContribution==1">YES</td>
       <td><button @click="lunchEditPanel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>
       
       
</td>
    </tr>
    
  </tbody>
</table>
    </div>
    </div>
    <div v-for="bb in editPanelActivation">
      <edit-panel v-if="bb" :active="activeModel" :dataSet="dataObject" :dep="dep" :sem="sem" @close_model='close'></edit-panel>  
    </div>



  <div  v-for="i in courcesele" >
    <div class="container">
      <span class="tag is-medium">Elective Bucket  : {{i[0].buctNumber}}  - credit Limit{{i[0].crLimit}}</span>
           <a href="#" class="btn btn-info btn-sm" @click="addNewCoursesRunIt(i[0])">
          <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
        </a>
    </div>
    <div class="container">
    <div class="row">
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Cource Code</th>
      <th scope="col">Title</th>
      <th scope="col">Credit</th>
      <th scope="col">GPA Contribution</th>
      <th scope="col">Minor Subject</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="obj in i">
      <th scope="row">{{obj.courceCode}}</th>
      <td>{{obj.title}}</td>
      <td>{{obj.credits}}</td>
      <td v-if="obj.gpaContribution==0">NO</td>
      <td v-if="obj.gpaContribution==1">YES</td>
       <td>{{obj.name}}</td>
        <td><button @click="lunchEditPanel(obj)" type="button" class="btn btn-outline-primary"><span class="glyphicon glyphicon-list-alt"></span> Edit</button>
</td>
        
    </tr>
    
  </tbody>
</table>
    </div>
    </div>
  </div>

   <div v-for="i in courcesopo">
    <div class="container">
      <span class="tag is-medium">Optional Bucket : {{i[0].buctNumber}} </span>
           <a href="#" class="btn btn-info btn-sm" @click="addNewCoursesRunIt(i[0])">
          <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
        </a>
    </div>
    <div class="container">
    <div class="row">
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Cource Code</th>
      <th scope="col">Title</th>
      <th scope="col">Credit</th>
      <th scope="col">GPA Contribution</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="obj in i">
      <th scope="row">{{obj.courceCode}}</th>
      <td>{{obj.title}}</td>
      <td>{{obj.credits}}</td>
      <td v-if="obj.credits==1">NO</td>
      <td v-if="obj.credits!=1">YES</td>
       <td><button @click="lunchEditPanel(obj)" type="button" class="btn btn-outline-primary"><span class="glyphicon glyphicon-list-alt"></span> Edit</button>
</td>
    </tr>
    
  </tbody>
</table>
    </div>
    </div>
  </div>


    </div>

    


  </div>
</template>



<script>

//import editPanel from './editCourcePanel.vue'
//import addNewCourses from './addNewCourse.vue'

import {bus} from '../../main.js';
export default {
    components:{
        
      ///  'edit-panel':editPanel,
       // 'addnewCourse-Panel':addNewCourses
    },
    created(){
      this.formType=this.$route.params.sem;
      this.dep=this.formType;
      this.$http.get('http://127.0.0.1:8000/api/getSem/'+this.formType)
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
    data(){
        return{
          ccount:0,
          dep:'',
          sem:'',
          dataObject:'',
           activeModel:'',
           activeModelNewCource:'',
          optional:[],
          electives:[],
          allSem:[],
          courcesCom:[],
           courcesele:[],
            courcesopo:[],
            editPanelActivation:[],
            
        

         

        }
    },
    methods:{
      increseElectives(){
        //{ "courceCode": "CO3203", "type": "E", "buctNumber": 1, "crLimit": 7, "title": "Computer Security", "gpaContribution": 1, "credits": 2, "preVisit": null, "mid": null, "name": null } - credit Limit7  Add New Course 
        
       // console.log("aaaa");
        if (this.courcesele.length==0) {
          var arra=[{'crLimit':0,'buctNumber':1,'type':'E'}];
        this.courcesele.push(arra);
        }else{
          var a=this.courcesele[this.courcesele.length-1][0].buctNumber;
          var arra=[{'crLimit':0,'buctNumber':++a,'type':'E'}];
        this.courcesele.push(arra);
        }
      },
      
      lunchEditPanel(obj){

        this.dataObject=obj;
        this.editPanelActivation[0]=true;
        this.runit();
        //swal("Good job!", "You clicked the button!", "success", {
   // button: "Aww yiss!",
     // });
      },
      callSemster(message){
       // alert('abc');
       this.sem=message;
         this.$http.get('http://127.0.0.1:8000/api/getCour/'+message)
         
        .then(function(response){
            this.courcesCom=response.body.com;
            //editable tab activation
            this.courcesCom.forEach(element => {
              this.editPanelActivation.push(false);
            });
            this.courcesele=response.body.ele;
           this.courcesopo=response.body.opo;
            
        })
      },
      increseOptional(){
      //  this.courcesopo.push("12");
        
        if (this.courcesopo.length==0) {
          var arra=[{'crLimit':null,'buctNumber':1,'type':'O'}];
        this.courcesopo.push(arra);
        }else{
          var a=this.courcesopo[this.courcesopo.length-1][0].buctNumber;
          var arra=[{'crLimit':null,'buctNumber':++a,'type':'O'}];
        this.courcesopo.push(arra);
        }
   // console.log("aaaa");
        
      },
      addNewCoursesRunIt(obj){
        this.dataObject=obj;
        this.activeModelNewCource='is-active';
      },
      closeNewCourse(){
        this.activeModelNewCource='';
        this.created();
      },
       runit(){
            this.activeModel='is-active';
        },
        close(){
             this.activeModel=''
             this.created();
        }
    }
    
    
}
</script>
