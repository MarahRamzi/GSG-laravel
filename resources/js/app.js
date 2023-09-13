import Echo from 'laravel-echo';
import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

Echo.private('classroom.' + classroomId ) //determine channel
   .listen('.classwork-created' , function(event){ // event object contain data
        alert(event.title);  //object.property
   });

//    لارفيل دايما تفترض انو هاد event
// تابعة لل namespace => App\Events\name(classwork-created)
// واحنا اصلا عاملين customize event name in channel
// الحل احط . => before event name => مشان م يحط prefix

Echo.private('App.Models.User.' + userId ) //determine channel
   .notification(function(event){
        alert(event.body);
   });
