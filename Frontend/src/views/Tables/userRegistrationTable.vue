<template>
  <div class="card shadow" :class="type === 'dark' ? 'bg-default': ''">
    <div class="card-header border-0" :class="type === 'dark' ? 'bg-transparent': ''">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0" :class="type === 'dark' ? 'text-white': ''">{{title}}</h3>
        </div>
        <div class="col text-right">
          <base-button type="primary" size="sm">See all</base-button>
        </div>
      </div>
    </div>

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

    <div class="table-responsive">
      <base-table
        class="table align-items-center table-flush"
        :class="type === 'dark' ? 'table-dark': ''"
        :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
        tbody-classes="list"
        :data="tableData"
      >
        <template slot="columns">
          <th>Department</th>
          <th>HOD name</th>
          <th>Email address</th>
          <!-- <th>Password</th> -->
          <th>Edit</th>
          <th></th>
        </template>

        <template slot-scope="{row}">
          <th scope="row">
            <div class="media-body">
              <span class="name mb-0 text-sm">{{row.Name}}</span>
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
            <span v-if="row.email!=null" class="status">{{row.name}}</span>
            <span v-if="row.email==null" class="status">--</span>
          </td>
          <td>
            <badge class="badge-dot mr-4" :type="row.statusType">
              <i :class="`bg-${row.statusType}`"></i>
              <span v-if="row.email!=null" class="status">{{row.email}}</span>
              <span v-if="row.email==null" class="status">--</span>
            </badge>
          </td>

          <td class="budget">
            <b-button
              v-if="row.email!=null"
              variant="outline-primary"
              @click="lonchingModel(row)"
            >Update</b-button>
            <b-button
              v-if="row.email==null"
              @click="addingValue(row.dep_code,row.Name)"
              variant="outline-primary"
            >Add</b-button>
          </td>
        </template>
      </base-table>
      <!-- <b-button @click="showUpdate=true" variant="primary">Show Modal</b-button> -->
      <!-- Model start-->
      <b-modal v-model="show" title="Modal Variants" size="lg">
        Department : {{Name}}
        <b-container fluid>
          <b-alert :show="isValid" variant="warning">Email is alradey exsists</b-alert>

          <b-form @submit="onSubmit" @reset="onReset" v-if="show">
            <b-form-group id="input-group-2" label="HOD Name:" label-for="input-2">
              <b-form-input id="input-2" v-model="form.name" required placeholder="Enter name"></b-form-input>
            </b-form-group>

            <b-form-group
              id="input-group-1"
              label="Email address:"
              label-for="input-1"
              description="We'll never share your email with anyone else."
            >
              <b-form-input
                id="input-1"
                v-model="form.email"
                type="email"
                required
                placeholder="Enter email"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              id="input-group-1"
              label="Password:"
              label-for="input-1"
              description=" Your password must be 6-20 characters long, contain letters and numbers, and must not
      contain spaces, special characters, or emoji."
            >
              <b-form-input
                id="input-1"
                v-model="form.password"
                type="password"
                required
                placeholder="Enter Password"
              ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-1" label="Conform Password:" label-for="input-1">
              <b-form-input
                id="input-1"
                v-model="form.c_password"
                type="password"
                required
                placeholder="Enter Password"
                :state="validation"
              ></b-form-input>
              <!-- <b-alert show variant="danger">Danger Alert</b-alert> -->
              <b-form-invalid-feedback
                :state="validation"
              >Your user ID must be 5-12 characters long.</b-form-invalid-feedback>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <!-- <b-button type="reset" variant="danger">Reset</b-button> -->
          </b-form>
        </b-container>

        <div slot="modal-footer" class="w-100">
          <!-- <p class="float-left">Modal Footer Content</p>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="show=false"
        >
          Close
          </b-button>-->
        </div>
      </b-modal>

      <!-- update Model Start -->
      <b-modal v-model="showUpdate" title="Modal Variants" size="lg">
        <b-alert :show="isValid" variant="warning">Email is alradey exsists</b-alert>
        Department : {{Name}}
        <b-container fluid>
          <b-form @submit="onSubmit2" @reset="onReset" v-if="showUpdate">
            <b-form-group id="input-group-2" label="HOD Name:" label-for="input-2">
              <b-form-input id="input-2" v-model="form.name" required placeholder="Enter name"></b-form-input>
            </b-form-group>

            <b-form-group
              id="input-group-1"
              label="Email address:"
              label-for="input-1"
              description="We'll never share your email with anyone else."
            >
              <b-form-input
                id="input-1"
                v-model="form.email"
                type="email"
                required
                placeholder="Enter email"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              id="input-group-1"
              label="Password:"
              label-for="input-1"
              description=" Your password must be 6-20 characters long, contain letters and numbers, and must not
      contain spaces, special characters, or emoji."
            >
              <b-form-input
                id="input-1"
                v-model="form.password"
                type="password"
                required
                placeholder="Enter Password"
              ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-1" label="Conform Password:" label-for="input-1">
              <b-form-input
                id="input-1"
                v-model="form.c_password"
                type="password"
                required
                placeholder="Enter Password"
                :state="validation"
              ></b-form-input>
              <!-- <b-alert show variant="danger">Danger Alert</b-alert> -->
              <b-form-invalid-feedback
                :state="validation"
              >Your user ID must be 5-12 characters long.</b-form-invalid-feedback>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <!-- <b-button type="reset" variant="danger">Reset</b-button> -->
          </b-form>
        </b-container>

        <div slot="modal-footer" class="w-100">
          <!-- <p class="float-left">Modal Footer Content</p>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="show=false"
        >
          Close
          </b-button>-->
        </div>
      </b-modal>
    </div>

    <!-- <div class="card-footer d-flex justify-content-end"
         :class="type === 'dark' ? 'bg-transparent': ''">
      <base-pagination total="30"></base-pagination>
    </div>-->
  </div>
