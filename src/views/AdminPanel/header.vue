<template>
    <div>

        <div>
  <b-navbar type="dark" variant="dark">
    <b-navbar-nav>
      <b-nav-item href="#">Home</b-nav-item>
      <b-nav-item href="#" to="/dhResult" >Uploading Results</b-nav-item>
       <b-nav-item href="#" to="/studentRegistrarion" >Student Restration</b-nav-item>

      <!-- Navbar dropdowns -->
      <b-nav-item-dropdown text="Lang" right>
        <b-dropdown-item href="#">EN</b-dropdown-item>
        <b-dropdown-item href="#">ES</b-dropdown-item>
        <b-dropdown-item href="#">RU</b-dropdown-item>
        <b-dropdown-item href="#">FA</b-dropdown-item>
      </b-nav-item-dropdown>

      <b-nav-item-dropdown text="Cources" right>
          <div v-for="ss in allSem">
              <b-dropdown-item href="#">Semester {{ss.sem_number}}</b-dropdown-item>
          </div>
        
        
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </b-navbar>
</div>
       
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item ">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost:8080/stundentRegistration">Student Registration</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Results</a>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Add Cources
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" >
            
        <div v-for="dep in depData">
            
            <a class="dropdown-item " :href="'http://localhost:8080/adminAddCources/'+dep.dep_code"  v-if="dep.dep_code!='IS'" >{{dep.Name}} </a>
        </div>
        
          
         
        </div>
      </li>
    </ul>
  </div>
</nav>

    </div>
</template>

<script>
//import navBar from '../navBar.vue'
export default {
    components:{
      //  'nav-Bar':navBar
    },
    data(){
        return{
            depData:[],
            k:[1,2,3],
            //data
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
    // created(){
    //     this.$http.get('http://127.0.0.1:8000/api/getD')
    //     .then(function(response){
    //         this.depData=response.body.allDep;
            
    //     })
    // },
    created(){
    // this.formType=this.$route.params.sem;
     // this.dep=this.formType;
      this.$http.get('http://127.0.0.1:8000/api/getSem/CO')
        .then(function(response){
            this.allSem=response.body.allDep;
           // console.log(this.allSem[0].sdid);
            //this.callSemster(this.allSem[0].sdid);
            
        });
        //value =this.allSem[0].sem_number;
        //console.log(value);
        
      //this.callSemster(this.allSem[0].sdid);
      this.dataObject=this.courcesCom[0];
    },

    methods:{

    }
}
</script>
