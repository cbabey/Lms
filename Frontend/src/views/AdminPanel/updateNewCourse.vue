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

    <b-modal v-model="active" title="Modal Variants" centered size="lg" @hide="closeModel">
      <b-container fluid>
        <section class="modal-card-body">
          <form>
            <div class="modal-body row">
              <div class="col">Department :{{dep}}</div>
              <div class="col">Semester : {{sem}}</div>
              <div
                v-if="courceData.type!=''  "
                class="col"
              >{{courceData.type}} Bucket:{{courceData.bucktNo}}</div>
            </div>
            <div class="modal-body row">
              <div class="col">
                <div class="form-group" :class="{coCode: !errorCoursbool}">
                  <label for="exampleFormControlFile1">Cource Code</label>
                  <input
                    class="form-control form-control-sm"
                    id="courceCode"
                    type="text"
                    placeholder="Ex : CO2233"
                    @input="checkCourceCodeValidity"
                    v-model="courceData.courceCode"
                  />
                </div>
              </div>
              <div class="col">
                <div class="form-group" :class="{title1: !errorTit}">
                  <label for="exampleFormControlFile1">Title</label>
                  <input
                    class="form-control form-control-sm"
                    type="text"
                    placeholder="Database Management"
                    @input="checkValidationTitle"
                    v-model="courceData.title"
                  />
                </div>
              </div>
            </div>
            <div class="modal-body row">
              <div class="col-md-6">
                <div class="form-group" :class="{crd: !errorCr}">
                  <label for="exampleFormControlFile1">Credits</label>
                  <input
                    class="form-control form-control-sm"
                    type="text"
                    placeholder="2"
                    @input="checkValidationCr"
                    v-model="courceData.credit"
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleFormControlFile1">GPA contribution</label>
                  <br />
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="inlineRadioOptions"
                      id="inlineRadio1"
                      value="option1"
                      @click="courceData.gpaContribution=1"
                      :checked="courceData.gpaContribution==1"
                    />
                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="inlineRadioOptions"
                      id="inlineRadio2"
                      value="option2"
                      @click="courceData.gpaContribution=0"
                      :checked="courceData.gpaContribution==0"
                    />
                    <label class="form-check-label" for="inlineRadio2">No</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-body row">
              <div class="col-5">
                <div>
                  <div v-for="temp in selectedPrevisit" :key="temp">
                    <div class="row">
                      <button
                        type="button"
                        class="close"
                        aria-label="Close"
                        @click="deletePreVisit(temp)"
                      >
                        {{temp}}
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlFile1">Prereque Visit</label>

                  <div class="dropdown show">
                    <b-dropdown id="dropdown-1" text="Dropdown Button" class="m-md-2">
                      <div v-for="obj in allPreVisit" :key="obj.courceCode">
                        <b-dropdown-item @click="selectPreVisit(obj.courceCode)">{{obj.courceCode}}</b-dropdown-item>
                      </div>
                    </b-dropdown>
                  </div>
                </div>
              </div>
              <div class="col-5">
                <div>
                  <div v-for="temp in selectedMinors" :key="temp">
                    <div class="row">
                      <button
                        type="button"
                        class="close"
                        aria-label="Close"
                        @click="deleteMinor(temp)"
                      >
                        {{temp}}
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlFile1">Select Minor</label>
                  <div class="dropdown show">
                    <!-- <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Dropdown link
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <div v-for="obj in allminors">
                                                <a class="dropdown-item" @click="selectMinor(obj.name)">{{obj.name}}</a>
                                            </div>
                                            
                    </div>-->
                    <b-dropdown id="dropdown-1" text="Dropdown Button" class="m-md-2">
                      <div v-for="obj in allminors" :key="obj.name">
                        <b-dropdown-item @click="selectMinor(obj.name)">{{obj.name}}</b-dropdown-item>
                      </div>
                    </b-dropdown>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </section>
      </b-container>

      <div slot="modal-footer" class="w-100">
        <!-- <p class="float-left">Modal Footer Content</p> -->
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="closeModel"
          style="margin-left:6px"
        >close</b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="updataDatabase"
          :class="{disabled:(!errorCoursbool || !errorCr || !errorTit)}"
        >Update</b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="refreshModel"
          style="margin-right:6px"
        >Refresh</b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="deleteCourse"
          style="margin-right:6px"
        >Delete</b-button>
      </div>
    </b-modal>
  </div>
</template>