</template>
<script>
export default {
  name: "projects-table",
  props: {
    type: {
      type: String
    },
    title: String
  },
  created() {
    //http://localhost:8000/api/
    // console.log(this.$session.get('jwt'));
    this.retriving();
  },
  computed: {
    validation() {
      return this.form.password == this.form.c_password;
    }
  },
  watch: {
    show() {
      this.retriving();
    }
  },
  data() {
    return {
      tableData: [],
      show: false,
      showUpdate: false,
      form: {
        email: "",
        name: "",
        password: "",
        c_password: "",
        dep_code: "",
        oldEmail: ""
      },
      Name: "bla bla",
      modalShow: false,
      printit: "",
      isValid: false
    };
  },
  methods: {
    lonchingModel(row) {
      this.form.email = row.email;
      this.form.oldEmail = row.email;
      this.form.name = row.name;
      this.form.dep_code = row.dep_code;
      this.Name = row.Name;
      this.showUpdate = true;
    },
    retriving() {
      if (this.$session.get("jwt") == null) {
        this.$router.push("/login");
      }
      this.$http
        .get("http://127.0.0.1:8000/api/getAdminDetails", {
          headers: {
            Authorization: "Bearer " + this.$session.get("jwt")
          }
        })
        .then(response => {
          //  console.log(response.body)
          this.tableData = response.body.users;
        });
    },
    addingValue(dep_code, Name) {
      this.Name = Name;
      this.form.dep_code = dep_code;
      this.show = true;
    },
    onSubmit(evt) {
      evt.preventDefault();
      this.$http
        .post("http://127.0.0.1:8000/api/userRegistration", this.form)
        .then(
          response => {
            //  console.log(response.body)
            // this.tableData=response.body.users;
            this.modalShow = true;
            this.show = false;
            this.printit = "User Registartion is "+response.body.success;
            this.isValid = false;
            this.retriving();
          },
          function() {
            // console.log("errot---------");
            this.isValid = true;
          }
        );
      //alert(JSON.stringify(this.form))
    },
    onSubmit2(evt) {
      evt.preventDefault();
      this.$http.post("http://127.0.0.1:8000/api/UpdatingUser", this.form).then(
        response => {
          //  console.log(response.body)
          // this.tableData=response.body.users;
          this.modalShow = true;
          this.showUpdate = false;
          this.printit = "User Updated is "+response.body.success;
          this.isValid = false;
          this.retriving();
          // console.log(response.body);
        },
        function() {
          // console.log("errot---------");
          this.isValid = true;
        }
      );
      //alert(JSON.stringify(this.form))
    },
    onReset(evt) {
      evt.preventDefault();
      // Reset our form values
      this.form.email = "";
      this.form.name = "";
      this.form.food = null;
      this.form.checked = [];
      this.isValid = false;
      // Trick to reset/clear native browser form validation state
      this.show = false;
      this.$nextTick(() => {
        this.show = true;
      });
    }
  }
};
</script>
<style>
</style>
