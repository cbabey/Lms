<template>
  <div>
    <base-header type="gradient-success" class="pb-6 pb-8 pt-5 pt-md-6"></base-header>

    <b-container fluid>
      <div class="container-fluid mt--7">
        <div class="row">
          <div class="col">
            <div class="card shadow border-0">
              <div
                id="map-canvas"
                class="map-canvas"
                data-lat="40.748817"
                data-lng="-73.985428"
                style="height: 2900px;"
              >
                <!-- <h1>result Uploding</h1> -->
                <!-- <res-up></res-up> -->
                <!-- <up-res></up-res> -->
                <b-container>
                  <br>
                  <br>

                  <b-alert variant="success" show style="text-align:center; font-size:28px">You don't have repeated Subjects</b-alert>
                </b-container>
                
              
                <div v-if="dataSet.length!=0"  class="card shadow" :class="type === 'dark' ? 'bg-default': ''">
                  <div class="card-header border-0" :class="type === 'dark' ? 'bg-transparent': ''">
                    <div class="row align-items-center">
                      <div class="col">
                        <h3 class="mb-0" :class="type === 'dark' ? 'text-white': ''">{{titile}}</h3>
                      </div>
                      <div class="col text-right">
                        <!-- <base-button type="primary" size="sm">See all</base-button> -->
                      </div>
                    </div>
                  </div>
<!-- <H1>asjda;sld</H1> -->
                  <div class="table-responsive">
                    <base-table
                      class="table align-items-center table-flush"
                      :class="type === 'dark' ? 'table-dark': ''"
                      :thead-classes="type === 'dark' ? 'thead-dark': 'thead-light'"
                      tbody-classes="list"
                      :data="dataSet"
                    >
                      <template slot="columns">
                        <th>Cource Code</th>
                        <th>Title</th>
                        <th>Semster subject counducted</th>
                        <th>Result</th>
                        <!-- <th>Completion</th> -->
                        <th></th>
                      </template>

                      <template slot-scope="{row}">
                        <th scope="row">
                          <div class="media-body">
                            <span class="name mb-0 text-sm">{{row.couceCode}}</span>
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
                        <td class="budget">{{row.title}}</td>
                        <td class="budget">{{row.sem_number}}</td>
                        <td class="budget">{{row.result}}</td>
                      </template>
                    </base-table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-container>
  </div>
</template>
<script>
// import resultUpload from './AdminPanel/StudentRegistation/studentRegstariontoFac.vue'
// import uplodResult from './AdminPanel/Results/DhUploadResults'
export default {
  components: {
    // 'res-up':resultUpload,
    // 'up-res':uplodResult
  },
  data() {
    return {
      type: "",
      titile: "Repeated Cources",
      dataSet: []
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
    }
  },
  mounted() {
    this.$http
      .get("http://localhost:8000/api/getAllRepeatedSubjects/"+this.testing())
      .then(function(response) {
        this.dataSet = response.body.value;
        
        // console.log(this.dataSet.length);
        // this.callSemster(this.allSem[0].sdid);
      });

    //   let google= window.google
    //   let map = document.getElementById('map-canvas');
    //   let lat = map.getAttribute('data-lat');
    //   let lng = map.getAttribute('data-lng');

    //   const myLatlng = new google.maps.LatLng(lat, lng);
    //   const mapOptions = {
    //     zoom: 12,
    //     scrollwheel: false,
    //     center: myLatlng,
    //     mapTypeId: google.maps.MapTypeId.ROADMAP,
    //     styles: [
    //       {"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},
    //       {"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},
    //       {"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},
    //       {"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},
    //       {"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},
    //       {"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
    //       {"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},
    //       {"featureType":"water","elementType":"all","stylers":[{"color":'#5e72e4'},{"visibility":"on"}]}]
    //   }

    //   map = new google.maps.Map(map, mapOptions);

    //   const marker = new google.maps.Marker({
    //     position: myLatlng,
    //     map: map,
    //     animation: google.maps.Animation.DROP,
    //     title: 'Hello World!'
    //   });

    //   const contentString = '<div class="info-window-content"><h2>Argon Dashboard</h2>' +
    //     '<p>A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</p></div>';

    //   const infowindow = new google.maps.InfoWindow({
    //     content: contentString
    //   });

    //   google.maps.event.addListener(marker, 'click', function() {
    //     infowindow.open(map, marker);
    //   });
  }
};
</script>
<style>
</style>
