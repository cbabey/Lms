<template>
  <div class="main" id="courceEdit">
    <addnewCourse-Panel
      :active="activeModelNewCource"
      :dataSet="dataObject"
      :dep="dep"
      :sem="sem"
      @close_model="closeNewCourse"
    ></addnewCourse-Panel>
    <b-container fluid>
      <br />
      <b-row>
        <b-col v-if="this.$session.get('type')=='dean'">
          <b-dropdown text="Select Department">
            <!-- <div  v-for="ss in allSem">
               <b-dropdown-item @click="callSemster(ss.sdid)" >Semester {{ss.sem_number}}</b-dropdown-item>
            </div>-->
            <b-dropdown-item @click="calldep('CO')">Computer Department</b-dropdown-item>
            <b-dropdown-item @click="calldep('CE')">Civil Department</b-dropdown-item>
            <b-dropdown-item @click="calldep('CM')">Internisiplinary Department</b-dropdown-item>
            <b-dropdown-item @click="calldep('ME')">Mechanical Department</b-dropdown-item>
            <b-dropdown-item @click="calldep('EE')">Electrical And Tronic Department</b-dropdown-item>
          </b-dropdown>

          <span style="margin-left:14px; font-size:18px">Department : {{dep}}</span>
        </b-col>
        <b-col>
          <b-dropdown text="Select Semsters">
            <div v-for="ss in allSem" :key="ss.sdid+'a'">
              <b-dropdown-item @click="callSemster(ss.sdid)">Semester {{ss.sem_number}}</b-dropdown-item>
            </div>
          </b-dropdown>

          <span style="margin-left:14px; font-size:18px">Semster : {{sem}}</span>
        </b-col>
      </b-row>
    </b-container>

    <hr />
    <b-container fluid>
      <!-- <b-dropdown text="Select Semsters">
                <div  v-for="ss in allSem">
                    <b-dropdown-item @click="callSemster(ss.sdid)" >Semester {{ss.sem_number}}</b-dropdown-item>
                </div>
                
      </b-dropdown>-->
      <div>
        <b-button @click="increseElectives">Add new elective Bucket</b-button>
        <b-button @click="increseOptional">Add new optional Bucket</b-button>
      </div>
    </b-container>

    <br />

    <!-- Compulsory Cource -->
    <div class="card shadow container-fluid" :class="type === 'dark' ? 'bg-default': ''">
      <div class="card-header border-0" :class="type === 'dark' ? 'bg-transparent': ''">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0" :class="type === 'dark' ? 'text-white': ''">
              Compulsory Cources
              <a
                style="margin-left:10px;"
                href="#"
                class="btn btn-info btn-sm"
                @click="addNewCoursesRunIt(courcesCom[0])"
              >
                <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
              </a>
            </h3>
          </div>
          <div class="col text-right">
            <!-- <base-button type="primary" size="sm">See all</base-button> -->
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <base-table
          class="table align-items-center table-flush"
          :class="type === 'dark' ? 'table-dark': ''"
          :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
          tbody-classes="list"
          :data="courcesCom"
        >
          <template slot="columns">
            <!-- <th>Cource Code</th>
                     <th>Budget2121</th>
                     <th>Status</th>
                     <th>Users</th>
            <th>Completion</th>-->
            <th>Cource Code</th>
            <th>Title</th>
            <th>Credit</th>
            <!-- <th scope="col">Credit</th> -->
            <!-- <th scope="col">GPA Contribution</th> -->
            <th>GPA Contribution</th>
            <!-- <th>Upload/Edit</th> -->
            <th>Edit</th>
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
              </div>-->
            </th>
            <td class="budget">
              <span class="name mb-0 text-sm">{{row.title}}</span>
            </td>
            <td class="budget">
              <span class="name mb-0 text-sm">{{row.credits}}</span>
            </td>
            <td class="budget">
              <span v-if="row.gpaContribution==0" class="name mb-0 text-sm">No</span>
              <span v-if="row.gpaContribution==1" class="name mb-0 text-sm">Yes</span>
            </td>
            <td class="budget">
              <button @click="lunchEditPanel(row)" type="button" class="btn btn-outline-primary">
                <span class="glyphicon glyphicon-list-alt"></span> Edit
              </button>
            </td>

            <!-- <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
            <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>-->
            <td v-if="row.title[1]=='0'">
              <button @click="OpenUploadModel(row)" type="button" class="btn btn-outline-primary">
                <span class="glyphicon glyphicon-list-alt"></span> Upload
              </button>
            </td>
            <td v-if="row.title[1]=='1'">
              <button @click="OpenEditModel(row)" type="button" class="btn btn-outline-primary">
                <span class="glyphicon glyphicon-list-alt"></span> Edit
              </button>
            </td>
          </template>
        </base-table>
      </div>
    </div>

    <!-- Compulsory Courcews -->
    <!-- <b-container fluid>
            
        <div class="" style="width:90%;margin:auto">
             <span class="tag is-medium">Compulsory Cources</span>
             <a href="#" class="btn btn-info btn-sm" @click="addNewCoursesRunIt(courcesCom[0])">
          <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
        </a>
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

    </b-container>-->

    <!-- end -->

    <!-- Elective cources -->
    <div v-for="bb in editPanelActivation" :key="bb+'a'">
      <edit-panel
        v-if="bb"
        :active="activeModel"
        :dataSet="dataObject"
        :dep="dep"
        :sem="sem"
        @close_model="close"
      ></edit-panel>
    </div>

    <!-- <div v-bind=""></div> -->

    <div v-for="(i,k) in courcesele" :key="i[0].buctNumber+'a'">
      <br />
      <div class="card shadow container-fluid" :class="type === 'dark' ? 'bg-default': ''">
        <div class="card-header border-0" :class="type === 'dark' ? 'bg-transparent': ''">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0" :class="type === 'dark' ? 'text-white': ''">
                Elective Bucket : {{i[0].buctNumber}}
                <a
                  style="margin-left:10px;"
                  href="#"
                  class="btn btn-info btn-sm"
                  @click="addNewCoursesRunIt(i[0])"
                >
                  <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
                </a>
              </h3>
            </div>
            <div class="col text-right">
              <!-- <base-button type="primary" size="sm">See all</base-button> -->
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <base-table
            class="table align-items-center table-flush"
            :class="type === 'dark' ? 'table-dark': ''"
            :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
            tbody-classes="list"
            :data="courcesele[k]"
          >
            <template slot="columns">
              <!-- <th>Cource Code</th>
                     <th>Budget2121</th>
                     <th>Status</th>
                     <th>Users</th>
              <th>Completion</th>-->
              <th>Cource Code</th>
              <th>Title</th>
              <th>Credit</th>
              <th>GPA Contribution</th>
              <th>Minor Subject</th>
              <!-- <th scope="col">Credit</th> -->
              <!-- <th scope="col">GPA Contribution</th> -->
              <th>Edit</th>
              <!-- <th>Upload/Edit</th> -->
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
                </div>-->
              </th>
              <td class="budget">
                <span class="name mb-0 text-sm">{{row.title}}</span>
              </td>
              <td class="budget">
                <span class="name mb-0 text-sm">{{row.credits}}</span>
              </td>
              <td class="budget">
                <span v-if="row.gpaContribution==0" class="name mb-0 text-sm">No</span>
                <span v-if="row.gpaContribution==1" class="name mb-0 text-sm">Yes</span>
              </td>
              <td class="budget">
                <span class="name mb-0 text-sm">{{row.name}}</span>
              </td>
              <td class="budget">
                <button @click="lunchEditPanel(row)" type="button" class="btn btn-outline-primary">
                  <span class="glyphicon glyphicon-list-alt"></span> Edit
                </button>
              </td>

              <!-- <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
              <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>-->
              <!-- <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
                  <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>
              </td>-->
            </template>
          </base-table>
        </div>
      </div>
    </div>

    <div fluid v-for="(i,k) in courcesopo" :key="i[0].buctNumber+'b'">
      <br />
      <div class="card shadow container-fluid" :class="type === 'dark' ? 'bg-default': ''">
        <div class="card-header border-0" :class="type === 'dark' ? 'bg-transparent': ''">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0" :class="type === 'dark' ? 'text-white': ''">
                Optional Bucket : {{i[0].buctNumber}}
                <a
                  style="margin-left:10px;"
                  href="#"
                  class="btn btn-info btn-sm"
                  @click="addNewCoursesRunIt(i[0])"
                >
                  <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
                </a>
              </h3>
            </div>
            <div class="col text-right">
              <!-- <base-button type="primary" size="sm">See all</base-button> -->
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <base-table
            class="table align-items-center table-flush"
            :class="type === 'dark' ? 'table-dark': ''"
            :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
            tbody-classes="list"
            :data="courcesele[k]"
          >
            <template slot="columns">
              <!-- <th>Cource Code</th>
                     <th>Budget2121</th>
                     <th>Status</th>
                     <th>Users</th>
              <th>Completion</th>-->
              <th>Cource Code</th>
              <th>Title</th>
              <th>Credit</th>
              <th>GPA Contribution</th>
              <!-- <th >Minor Subject</th> -->
              <!-- <th scope="col">Credit</th> -->
              <!-- <th scope="col">GPA Contribution</th> -->
              <th>Edit</th>
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
                </div>-->
              </th>
              <td class="budget">
                <span class="name mb-0 text-sm">{{row.title}}</span>
              </td>
              <td class="budget">
                <span class="name mb-0 text-sm">{{row.credits}}</span>
              </td>
              <td class="budget">
                <span v-if="row.gpaContribution==0" class="name mb-0 text-sm">No</span>
                <span v-if="row.gpaContribution==1" class="name mb-0 text-sm">Yes</span>
              </td>

              <td class="budget">
                <button @click="lunchEditPanel(row)" type="button" class="btn btn-outline-primary">
                  <span class="glyphicon glyphicon-list-alt"></span> Edit
                </button>
              </td>
            </template>
          </base-table>
        </div>
      </div>
    </div>

    <!-- <div v-for="bb in editPanelActivation">
        <edit-panel v-if="bb" :active="activeModel" :dataSet="dataObject" :dep="dep" :sem="sem" @close_model='close'></edit-panel>  
    </div>-->
    <!-- 
        <b-container fluid >
              <div v-for="i in courcesele" class="" style="width:90%;margin:auto">
                    <br>
                <span class="tag is-medium">Elective Bucket  : {{i[0].buctNumber}}  - credit Limit{{i[0].crLimit}}</span>
                <a href="#" class="btn btn-info btn-sm" @click="addNewCoursesRunIt(i[0])">
                <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
                </a>
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

    </b-container>-->

    <!-- <b-container fluid>
            <div v-for="i in courcesopo" class="" style="width:90%;margin:auto">
                <br>
                <span class="tag is-medium">Optional Bucket : {{i[0].buctNumber}} </span>
                    <a href="#" class="btn btn-info btn-sm" @click="addNewCoursesRunIt(i[0])">
                    <span class="glyphicon glyphicon-plus-sign"></span> Add New Course
                    </a>

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
             
    </b-container>-->
  </div>
