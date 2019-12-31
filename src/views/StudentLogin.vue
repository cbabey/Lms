<template>
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent pb-5">
                        <b-row>
                            <b-col cols="3">
                                <img src="img/brand/usjp.png" width="100" height="100" />
                                 <!-- <span><img src="img/brand/usjp.png" width="100" height="100" /></span> -->
                            </b-col>
                            <b-col cols="9">
                                 
                <h3 style="margin-top:10px">University Of Sri Jayawardenapura <br> Faculty of Enginerring <br></h3>
                <!-- <h3 style="font-size:14px">Admin Panel Login</h3> -->
                            </b-col>
                        </b-row>
                        <!-- <h1>skdaksdn aksdlkasd laksdkasln  </h1> -->
                        <!-- <h6>alsdhlasd ajhdsjas </h6> -->
                    </div>
                    
                    <div class="card-body px-lg-5 py-lg-5">
                        <!-- <h4>Admin Panel Login</h4> -->
                        <div class="text-center text-muted mb-4">
                            <!-- <small>Or sign in with credentials</small> -->
                            <div v-if="isError" class="alert alert-danger" role="alert">
                            Username or password wrong
                            </div>

                        </div>
                        <form role="form">
                            <base-input class="input-group-alternative mb-3"
                                        placeholder="Index Number -16/ENG/XXX"
                                        addon-left-icon="ni ni-email-83"
                                        v-model="model.email"
                                        
                                        >
                            </base-input>

                            <base-input class="input-group-alternative"
                                        placeholder="Password"
                                        type="password"
                                        addon-left-icon="ni ni-lock-circle-open"
                                        v-model="model.password">
                            </base-input>

                            <base-checkbox class="custom-control-alternative">
                                <span class="text-muted">Remember me</span>
                            </base-checkbox>
                            <div class="text-center">
                                <base-button type="primary" class="my-4" @click="login()">Sign in</base-button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="row mt-3">
                    <div class="col-6">
                        <button @click="getIT">clicked</button>
                        <a href="#" class="text-light"><small>Forgot password?</small></a>
                    </div>
                    <div class="col-6 text-right">
                        <router-link to="/register" class="text-light"><small>Create new account</small></router-link>
                    </div>
                </div> -->
            </div>
        </div>
</template>
<script>
  export default {
    name: 'login',
    data() {
      return {
        model: {
          email: '',
          password: '',

        },
        isError:false,

      }
    },
    watch:{
        email(){
            this.isError=false;
        },
    },
    methods:{
        login(){
            // console.log("sajdhasjd");
            this.$http.post('http://127.0.0.1:8000/api/studentLogin', this.model).then(function (response) {
            // Success
                //  console.log(response.body)
                 if (response.status === 200 && 'token' in response.body.success) {
                    this.$session.start()
                    this.$session.set('jwt', response.body.success.token)
                    this.$session.set('type', "SU")
                    this.$session.set('name', response.data.userName)
                    this.$session.set('year', response.data.index)
                    this.$session.set('index', response.data.index)
                    //Vue.http.headers.common['Authorization'] = 'Bearer ' + response.  body.token
                    this.$router.push('/Home')
                    }
            },function () {
    // Errorthis.
            this.isError=true;
            //  console.log(response.data)
            });
        },
        getIT(){
            // console.log('Bearer ' + this.$session.get('jwt'))
            

         this.$http.get('http://127.0.0.1:8000/api/userDetails',{
                headers: {
                'Authorization': 'Bearer ' + this.$session.get('jwt')
                }
            }
          ).then(response => {
            //    console.log(response.body)
               alert(response.body)
                
               
               

            });
        
       
        }
    }
  }
</script>
<style>
</style>
