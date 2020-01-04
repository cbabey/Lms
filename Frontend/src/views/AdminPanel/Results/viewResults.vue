<template>
  <div class="main">
    <!-- <addnewCourse-Panel :active="activeModelNewCource" :dataSet="dataObject" :dep="dep" :sem="sem" @close_model='closeNewCourse'></addnewCourse-Panel> -->
    <b-container fluid>
      <b-row>
        <b-col>
          <b-row>
            <b-col cols="3">
              <b-dropdown text="Select Semsters" style="margin-top:10px;">
                <div v-for="(ss,k) in allSem" :key="k">
                  <b-dropdown-item @click="callSemster(ss.sdid)">Semester {{ss.sem_number}}</b-dropdown-item>
                </div>
              </b-dropdown>
            </b-col>
            <b-col>
              <!-- <span style="font-size:22px; margin-top:17px; padding-left:15px;">Semester : {{sem}}</span> -->
              <h3 style="margin-top:19px;">Semester : {{sem}} </h3>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="3">
          <br />
          <b-alert show variant="success">GPA IN THIS SEMSTER : {{gpaTthis}}</b-alert>
          <!-- <h3   style="font-size:22px;padding-top:10px; padding-left:15px;" > GPA IN THIS SEMSTER : {{gpaTthis}}</h3> -->
        </b-col>
      </b-row>
    </b-container>
    <!-- <upload-result :show="activatingUploadingResultModel" :dataSet="dataObject" :dep="dep" :sem="sem" :batch="batch" @close_model='closeUploadModel'> </upload-result>      -->
    
    <!-- <edit-result :show="activatingEditingResultModel" :dataSet="dataObject" :dep="dep" :sem="sem" :batch="batch" @close_model='closeEditModel'> </edit-result>      -->

    <!-- <button @click="OpenUploadModel">Fuck</button>   -->

    <hr />
    <!-- Compulsory Cources -->
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
          <!-- <th scope="col">Credit</th> -->
          <!-- <th scope="col">GPA Contribution</th> -->
          <th>Result</th>
          <!-- <th>Upload/Edit</th> -->
          <!-- <th></th> -->
        </template>

        <template slot-scope="{row}" style="background-color: brown;">
          <!-- <th v-bind:class="{ 'table-warning': row.title[1]!='A' }" class="table-warning"  scope="row">
            <div class="media-body">
                <span class="name mb-0 text-sm">{{row.courceCode}}</span>
          </div>-->
          <!-- <div class="media align-items-center">
              <a href="#" class="avatar rounded-circle mr-3">
                <img alt="Image placeholder" :src="row.img">
              </a>
              <div class="media-body">
                <span class="name mb-0 text-sm">{{row.title}}</span>
              </div>
          </div>-->
          <!-- </th> -->

          <td
            v-bind:class="{ 'table-warning': row.title[1]=='R' ||  row.title[1]=='F' }"
            class="budget"
          >
            <span class="name mb-0 text-sm">{{row.courceCode}}</span>
          </td>

          <td
            v-bind:class="{ 'table-warning': row.title[1]=='R' ||  row.title[1]=='F' }"
            class="budget"
          >
            <span class="name mb-0 text-sm">{{row.title[0]}}</span>
          </td>

          <td
            class="budget"
            v-bind:class="{ 'table-warning': row.title[1]=='R' ||  row.title[1]=='F' }"
          >
            <div class="media-body">
              <span class="name mb-0 text-sm">{{row.title[1]}}</span>
            </div>
            <!-- <span class="name mb-0 text-sm">{{row.title[1]}}</span> -->
          </td>

          <!-- <td v-if="row.title[1]=='0'"><i class="material-icons" style="color:red">
