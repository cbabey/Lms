<template>
  <div>
     <b-modal v-model="modalShow">
      <b-container>
        <b-row style="margin-left:26px">
          <b-col cols="2">
            <i class="material-icons" style="font-size:50px; color:green">check_circle</i>
          </b-col>
          <b-col>
            <span>
              <p style="font-size:30px">{{printit}}</p>
            </span>
          </b-col>
        </b-row>
      </b-container>
    </b-modal>
    <!-- <button type="button" class="btn btn-primary">New Batch <span class="badge">{{year}}</span></button> -->
    <br />
    <a href="#" style="font-size:20px" class="badge badge-success">Regstering Batch Year : {{year}}</a>
    <!-- <a href="#"  style="font-size:20px" class="badge badge-success">{{year}}</a> -->
    <b-container>
      <!-- <span style="background-color:blue; margin:auto">New Batch </span>
      <span>: 2016</span>-->

      <br />
      <br />
      <b-alert :show="isNotCsv" variant="danger">Please user the .csv Fileformat to Register the students</b-alert>
      <b-form-file
        v-model="file"
        :state="Boolean(file)"
        placeholder="Choose a file..."
        drop-placeholder="Drop file here..."
      ></b-form-file>
      <div class="mt-3" v-if="isDisplay">Selected file: {{ file ? file.name : '' }}</div>

      <b-button v-if="!isNotCsv" style="margin-top:10px" @click="uploadFile" variant="outline-primary">View Preview</b-button>
      <b-button v-if="!isNotCsv" style="margin-top:10px" @click="RegisteringStudent" variant="outline-success">Submit</b-button>
    </b-container>
    <br />

    <b-container fluid v-if="isDisplay">
      <span class="badge badge-success" style="font-size:20px">{{file ? file.name:''}} Data Preview</span>
      <!-- style="height:700px; overflow-y: auto" -->

      <!-- <h3>Number of Students :{{body.length}}</h3> -->
      <div v-if="!isNotCsv" style="height:550px; overflow-y: auto">
        <!-- <b-container> -->
        <table style="font-size:19px; text-align:center" class="table table-hover">
          <thead>
            <tr>
              <!-- <div  v-for="i in headers"> -->
              <th style="font-size:15px" v-for="i in headers" :key="i">{{i}}</th>
              <!-- </div> -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="(i,k) in body[0]" :key="i">
              <td style="font-size:15px">{{i}}</td>
              <td style="font-size:15px">{{body[1][k]}}</td>
              <!-- <td>john@example.com</td> -->
            </tr>
          </tbody>
        </table>
        <!-- </b-container> -->
      </div>
    </b-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      file: null,
      dataPac: {
        file: ""
      },
      headers: "",
      body: "",
      year: "",
      isDisplay: false,
      isNotCsv:false,
      printit:"",
      modalShow:false
    };
  },
  watch:{
    file(){
      // console.log(this.file.name)
      var temp = this.file.name
      if (this.file!=null) {
        temp = temp.split('.')
        temp = temp[temp.length-1]
        // console.log(temp)
        if (temp!="csv" || temp!='csv') {
          this.isNotCsv=true;
        }else{
          this.isNotCsv=false;
        }
        // console.log(temp)
      }

    }
  },
  created() {
    this.$http
      .get("http://127.0.0.1:8000/api/getNewBatchYear")
      .then(function(response) {
        this.year = response.body.year;
        // console.log(this.allSem[0].sdid);
        // this.callSemster(this.allSem[0].sdid);
      });
  },
  methods: {
    uploadFile() {
      // console.log(this.file);
      let formData = new FormData();
      formData.append("file", this.file);
      this.$http
        .post("http://127.0.0.1:8000/api/temp", formData)
        .then(function(response) {
          // Success
          //  console.log(response.body)
          this.headers = response.body.fuckMe.Headers;
          this.body = response.body.fuckMe.body;
        });

      this.isDisplay = true;
    },
    RegisteringStudent() {
      // console.log(this.file);
      let formData = new FormData();
      formData.append("file", this.file);
      this.$http
        .post("http://127.0.0.1:8000/api/registerNewStudents", formData)
        .then(function() {
          this.modalShow=true;
          // this.$router.push('courceDetail-Controller') 
          // Success
          //  console.log(response.body)
          // this.headers=response.body.fuckMe.Headers;
          // this.body=response.body.fuckMe.body;
        });
    }
  }
};
</script>
