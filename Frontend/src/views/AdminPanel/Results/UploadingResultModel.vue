<template>
  <div>
    <!-- <b-button @click="show=true" variant="primary">Show Modal</b-button> -->
    <div>
      <!-- <b-button @click="modalShow = !modalShow">Open Modal</b-button> -->

      <b-modal v-model="modalShow">
        <b-container>
          <b-row style="margin-left:26px">
            <b-col cols="2">
              <i class="material-icons" style="font-size:50px; color:green">check_circle</i>
            </b-col>
            <b-col>
              <span>
                <p style="font-size:30px">Result Uploded</p>
              </span>
            </b-col>
          </b-row>
        </b-container>
      </b-modal>
    </div>
    <b-modal v-model="show" title="Uploading Results" size="lg">
      <b-container fluid>
        <b-container>
          <b-badge
            v-if="this.dataSet!=null"
            variant="badge badge-primary"
            style=" margin-left:10px ;font-size:17px"
          >Cource Code : {{this.dataSet.courceCode}}</b-badge>
          <b-badge
            v-if="this.dataSet!=null"
            variant="badge badge-primary"
            style=" margin-left:10px ;font-size:17px"
          >Title : {{this.dataSet.title[0]}}</b-badge>
          <b-badge
            variant="badge badge-primary"
            style=" margin-left:10px ;font-size:17px"
          >Batch No : {{batch}}</b-badge>
          <b-badge
            variant="badge badge-primary"
            style=" margin-left:10px ;font-size:17px;  margin-top:10px;"
          >Semester : {{sem}}</b-badge>
          <b-badge
            variant="badge badge-primary"
            style=" margin-left:10px ;font-size:17px"
          >Department : {{dep}}</b-badge>
        </b-container>

        <hr />

        <div>
          <div>
            <b-container>
              
              <!-- <span style="background-color:blue; margin:auto">New Batch </span>
              <span>: 2016</span>-->
              <!-- <button type="button" class="btn btn-primary">New Batch <span class="badge">{{year}}</span></button> -->
  <b-alert :show="isNotCsv" variant="danger">Please user the .csv Fileformat to Upload the result</b-alert>
              <b-form-file
                v-model="file"
                :state="Boolean(file)"
                placeholder="Choose a file..."
                drop-placeholder="Drop file here..."
              ></b-form-file>

              <div v-if="file!=null" class="mt-3">Selected file: {{ file ? file.name : '' }}</div>
              <b-button
                v-if="!isNotCsv"
                style="margin-top:10px"
                @click="uploadFile"
                variant="outline-primary"
              >View Preview</b-button>
              <!-- <b-button @click="RegisteringStudent" variant="outline-primary">Submit</b-button> -->
            </b-container>
            <br />
            <span v-if="file!=null && !isNotCsv">Table Preview</span>
            <hr />
            <b-container v-if="isTablePrivew && !isNotCsv" style="height:400px; overflow: auto ">
              <!-- <h6>Number of Students :{{body.length}}</h6> -->
              <table class="table table-hover">
                <thead>
                  <tr>
                    <!-- <div  v-for="i in headers"> -->
                    <th v-for="i in headers" :key="i">{{i}}</th>
                    <!-- </div> -->
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(i,k) in body[0]" :key="i">
                    <td>{{i}}</td>
                    <td>{{body[1][k]}}</td>
                    <!-- <td>john@example.com</td> -->
                  </tr>
                </tbody>
              </table>
            </b-container>
          </div>
        </div>
      </b-container>

      <div slot="modal-footer" class="w-100">
        <!-- <p class="float-left">Modal Footer Content</p> -->

        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="closeModel()"
          style="margin-left:10px"
        >Close</b-button>
        <b-button
          v-if="file!=null && !isNotCsv"
          class="float-right"
          @click="RegisteringStudent"
          size="sm"
          variant="primary"
        >Submit</b-button>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // show: false,
      file: null,
      dataPac: {
        file: ""
      },
      headers: "",
      body: "",
      year: "",
      isTablePrivew: false,
      modalShow: false,
      isNotCsv:false
    };
  },
  props: ["show", "dataSet", "dep", "sem", "batch"],

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

  methods: {
    uploadFile() {
      this.isTablePrivew = true;
      this.isNotCsv=false;
      // console.log(this.file);
      let formData = new FormData();
      formData.append("file", this.file);
      this.$http.post("http://127.0.0.1:8000/api/temp", formData).then(
        function(response) {
          // Success
          //  console.log(response.body)
          this.headers = response.body.fuckMe.Headers;
          this.body = response.body.fuckMe.body;
        },
        function() {
          // Error
          //  console.log(response.data)
        }
      );
    },
    RegisteringStudent() {
      // console.log(this.file);
      let formData = new FormData();
      formData.append("file", this.file);
      formData.append("dep", this.dep);
      formData.append("sem", this.sem);
      formData.append("batch", this.batch); //this.dataSet.courceCode
      formData.append("code", this.dataSet.courceCode); //this.dataSet.courceCode

      this.$http
        .post("http://127.0.0.1:8000/api/uploadingResults", formData)
        .then(function() {
          this.$emit("close_model");
          this.modalShow = true;
        });
    },
    closeModel() {
      this.$emit("close_model");
    }
  }
};
</script>