</template>


<script>
import editPanel from "./updateNewCourse.vue";
import addNewCourses from "./addNewCource.vue";

// import { bus } from "../../main.js";
export default {
  components: {
    "edit-panel": editPanel,
    "addnewCourse-Panel": addNewCourses
  },

  created() {
    if (this.$session.get("type") != "dean") {
      this.dep = this.$session.get("type");
      this.generatedStart(this.$session.get("type"));
    } else {
      this.generatedStart("CM");
    }
  },
  data() {
    return {
      type: "",
      ccount: 0,
      dep: "",
      sem: "",
      dataObject: "",
      activeModel: false,
      activeModelNewCource: false,
      optional: [],
      electives: [],
      allSem: [],
      courcesCom: [],
      courcesele: [],
      courcesopo: [],
      editPanelActivation: [],
      elemtSize: ""
    };
  },
  watch: {
    elemtSize() {
      this.$emit("chiledToParent", this.elemtSize);
    }
  },
  methods: {
    generatedStart(val) {
      this.formType = val; //this.$route.params.sem;
      this.dep = this.formType;
      this.$http
        .get("http://127.0.0.1:8000/api/getSem/" + this.formType)
        .then(function(response) {
          this.allSem = response.body.allDep;
          // console.log(this.allSem[0].sdid);
          this.callSemster(this.allSem[0].sdid);
        });
      //value =this.allSem[0].sem_number;
      //console.log(value);

      //this.callSemster(this.allSem[0].sdid);
      this.dataObject = this.courcesCom[0];
    },
    increseElectives() {
      //{ "courceCode": "CO3203", "type": "E", "buctNumber": 1, "crLimit": 7, "title": "Computer Security", "gpaContribution": 1, "credits": 2, "preVisit": null, "mid": null, "name": null } - credit Limit7  Add New Course

      // console.log("aaaa");
      var arra;
      if (this.courcesele.length == 0) {
        arra = [{ crLimit: 0, buctNumber: 1, type: "E" }];
        this.courcesele.push(arra);
      } else {
        var a = this.courcesele[this.courcesele.length - 1][0].buctNumber;
        arra = [{ crLimit: 0, buctNumber: ++a, type: "E" }];
        this.courcesele.push(arra);
      }
    },

    lunchEditPanel(obj) {
      this.dataObject = obj;
      this.editPanelActivation[0] = true;
      this.runit();
      //swal("Good job!", "You clicked the button!", "success", {
      // button: "Aww yiss!",
      // });
    },
    callSemster(message) {
      // alert('abc');
      // console.log(document.getElementById('courceEdit').clientHeight);
      this.elemtSize = document.getElementById("courceEdit").clientHeight;
      this.sem = message;
      this.$http
        .get("http://127.0.0.1:8000/api/getCour/" + message)

        .then(function(response) {
          this.courcesCom = response.body.com;
          
          for (var i = 0; i < this.courcesCom.length; i++) {
            this.editPanelActivation.push(false);
          }
          this.courcesele = response.body.ele;
          this.courcesopo = response.body.opo;
        });
    },
    increseOptional() {
      //  this.courcesopo.push("12");
      // console.log('Increse Optional')
      var arra;
      if (this.courcesopo.length == 0) {
        arra = [{ crLimit: null, buctNumber: 1, type: "O" }];
        this.courcesopo.push(arra);
      } else {
        var a = this.courcesopo[this.courcesopo.length - 1][0].buctNumber;
        arra = [{ crLimit: null, buctNumber: ++a, type: "O" }];
        this.courcesopo.push(arra);
      }
      // console.log("aaaa");
    },
    calldep(val) {
      //this.dep=val;
      this.generatedStart(val);
    },
    addNewCoursesRunIt(obj) {
      this.dataObject = obj;
      this.activeModelNewCource = true;
    },
    closeNewCourse() {
      this.activeModelNewCource = false;
      this.callSemster(this.sem);
      //this.created();
    },
    runit() {
      this.activeModel = true;
    },
    close() {
      this.activeModel = false;
      this.callSemster(this.sem);
      //   this.created();
    }
  }
};
</script>