<script>
import { required, email } from "vuelidate/lib/validators";
// import {bus} from '../../main.js';
export default {
  props: ["active", "dataSet", "dep", "sem"],
  watch: {
    active() {
      this.refreshModel();
    }
  },
  data() {
    return {
      int: 0,
      modalShow: false,
      printit: "",
      errorCoursTx: "",
      errorCoursbool: true,
      errorTit: true,
      errorCr: true,
      allPreVisit: [],
      allminors: [],
      selectedMinors: [],
      selectedPrevisit: [],
      courceData: {
        courceCode: "",
        title: "",
        Compulsory: 1,
        credit: "",
        gpaContribution: 1,
        preVisit: [],
        minors: [],
        sem: "",
        bucktNo: "",
        depCode: "",
        type: ""
      }
    };
  },
  validations: {
    courceCode: {
      required,
      email
    }
  },
  created() {
    //  this.formType=this.$route.params.sem;
    this.$http
      .get("http://127.0.0.1:8000/api/getAllCo/CO/7")
      .then(function(response) {
        this.allPreVisit = response.body.allCo;
        // console.log(this.allSem[0].sdid);
        // this.callSemster(this.allSem[0].sdid);
      });
    this.$http
      .get("http://127.0.0.1:8000/api/getselMin/CO")
      .then(function(response) {
        this.allminors = response.body.allCo;
        // console.log(this.allSem[0].sdid);
        // this.callSemster(this.allSem[0].sdid);
      });
    //console.log(this.dataSet.courceCode);

    //this.courceData.courceCode=this.dataSet.courceCode;
    //
    //value =this.allSem[0].sem_number;
    //console.log(value);

    //this.callSemster(this.allSem[0].sdid);
    this.updateModel();
  },
  mounted() {
    //  console.log('hello');
    // this.bus.$on('submit', this.submit)
  },
  methods: {
    closeModel() {
      this.$emit("close_model");
    },
    updateModel() {
      //  this.courceData.courceData=this.dataSet.courceCode;
      //    console.log('hello-12312');
    },
    submit() {
      this.int++;
    },
    deleteCourse() {
      this.courceData.preVisit = this.selectedPrevisit;
      this.courceData.minors = this.selectedMinors;
      //console.log( this.courceData);
      this.$http
        .post("http://127.0.0.1:8000/api/DeleteCourseFromosem", this.courceData)
        .then(function() {
          // Success
          //  console.log(response.data)
          this.closeModel();
          this.printit = "Deleted Compileted";
          this.modalShow = true;
        });
    },
    //refreshing model
    update() {
      this.selectedMinors = [];
      this.courceData.sem = this.sem;
      this.courceData.depCode = this.dep;
      this.courceData.courceCode = this.dataSet.courceCode;
      this.courceData.title = this.dataSet.title;
      this.courceData.credit = this.dataSet.credits;
      this.courceData.gpaContribution = this.dataSet.gpaContribution;
      // console.log(this.dataSet.name);
      if (this.dataSet.name != null) {
        var array = this.dataSet.name.split(" / ");
        // this.selectedMinors.push(array);
        array.forEach(element => {
          this.selectedMinors.push(element);
        });
      }

      this.courceData.bucktNo = this.dataSet.buctNumber;
      if (this.dataSet.type == "E") {
        this.courceData.type = "Elective";
      } else if (this.dataSet.type == "O") {
        this.courceData.type = "Optional";
      } else {
        this.courceData.type = "";
      }

      //this.selectedMinors.push(name);
    },

    updataDatabase() {
      this.courceData.preVisit = this.selectedPrevisit;
      // this.courceData.minors=this.selectMinor;
      // console.log( this.courceData);
      this.$http
        .post("http://127.0.0.1:8000/api/tt", this.courceData)
        .then(function() {
          // Success
          //  console.log(response.data)

          this.closeModel();
          this.printit = "Updated Compileted";
          this.modalShow = true;
        });
    },
    refreshModel() {
      this.update();
    },

    //validation part
    checkCourceCodeValidity() {
      const CODE_PATTERN = /^([A-Z]{2}[0-9]{4})$/;

      if (this.courceData.courceCode == "") {
        this.errorCoursTx = "Filed is empty";
        this.errorCoursbool = false;
      } else if (!CODE_PATTERN.test(this.courceData.courceCode)) {
        this.errorCoursTx = "Filed is Not Compitible";
        this.errorCoursbool = false;
      } else {
        this.errorCoursTx = "";
        this.errorCoursbool = true;
      }
    },
    checkValidationTitle() {
      if (this.courceData.title == "") {
        this.errorTit = false;
      } else {
        this.errorTit = true;
      }
    },
    checkValidationCr() {
      const CODE_PATTERN = /^([0-9])$/;
      if (
        this.courceData.credit == "" ||
        !CODE_PATTERN.test(this.courceData.credit)
      ) {
        this.errorCr = false;
      } else {
        this.errorCr = true;
      }
    },
    selectMinor(name) {
      var temp = true;
      this.selectedMinors.forEach(element => {
        if (element == name) {
          temp = false;
        }
      });
      if (temp) {
        this.selectedMinors.push(name);
      }
    },
    selectPreVisit(name) {
      var temp = true;
      this.selectedPrevisit.forEach(element => {
        if (element == name) {
          temp = false;
        }
      });
      if (temp) {
        this.selectedPrevisit.push(name);
      }
    },
    deletePreVisit(name) {
      var index = this.selectedPrevisit.indexOf(name);
      if (index > -1) {
        this.selectedPrevisit.splice(index, 1);
      }
    },
    deleteMinor(name) {
      var index = this.selectedMinors.indexOf(name);
      if (index > -1) {
        this.selectedMinors.splice(index, 1);
      }
    }
  }
};
</script>

<style>
.coCode input {
  border: 2px solid red;
  background-color: #ffc9aa;
}

.title1 input {
  border: 2px solid red;
  background-color: #ffc9aa;
}

.crd input {
  border: 2px solid red;
  background-color: #ffc9aa;
}
</style>
