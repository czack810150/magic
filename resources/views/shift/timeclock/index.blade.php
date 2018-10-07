<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Magic Shift - Clock</title>
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
    <div class="container" v-if="forgotten">
        <div class="columns">
            <div class="column is-half is-offset-3">
     <article class="message is-warning" >
  <div class="message-header">
    <p>忘记提示</p>
    
  </div>
  <div class="message-body">
    <p>此上班记录（@{{forgotten.clockIn}}）没有相应的下班记录。请先填写忘记打卡记录表并通知店长。</p>
  </div>
  
</article></div></div></div>

    <div class="container" v-show="cardScan">
        <div class="columns" >
        <div class="column is-half is-offset-3">
            <div class="box">
        <form v-on:submit.prevent="submitClock">
            <div class="field">
            <p class="control has-icons-left">
            <input ref="cardReader" v-model="employeeId" class="input is-large" type="password" placeholder="Scan your employee card here" autofocus required autocomplete="off">
            <span class="icon is-large is-left"><i class="fas fa-barcode"></i></span>
            </p>
            </div>    

        <button type="submit" class="button is-large" v-bind:class="inClass" >@{{inOut?'In':'Out' }}</button>
        <button type="submit" class="button is-light is-large" @click="cancel">Cancel</button>
       
        </form>
            </div>
        </div>
        </div>
    </div>


    <div class="container" v-show="showMessage">
        <div class="columns">
            <div class="column is-half is-offset-3">
    <article class="message" :class="messageClass">
  <div class="message-header">
    <p v-text="messageTitle"></p>
    
  </div>
  <div class="message-body is-size-4" >
  <span v-html="messageBody"></span>
  <br>
  <div v-if="shifts.length">
  本日排班：
  <br>
  <ul>
  <li v-for="shift in shifts">开始： @{{shift.start}}<br> 
  结束： @{{shift.end}}<br> 
  工位： @{{shift.role.c_name}}<br> 
  职责： @{{shift.duty?shift.duty.cName:'无'}}<br>
  @{{shift.comment?'Message:'+shift.comment:''}}<br>
  @{{greeting}}
   </li>
  </ul>
  </div>
  <div v-else>
  
  </div>
  </div>
  <br>
  <button type="button" class="button is-primary is-large" @click="finish"> OK</button>
  <br>
</article>
<br>
 <article class="message" v-if="records.length" >
  <div class="message-header">
    <p>本日打卡记录</p>
    
  </div>
  <div class="message-body">
<table class="table">
<thead><th>ClockIn</th><th>ClockOut</th></thead>
<tbody>
<tr v-for="record in records">
<td v-text="record.clockIn"></td>
<td v-text="record.clockOut"></td>
</tr>
</tbody>
   
</table>
  </div>
  
</article>
            </div>
        </div>
    </div>


  </section>
  <footer class="footer" style="position:relative ; bottom:0;width:100%;">
  <div class="container">
    <div class="content has-text-centered">
      <p class="has-text-grey-light is-italic has-text-weight-light">
        Copyright &copy; {{Carbon\Carbon::now()->year}} Jingyi Su
      </p>
    </div>
  </div>
</footer>
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
        showMessage:false,
        messageTitle:null,
        messageBody:null,
        messageClass:null,
        shifts: [],
        records: [],
        forgotten: null,
        greeting:null,
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
          focus(){this.$refs.cardReader.focus();},
          clockIn(){
              this.buttons = false
              this.cardScan = true
              this.inOut= true
              // console.log('clock in')
              vm.focus();
          },
          clockOut() {
              this.buttons = false
              this.inOut = false
              this.cardScan = true
              this.$refs.cardReader.focus();
          },
          cancel(){
              this.cardScan = false
              this.buttons = true
              this.employeeId = ''
          },
          submitClock(e){
              
              if(this.employeeId!=''){
                //e.preventDefault()
                var link = '';
                var inOut = '';
                if(this.inOut)
                {
                    link = '/timeclock/in'
                    inOut = 'in';
                } else {
                    link = '/timeclock/out'
                    inOut = 'out';
                }


                axios.post(link,{
                    _token:'{{csrf_token()}}',
                    employeeCard: this.employeeId,
                    inOut: this.inOut
                }).then(response => {
                    // console.log(response.data);
                    switch(response.data.status){
                        case 'success':
                            this.messageClass = 'is-success';
                            break;
                        case 'danger':
                            this.messageClass = 'is-danger';
                            break;
                        case 'warning':
                            this.messageClass = 'is-warning';
                            break;
                        case 'info':
                            this.messageClass = 'is-info';
                            break;
                        case 'link':
                            this.messageClass = 'is-link';
                            break;
                        default:
                            this.messageClass = null;
                    }
                  
                    this.messageTitle = response.data.messageTitle;
                    this.messageBody = response.data.message;
                    this.shifts = response.data.shifts;
                    this.records = response.data.records;
                    this.forgotten = response.data.forgotten;
                    this.greeting = response.data.greeting;
                    this.showMessage=true;
                    
                }).catch(error => {
                    this.messageClass='is-danger';
                    this.messageTitle = 'System Error';
                    this.messageBody = response.error;
                    this.showMessage=true;
                })

                // console.log('submit');
                this.employeeId = '';
                this.cardScan = false;
                

              } else {
                  alert('You must scan your card!');
              }
            },
            finish(){
                this.employeeId = '';
                this.showMessage = false;
                this.cardScan = false;
                this.buttons = true;
                this.messageTitle = null;
                this.messageBody = null;
                this.messageClass = null;
                this.forgotten = null;
                this.greeting = null;
                this.shifts = [];
                this.recoreds = [];
          }
        
      }
  })
 
function updateTime() {
            vm.currentTime =  moment().format('dddd, MMMM Do YYYY, h:mm:ss a');
            
          }

  </script>
  </body>
</html>