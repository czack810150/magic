<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clock In Clock Out</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  </head>
  <body >
  <section class="section" id="root">
    <div class="container has-text-centered">
  
        <img class="is-centered" src="{{url('img/logo643x228.png')}}" height="228" width="643">


      <h1 class="title">
        @{{currentTime}}
      </h1>
      <p class="subtitle">
      {{$location->name}}, <strong>{{$location->city}}</strong>
      </p>

    <div class="columns" v-show="buttons">
        <div class="column is-half is-offset-3">
    <div class="box">
        <div class="columns">
            <div class="column">
        <button class="button is-primary is-large" @click="clockIn"> <span class="icon">
      <i class="fas fa-sign-in-alt"></i>
    </span><span>Clock In</span></button>
            </div>
            <div class="column">
        <button class="button is-danger is-large" @click="clockOut"><span class="icon">
      <i class="fas fa-sign-out-alt"></i>
    </span><span>Clock Out</span></button>
            </div>
    </div>
        </div>
    </div>
    </div>



    <div class="container">
    <div class="columns" v-show="cardScan">
        <div class="column is-half is-offset-3">
            <div class="box">

            <div class="field">
            <p class="control has-icons-left">
            <input v-model="employeeId" class="input is-large is-focused" type="password" placeholder="Scan your employee card here" required>
            <span class="icon is-large is-left"><i class="fas fa-barcode"></i></span>
            </p>
            </div>    

        <button type="button" class="button is-large" v-bind:class="inClass" @click="submitClock">@{{inOut?'In':'Out' }}</button>
        <button type="submit" class="button is-light is-large" @click="cancel">Cancel</button>
            </div>
        </div>
    </div>
    </div>


  </section>
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script>
  var vm = new Vue({
      el: '#root',
      data:{
        currentTime: moment().format('dddd, MMMM Do YYYY, h:mm:ss a'),
        buttons: true,
        cardScan:false,
        employeeId:'',
        inOut:false,
      
      },
      computed:{
          inClass(){
              if(this.inOut){
                  return 'is-link'
              } else {
                  return 'is-danger'
              }
          }
      },
      mounted(){
        setInterval(updateTime,500);
      },
        
      methods: {
          clockIn(){
              this.buttons = false
              this.cardScan = true
              this.inOut=true
              console.log('clock in')
          },
          clockOut() {
              this.buttons = false
              this.inOut = false
              this.cardScan = true
          },
          cancel(){
              this.cardScan = false
              this.buttons = true
              this.employeeId = ''
          },
          submitClock(){
              
              if(this.employeeId!=''){

                axios.post('/test',{
                    _token:'{{csrf_token()}}'
                }).then(response => {
                    console.log(response.data)
                }).catch(error => {
                    console.log(error)
                })

                console.log('submit')
                this.employeeId = ''
                this.cardScan = false
                this.buttons = true

              } else {
                  alert('You must scan your card!')
              }
          }
        
      }
  })
 
function updateTime() {
            vm.currentTime =  moment().format('dddd, MMMM Do YYYY, h:mm:ss a')
            
          }

  </script>
  </body>
</html>