assignment_late
</i></td>
<td v-if="row.title[1]=='1'"><i style="color:green" class="material-icons">
assignment_turned_in
          </i></td>-->

          <!-- <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
          <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>-->
          <!-- <td v-if="row.title[1]=='0'"><button @click="OpenUploadModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Upload</button>
          <td v-if="row.title[1]=='1'"><button @click="OpenEditModel(row)" type="button" class="btn btn-outline-primary"> <span class="glyphicon glyphicon-list-alt"></span> Edit</button>-->

          <!-- </td>       -->
        </template>
      </base-table>
    </div>

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

    </b-container>-->
    <!-- <div v-for="bb in editPanelActivation" :key="bb">
      <edit-panel v-if="bb" :active="activeModel" :dataSet="dataObject" :dep="dep" :sem="sem" @close_model='close'></edit-panel>  
    </div> -->

    <b-container fluid style="text-align:center">
      <div v-for="(i,k) in courcesele" :key="k" class style="width:90%;margin:auto">
        <br />
        <span class="tag is-medium">Elective Bucket : {{i[0].buctNumber}}</span>

        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Cource Code</th>
              <th scope="col">Title</th>
              <!-- <th scope="col">Credit</th> -->
              <!-- <th scope="col">GPA Contribution</th> -->
              <!-- <th scope="col">Minor Subject</th> -->
              <th scope="col">Result State</th>
              <th scope="col">Upload/Edit</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="obj in i" :key="obj">
              <th scope="row">{{obj.courceCode}}</th>
              <td>{{obj.title[0]}}</td>
              <!-- <td>{{obj.credits}}</td> -->
              <!-- <td v-if="obj.gpaContribution==0">NO</td> -->
              <!-- <td v-if="obj.gpaContribution==1">YES</td> -->
              <!-- <td>{{obj.name}}</td> -->
              <td v-if="obj.title[1]=='0'">
                <i class="material-icons">assignment_late</i>
              </td>
              <td v-if="obj.title[1]=='1'">
                <i class="material-icons">assignment_turned_in</i>
              </td>
              <td v-if="obj.title[1]=='0'">
                <button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary">
                  <span class="glyphicon glyphicon-list-alt"></span> Upload
                </button>
              </td>
              <td v-if="obj.title[1]=='1'">
                <button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary">
                  <span class="glyphicon glyphicon-list-alt"></span> Edit
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </b-container>

    <b-container fluid style="text-align:center">
      <div v-for="(i,k) in courcesopo" :key="i[0].buctNumber+k" class style="width:90%;margin:auto">
        <br />
        <span class="tag is-medium">Optional Bucket : {{i[0].buctNumber}}</span>

        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Cource Code</th>
              <th scope="col">Title</th>
              <!-- <th scope="col">Credit</th> -->
              <!-- <th scope="col">GPA Contribution</th> -->
              <th scope="col">Result State</th>
              <th scope="col">Upload/Edit</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(obj,k) in i" :key="k">
              <th scope="row">{{obj.courceCode}}</th>
              <td>{{obj.title[0]}}</td>
              <!-- <td>{{obj.credits}}</td> -->
              <!-- <td v-if="obj.credits==1">NO</td> -->
              <!-- <td v-if="obj.credits!=1">YES</td> -->
              <td v-if="obj.title[1]=='0'">
                <i class="material-icons">assignment_late</i>
              </td>
              <td v-if="obj.title[1]=='1'">
                <i class="material-icons">assignment_turned_in</i>
              </td>
              <td v-if="obj.title[1]=='0'">
                <button @click="OpenUploadModel(obj)" type="button" class="btn btn-outline-primary">
                  <span class="glyphicon glyphicon-list-alt"></span> Upload
                </button>
              </td>
              <td v-if="obj.title[1]=='1'">
                <button @click="OpenEditModel(obj)" type="button" class="btn btn-outline-primary">
                  <span class="glyphicon glyphicon-list-alt"></span> Edit
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </b-container>
  </div>
</template>


<script>
// import editPanel from './updateNewCourse.vue'
// import addNewCourses from './addNewCource.vue'

// import { bus } from "../../../main.js";
// import uploadResult from "./UploadingResultModel";
// import editResult from "./EditResultsodel";
export default {
  components: {
    // "upload-result": uploadResult,
    // "edit-result": editResult
  },
  props: {
    type: {
      type: String
    },
    title: String
  },
  created() {
    this.domOfcreated();
  },
  data() {
    return {
      ccount: 0,
      dep: "CO",
      sem: "",
      batch: "",
      dataObject: "",
      activeModel: false,
      activeModelNewCource: false,
      activatingUploadingResultModel: false,
      activatingEditingResultModel: false,
      optional: [],
      electives: [],
      allSem: [],
      courcesCom: [],
      courcesele: [],
      courcesopo: [],
      editPanelActivation: [],
      gpaTthis: "",
      cGPA: ""
    };
  },

  methods: {
    testing() {
      var value = this.$session.get("index");
      value = value.split("/");
      var newList = "";
      var isFirst = true;
      value.forEach(element => {
        if (isFirst) {
          newList = newList + element;
          isFirst = false;
        } else {
          newList = newList + "_" + element;
        }
      });
      return newList;
    },
    getTotalGPA() {
      this.$http
        .get(
          "http://127.0.0.1:8000/api/getAllRepeatedSubjects/" + this.testing()
        )
        .then(function(response) {
          this.cGPA = response.body.gpa;
          // console.log(this.allSem[0].sdid);
          // this.callSemster(this.allSem[0].sdid);
        });
    },
    domOfcreated() {
      this.formType = "CM";
      this.dep = this.formType;
      this.$http
        .get("http://127.0.0.1:8000/api/getSem/CM")
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
    OpenUploadModel(obj) {
      this.dataObject = obj;
      this.activatingUploadingResultModel = true;
    },
    closeUploadModel() {
      this.activatingUploadingResultModel = false;
      this.domOfcreated();
    },
    OpenEditModel(obj) {
      this.dataObject = obj;
      this.activatingEditingResultModel = true;
    },
    closeEditModel() {
      this.activatingEditingResultModel = false;
      this.domOfcreated();
    },

    supitingWords() {
      this.courcesCom.forEach(element => {
        element.title = element.title.split("/");
      });
      this.courcesele.forEach(element => {
        element.forEach(element1 => {
          element1.title = element1.title.split("/");
        });
      });
      this.courcesopo.forEach(element => {
        element.forEach(element1 => {
          element1.title = element1.title.split("/");
        });
      });
    },

    callSemster(message) {
      // alert('abc');
      this.sem = message;
      this.dep = "CM";
      this.batch = 2016;
      this.$http
        .get(
          "http://127.0.0.1:8000/api/getCourceDetailsWithREsults/" +
            message +
            "/2016/" +
            this.testing()
        )

        .then(function(response) {
          this.courcesCom = response.body.com;
          this.gpaTthis = response.body.gpa;
          //editable tab activation

         

          for (let index = 0; index < this.courcesCom.length; index++) {
             this.editPanelActivation.push(false);
            
          }
          this.courcesele = response.body.ele;
          this.courcesopo = response.body.opo;
          this.supitingWords();
        });
    }
  }
};
</script>

<style scoped>
.s {
}
</style>
