<template>
  <div>
    <!-- <b-button @click="show=true" variant="primary">Show Modal</b-button> -->

    <b-modal v-model="show" title="Uploading Results" size="lg">
      <b-container fluid>
        <b-alert
          :show="isadone"
          
          variant="success"
        >This alert will dismiss after {{ warningMessage }} seconds...</b-alert>
         <b-alert
          :show="isaError"
          
          variant="warning"
        >This alert will dismiss after {{ warningMessage }} seconds...</b-alert>
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

        <div style=" height:  700px; overflow-y: auto;">
          <b-container>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th scope="col">Index No</th>
                  <th scope="col">Results</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(i,k) in results " :key="k">
                  <td>{{i.indexNo}}</td>
                  <td v-if="!isVisbletoEdit[k]">{{i.result}}</td>
                  <td scope="col" v-if="isVisbletoEdit[k]">
                    <b-row>
                      <b-col cols="3">
                        <b-form>
                          <b-form-input style="width:50px" v-model="i.result"></b-form-input>
                        </b-form>
                      </b-col>
                      <b-col cols="1">
                        <a href style="color:red">
                          <i class="material-icons">delete</i>
                        </a>
                      </b-col>
                    </b-row>
                    <!-- <input type="text" v-model="i.results"> -->
                  </td>
                  <td>
                    <b-button v-if="!isVisbletoEdit[k]" variant="dark" @click="open(k)">Edit</b-button>
                    <b-button
                      v-if="isVisbletoEdit[k]"
                      variant="dark"
                      @click="updateResults(k,i.indexNo,i.result)"
                    >Submit</b-button>
                    <b-button v-if="isVisbletoEdit[k]" variant="dark" @click="close(k)">Cancel</b-button>
                  </td>
                </tr>
              </tbody>
            </table>
          </b-container>
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
        <!-- <b-button class="float-right" @click="RegisteringStudent" size="sm" variant="primary">Submit</b-button> -->
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
      results: [],
      isVisbletoEdit: [],
      warningMessage:"Your Input is not Valied Pleas recheck",
      isaError:false,
      isadone:false
    };
  },
  props: ["show", "dataSet", "dep", "sem", "batch"],
  watch: {
    show() {
      this.resultsGet();
    }
  },
  created() {
    this.edtingDisableVCreating();
  },

  methods: {
    edtingDisableVCreating() {
      for (let index = 0; index < 300; index++) {
        //  console.log("Index "+index)
        this.isVisbletoEdit.push(false);
      }
    },
    open(k) {
      // console.log("value "+k)
      // console.log(this.isVisbletoEdit[k])
       this.isaError=false;
        this.isadone=false;
      this.isVisbletoEdit[k] = true;
      // console.log(this.isVisbletoEdit[k])
      this.resultsGet();
    },
    close(k) {
      //  console.log("value "+k)
      //console.log(this.isVisbletoEdit[k])
      this.isVisbletoEdit[k] = false;
      // console.log(this.isVisbletoEdit[k])
      this.isaError=false;
        this.isadone=false;
      this.resultsGet();
    },
    resultsGet() {
      //  console.log(this.file);
      let formData = new FormData();
      // formData.append('file', this.file);
      formData.append("dep", this.dep);
      formData.append("sem", this.sem);
      formData.append("batch", this.batch); //this.dataSet.courceCode
      formData.append("code", this.dataSet.courceCode); //this.dataSet.courceCode

      this.$http
        .post("http://127.0.0.1:8000/api/getSubjectResult", formData)
        .then(
          function(response) {
            // Success
            this.results = response.body.reults;

            //  console.log(response.body)
            // this.headers=response.body.fuckMe.Headers;
            // this.body=response.body.fuckMe.body;
            //alert(response.body);
          },
          function() {
            // Error
            //  console.log(response.data)
          }
        );
    },
    updateResults(k, index, res) {
      //console.log(this.file);
      let formData = new FormData();
      // console.log(res);
      if (
        res == "A+" ||
        res == "A" ||
        res == "A-" ||
        res == "B+" ||
        res == "B" ||
        res == "B-" ||
        res == "C+" ||
        res == "C" ||
        res == "R" ||
        res == "F"
      ) {
        formData.append("index", index); //this.dataSet.courceCode
        formData.append("code", this.dataSet.courceCode); //this.dataSet.courceCode
        formData.append("res", res); //this.dataSet.courceCode

        this.$http
          .post("http://127.0.0.1:8000/api/updateResult", formData)
          .then(
            function() {
              this.resultsGet();
              this.isadone=true;
              this.isaError=false;
            },
            function() {
              // Error
              // console.log(response.data);
            }
          );
        this.close(k);
      } else {
        this.isaError=true;
        this.isadone=false;
      }
    },
    uploadFile() {
      this.isTablePrivew = true;
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
        .then(
          function(response) {
            // Success
            //  console.log(response.body)
            // this.headers=response.body.fuckMe.Headers;
            // this.body=response.body.fuckMe.body;
            alert(response.body);
          },
          function() {
            // Error
            //  console.log(response.data)
          }
        );
    },
    closeModel() {
      this.$emit("close_model");
    }
  }
};
</script>

<style scoped>
.abc {
}
</style>
